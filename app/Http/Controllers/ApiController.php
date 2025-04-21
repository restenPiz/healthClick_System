<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Paymentsds\MPesa\Client;
use Illuminate\Support\Str;
use ReflectionClass;

class ApiController extends Controller
{
    public function category()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ]);
    }
    public function payment(Request $request)
    {
        try {
            Log::info('Recebendo requisição de pagamento:', $request->all());

            $transaction = Str::random(8);
            $reference = random_int(1800, 9999);

            $client = new Client([
                'apiKey' => 'ky0q9k4nqr78ske3r9h0ak6vx1mhm5z7',
                'publicKey' => 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==',
                'serviceProviderCode' => '171717',
            ]);

            $paymentData = [
                'from' => '258' . $request->numero,
                'reference' => $reference,
                'transaction' => $transaction,
                'amount' => $request->valor,
            ];

            Log::info('Enviando dados para M-Pesa:', $paymentData);

            $result = $client->receive($paymentData);
            Log::info('Resposta do M-Pesa:', (array) $result);

            // Acessar propriedades privadas do objeto usando Reflection
            $reflection = new ReflectionClass($result);
            $successProperty = $reflection->getProperty('success');
            $successProperty->setAccessible(true);
            $success = $successProperty->getValue($result);

            if ($success) {
                $user_id = $request->user_id ?? 1;
                $items = $request->items;

                Log::info('Processando itens da venda:', ['items' => $items]);

                foreach ($items as $item) {
                    $product = Product::where('product_name', trim($item['name']))->first();

                    if ($product) {
                        Log::info('Produto encontrado:', ['product_id' => $product->id, 'name' => $product->product_name]);

                        Sale::create([
                            'user_id' => $user_id,
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'sold_at' => now(),
                        ]);

                        $product->quantity -= $item['quantity'];
                        $product->save();
                    } else {
                        Log::warning('Produto não encontrado:', ['name' => trim($item['name'])]);
                    }
                }

                return response()->json(['status' => 'success']);
            } else {
                Log::warning('M-Pesa retornou falha:', ['response' => json_encode($result)]);
                return response()->json(['status' => 'failed', 'message' => 'Payment processing failed'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Erro no pagamento:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'failed', 'message' => 'Erro interno no servidor: ' . $e->getMessage()], 500);
        }
    }
}
