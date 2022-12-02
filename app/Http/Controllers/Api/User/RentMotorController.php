<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class RentMotorController extends Controller
{
    public function store(Motor $motor, Request $request)
    {
        $auth = auth()->user();
        $formated_date_1 = Carbon::parse($request->date_end);
        $formated_date_2 = Carbon::parse($request->date_start);
        $total_days =  $formated_date_1->diffInDays($formated_date_2);

        // jumlah hari dan harga
        $price = $motor->price * $total_days;
        $gambar_sim = $request->file('gambar_sim')->store('sim', 'public');

        $transaction = Transaction::create([
            'motor_id' => $motor->id,
            'user_id' => $auth->id,
            'transaction_code' => 'TRX' . mt_rand(10000, 99999) . mt_rand(100, 999),
            'nama' => $request->user()->nama,
            'email' => $request->user()->email,
            'nomer_hp' => $request->user()->nomer_hp,
            'alamat' => $request->user()->alamat,
            'nomer_identitas' => $request->user()->nomer_identitas,
            'gambar_sim' => $gambar_sim,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'transaction_total' => $price,
            'transaction_status' => 'PENDING',
        ]);

        Motor::where('id', $motor->id)->update([
            'rental' => '1'
            // rented 1 kalau sudah dirental
        ]);


        if ($transaction) {
            return ResponseFormatter::success($transaction, 'Transaksi berhasil, silahkan lanjutkan pembayaran');
        } else {
            return ResponseFormatter::error(null, 'Transaction Failed', 500);
        }


    }
}
