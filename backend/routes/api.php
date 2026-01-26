<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RiwayatController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'Backend API is working!',
        'status' => 'success',
        'timestamp' => now()->toDateTimeString()
    ]);
});

Route::post('/login', function (Request $request) {
    $request->validate(rules: [
        'username' => 'required',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah'
        ], 401);
    }

    $token = bin2hex(random_bytes(32));

    return response()->json([
        'success' => true,
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Barang Routes
Route::get('/barang', [BarangController::class, 'index']);
Route::post('/barang', [BarangController::class, 'store']);
Route::get('/barang/{id}', [BarangController::class, 'show']);
Route::put('/barang/{id}', [BarangController::class, 'update']);
Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
Route::post('/barang/import', [BarangController::class, 'import']);

// Riwayat Routes
Route::get('/riwayat', [RiwayatController::class, 'index']);
