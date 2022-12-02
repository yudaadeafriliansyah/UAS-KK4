<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MotorController extends Controller
{
    public function index()
    {
        $motor = Motor::where('rental', '0')->get();
        $motor->map(function ($motor) {
            $motor->image = asset('storage/' . $motor->image);
            return $motor;
        });
 
        if ($motor) {
            return ResponseFormatter::success($motor, 'Data List Motor Berhasil Diambil');
        } else {
            return ResponseFormatter::error($motor, 'Data Gagal Diambil');
        }
    }

    public function show(Motor $motor)
    {
        return ResponseFormatter::success($motor, 'Data Motor Berhasil Diambil');
    }
}
