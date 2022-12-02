<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motor = Motor::all();
        $motor->map(function ($motor) {
            $motor->image = asset('storage/' . $motor->image);
            return $motor;
        });

        return ResponseFormatter::success($motor, 'Data List Motor Berhasil Diambil');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $request->user();



        if ($auth->role == 'admin') {
            
            $image = $request->file('gambar')->store('motor', 'public');

            $motor = Motor::create([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'warna' => $request->warna,
                'gambar' => $image,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
            ]);

            if ($motor) {
                return ResponseFormatter::success(
                    $motor,
                    'Data Motor Berhasil Ditambahkan'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Motor Gagal Ditambahkan',
                    404
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Anda Bukan Admin',
                404
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Motor $motor)
    {
        return ResponseFormatter::success($motor, 'Detail Motor Berhasil Diambil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $motor = Motor::find($id);

        if ($request->file('gambar')) {
            $gambar = $request->file('gambar')->store('motor', 'public');
        } else {
            $gambar = $motor->gambar;
        }

        if ($user->role == 'admin') {
            $motor->update([
                'judul' => $request->judul ? $request->judul : $motor->judul,
                'slug' => Str::slug($request->judul) ? str::slug($request->judul) : $motor->slug,
                'warna' => $request->warna ?? $motor->warna,
                'gambar' => $image ?? $motor->gambar,
                'deskripsi' => $request->deskripsi ?? $motor->description,
                'harga' => $request->harga ?? $motor->harga,
            ]);
        } else {
            return ResponseFormatter::success($motor, 'Anda tidak memiliki akses');
        }

        return ResponseFormatter::success($motor, 'Data motor berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $motor = Motor::find($id);

        if ($user->role == 'admin') {
            $motor->delete();
        } else {
            return ResponseFormatter::success($motor, 'Anda tidak memiliki akses untuk menghapus data motor');
        }

        return ResponseFormatter::success($motor, 'Data Motor berhasil dihapus');
    }
}
