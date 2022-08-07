<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Mail\NotificationEmail;
use App\Product;
use App\Transaction;
use App\TransactionDetail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        //  Save users data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // proses checkout
        $code = 'STORE-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user']) // memanggil relasi cart
            ->where('users_id', Auth::user()->id) //user yg sedang login
            ->get();    //daftar dari cart yang sudah disimpan

        // transaction create
        $transaction = Transaction::create([
            'users_id' =>  Auth::user()->id,
            'inscurance_price' =>  0,
            'shipping_price' =>  $request->ongkir,
            'total_price' =>  $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
            'notes' => $request->comment
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(000000, 999999);
            $product = Product::findOrFail($cart->products_id)->decrement('stock', $cart->quantity);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' =>  $cart->product->id,
                'price' =>  $cart->product->price,
                'shipping_status' =>  'PENDING',
                'resi' => '',
                'code' => $trx,
                'quantity' => $cart->quantity
            ]);
        }

        //  Delete cart data
        Cart::where('users_id', Auth::user()->id)->delete();

        //Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],

            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],

            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],

            'vtweb' => []
        ];

        try {
           // Mail::to($transaction->user->email)
            //        ->cc('irviandabakery@gmail.com')
            //        ->send(new NotificationEmail($transaction));
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
         // set konfigurasi midtrans
         Config::$serverKey = config('services.midtrans.serverKey');
         Config::$isProduction = config('services.midtrans.isProduction');
         Config::$isSanitized = config('services.midtrans.isSanitized');
         Config::$is3ds = config('services.midtrans.is3ds');
 
         //instance midtrans notif
         $notification = new Notification();
 
         //assign ke variable untuk memuahka ke coding
         $status = $notification->transaction_status;
         $type = $notification->payment_type;
         $fraud = $notification->fraud_status;
         $order_id = $notification->order_id;
 
         // cari transaksi berdasarkan id
         $transaction = Transaction::where('code',$order_id)->first();
 
         // handle notif status
         if($status == 'capture') {
             if($type == 'credit_card'){
                 if($fraud == 'challenge'){
                     $transaction->transaction_status = 'PENDING';
                 }
                 else{
                     $transaction->transaction_status = 'SUCCESS';
                 }
             }
         }
 
         else if($status == 'settlement') {
            Mail::to($transaction->user->email)
                    ->cc('irviandabakery@gmail.com')
                    ->send(new NotificationEmail($transaction));
             $transaction->transaction_status = 'SUCCESS';
         }
         else if($status == 'pending') {
             $transaction->transaction_status = 'PENDING';
         }
         else if($status == 'deny') {
             $transaction->transaction_status = 'CANCELLED';
         }
         else if($status == 'expire') {
             $transaction->transaction_status = 'CANCELLED';
         }
         else if($status == 'cancel') {
             $transaction->transaction_status = 'CANCELLED';
         }
 
         //simpan transaksi 
         $transaction->save();
     }
}
