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
    public function createCheckoutSession(Request $request)
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

            $validated = $request->validate([
                'payment_intent_id' => 'required|string',
                'firebase_uid' => 'required|string',
                'items' => 'required|array',
            ]);

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'success' => false,
                    'message' => 'O pagamento ainda não foi concluído.'
                ], 400);
            }

            // Verificar se o pagamento já foi registrado (evitar duplicação)
            if (Sale::where('stripe_payment_id', $paymentIntent->id)->exists()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pagamento já registrado anteriormente.'
                ]);
            }

            // Buscar o usuário (se existir)
            $user = User::where('firebase_uid', $request->firebase_uid)->first();

            // Registrar a venda
            foreach ($request->items as $item) {
                $product = Product::where('name', $item['name'])->first();

                Sale::create([
                    'user_id' => $user?->id,
                    'product_id' => $product?->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'stripe_payment_id' => $paymentIntent->id,
                    'status' => 'Pago',
                ]);
            }

            Log::info('✅ Venda registrada com sucesso para o pagamento: ' . $paymentIntent->id);

            return response()->json([
                'success' => true,
                'message' => 'Pagamento confirmado e vendas registradas.'
            ]);
        } catch (Exception $e) {
            Log::error('🔥 Erro ao confirmar o pagamento:', [
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
