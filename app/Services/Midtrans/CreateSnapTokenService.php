<?php

namespace App\Services\Midtrans;

use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken($name)
    {
        $user = Auth::user();
        $name = $user->NAMA;
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->KODE_TOPUP,
                'gross_amount' => abs($this->order->CREDIT),
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->order->CREDIT,
                    'quantity' => 1,
                    'name' => $name,
                ],
            ],
            'customer_details' => [
                'first_name' => $user->NAMA,
                'email' => $user->EMAIL,
                'phone' => '081234567890',
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
