<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class StripeController extends Controller
{
    // public function createCheckoutSession(Request $request)
    // {
    // \Illuminate\Support\Facades\Log::info('🧾 Dados recebidos do Flutter:', $request->all());

    // $validated = $request->validate([
    //     'items' => 'required|array',
    //     'items.*.name' => 'required|string',
    //     'items.*.price' => 'required|numeric',
    //     'items.*.quantity' => 'required|integer',
    //     'currency' => 'required|string',
    // ]);

    // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    // $expParts = explode('/', $request->exp);
    // if (count($expParts) !== 2) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Formato de validade inválido. Use MM/YY.',
    //     ], 422);
    // }

    // $expMonth = trim($expParts[0]);
    // $expYear = '20' . trim($expParts[1]);

    // try {
    //     // Criar token com os dados do cartão
    //     $token = Token::create([
    //         'card' => [
    //             'number' => str_replace(' ', '', $request->card_number),
    //             'exp_month' => $expMonth,
    //             'exp_year' => $expYear,
    //             'cvc' => $request->cvc,
    //             'address_zip' => $request->postal_code,
    //         ],
    //     ]);

    //     // Criar cobrança
    //     $charge = Charge::create([
    //         'amount' => $request->amount,
    //         'currency' => strtolower($request->currency),
    //         'source' => $token->id,
    //         'receipt_email' => $request->email,
    //         'description' => 'Pagamento via app Flutter',
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => '✅ Pagamento efetuado com sucesso!',
    //         'charge_id' => $charge->id,
    //     ]);
    // } catch (Exception $e) {
    //     \Illuminate\Support\Facades\Log::error('❌ Erro no pagamento Stripe: ' . $e->getMessage());

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Erro ao processar pagamento: ' . $e->getMessage(),
    //     ], 500);
    // }
    // }
    public function createPaymentIntent(Request $request)
    {
        try {
            Log::info('📥 Requisição recebida para criar Payment Intent:', $request->all());

            // Validação dos dados
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer',
                'currency' => 'required|string',
                'email' => 'required|email',
                'firebase_uid' => 'required|string',
                'amount' => 'required|numeric'
            ]);

            $transaction = Str::random(8);
            $reference = random_int(1800, 9999);

            // Definir chave secreta do Stripe
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Criar um Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => intval($request->amount), // já em centavos
                'currency' => strtolower($request->currency),
                'receipt_email' => $request->email,
                'description' => 'Pagamento via Stripe - Ref: ' . $reference,
                'metadata' => [
                    'transaction' => $transaction,
                    'reference' => $reference,
                    'firebase_uid' => $request->firebase_uid
                ],
            ]);

            Log::info('✅ Payment Intent criado:', [
                'id' => $paymentIntent->id,
                'amount' => $paymentIntent->amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment Intent criado com sucesso',
                'data' => [
                    'id' => $paymentIntent->id,
                    'clientSecret' => $paymentIntent->client_secret
                ]
            ]);
        } catch (Exception $e) {
            Log::error('🔥 Erro ao criar Payment Intent:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirmar pagamento e processar vendas (segunda etapa)
     */
    public function confirmPayment(Request $request)
    {
        try {
            Log::info('📥 Requisição recebida para confirmar pagamento:', $request->all());

            // Validação dos dados
            $validated = $request->validate([
                'payment_intent_id' => 'required|string',
                'firebase_uid' => 'required|string',
                'items' => 'required|array',
            ]);

            // Definir chave secreta do Stripe
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Recuperar o Payment Intent
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            // Verificar status do pagamento
            if ($paymentIntent->status === 'succeeded') {
                $user = User::where('firebase_uid', $request->firebase_uid)->first();

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Usuário com este Firebase UID não encontrado.'
                    ], 404);
                }

                // Processar vendas e atualizar estoque
                foreach ($request->items as $item) {
                    $product = Product::where('product_name', trim($item['name']))->first();

                    if ($product) {
                        Sale::create([
                            'user_id' => $user->id,
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'sold_at' => now(),
                        ]);

                        $product->quantity -= $item['quantity'];
                        $product->save();
                    } else {
                        Log::warning('⚠️ Produto não encontrado:', ['name' => $item['name']]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Pagamento processado com sucesso.',
                    'transaction_id' => $paymentIntent->id,
                ]);
            } else {
                Log::warning('❌ Pagamento não foi concluído:', ['status' => $paymentIntent->status]);

                return response()->json([
                    'success' => false,
                    'message' => 'Pagamento não foi concluído. Status: ' . $paymentIntent->status
                ], 400);
            }
        } catch (Exception $e) {
            Log::error('🔥 Erro ao confirmar pagamento:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }
}
