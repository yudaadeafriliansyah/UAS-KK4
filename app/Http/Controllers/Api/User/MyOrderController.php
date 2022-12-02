<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{

    public function index()
    {
        $order = Transaction::with(['motor'])->where('user_id',  Auth::user()->id)->get();

        return ResponseFormatter::success(
            $order,
            'Data List Order Berhasil Diambil'
        );
    }

    // logika pembayaran
    public function processPaymentRent(Request $request)
    {
        $image = $request->file('gambar')->store('payment', 'public');

        $payment = Payment::create([
        //    yang muncul di hasil
            'user_id' => Auth::user()->id,
            'transaction_id' => $request->transaction_id,
            'gambar' => $image,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
        ]);

        // status dia ambil dari hasil transaksi
        Transaction::where('id', $request->transaction_id)->update([
            'transaction_status' => 'WAITING'
        ]);

        if ($payment) {
            return ResponseFormatter::success($payment, 'success');
        } else {
            return ResponseFormatter::error(null, 'failed', 500);
        }
    }
}
