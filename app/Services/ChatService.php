<?php

// app/Services/Chat/ChatService.php
namespace App\Services;

use App\Models\Product;
use App\Services\OrderService;
use App\Services\SessionStateService;

class ChatService
{
    public function __construct(protected SessionStateService $sessionService, protected OrderService $orderService)
    {
    }

    public function handleMessage(string $sessionId, string $text): array
    {
        $session = $this->sessionService->get($sessionId);
        if (!$session) {
            $session = $this->sessionService->storeOrUpdate([
                'session_id' => $sessionId,
                'current_step' => 'awaiting_greeting',
            ]);
        }

        $step = $session->current_step;
        $responseText = '';
        $nextStep = $step;
        $debug = [];

        switch ($step) {
            case 'awaiting_greeting':
                if (str_contains($text, 'مرحبا')) {
                    $responseText = 'مرحبًا بك في متجرنا! ماذا ترغب أن تطلب؟';
                    $nextStep = 'awaiting_product_choice';
                } else {
                    $responseText = 'يرجى قول "مرحبا" لبدء الطلب.';
                }
                break;

            case 'awaiting_product_choice':
                $product = Product::where('name', 'like', "%$text%")->first();
                if ($product) {
                    $session->temp_product_name = $product->name;
                    $session->last_chosen_product_id = $product->id;
                    $responseText = "كم عدد قطع {$product->name} التي ترغب بها؟";
                    $nextStep = 'awaiting_quantity';
                } else {
                    $responseText = 'عذرًا، هذا المنتج غير متوفر. جرب اسمًا آخر.';
                }
                break;

            case 'awaiting_quantity':
                $quantity = (int) $text;
                if ($quantity > 0) {
                    $product = Product::find($session->last_chosen_product_id);
                    if ($product) {
                        $order = $this->orderService->store([
                            'session_id' => $session->session_id,
                            "product_id" => $product->id,
                            "quantity" => $quantity,
                        ]);
                        $responseText = "تمت إضافة {$quantity} × {$product->name} إلى طلبك. هل ترغب في إضافة منتج آخر؟ (نعم / لا)";
                        $nextStep = 'awaiting_add_another';
                    } else {
                        $responseText = 'حدث خطأ في المنتج. أعد المحاولة.';
                        $nextStep = 'awaiting_product_choice';
                    }
                } else {
                    $responseText = 'الرجاء إدخال رقم صحيح للكمية.';
                }
                break;

            case 'awaiting_add_another':
                if (strtolower($text) == 'نعم') {
                    $responseText = 'ما هو المنتج الآخر الذي ترغب في إضافته؟';
                    $nextStep = 'awaiting_product_choice';
                } else {
                    $responseText = 'هل ترغب في تأكيد الطلب؟ (نعم / لا)';
                    $nextStep = 'awaiting_confirmation';
                }
                break;

            case 'awaiting_confirmation':
                if (strtolower($text) == 'نعم') {
                    $responseText = 'تم تأكيد طلبك! شكرًا لاستخدامك متجرنا.';
                    $nextStep = 'completed';
                } else {
                    $responseText = 'تم إلغاء الطلب.';
                    $nextStep = 'cancelled';
                }
                break;

            default:
                $responseText = 'انتهت الجلسة أو حدث خطأ. يرجى البدء من جديد بقول "مرحبا".';
                $nextStep = 'awaiting_greeting';
                break;
        }

        // تحديث الجلسة
        $this->sessionService->storeOrUpdate([
            'session_id' => $session->session_id,
            'current_step' => $nextStep,
            'temp_product_name' => $session->temp_product_name,
            'temp_quantity' => $session->temp_quantity,
            'last_chosen_product_id' => $session->last_chosen_product_id,
            'last_interaction' => now(),
        ]);

        return [
            'session_id' => $session->session_id,
            'response_text' => $responseText,
            'next_step' => $nextStep,
            'current_order_summary' => $this->orderService->getOrderSummary($session->session_id),
            'products_available' => Product::lazy()->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'description' => $product->description ?? null,
                    'merchant_id' => $product->user->id,
                    'image_url' => $product->image_url ? asset('storage/' . $product->image_url) : null,
                ];
            })  ,
            'debug_info' => $debug,
        ];
    }
}
