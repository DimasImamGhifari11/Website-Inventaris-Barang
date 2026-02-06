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
    $request->validate([
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

    // Hapus token lama (optional - untuk single session)
    $user->tokens()->delete();

    // Buat token baru menggunakan Sanctum
    $token = $user->createToken('auth-token')->plainTextToken;

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

Route::post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'success' => true,
        'message' => 'Logout berhasil'
    ]);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'user' => $request->user()
    ]);
})->middleware('auth:sanctum');

// Protected Routes - Memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Statistik
    Route::get('/statistik', [BarangController::class, 'statistik']);

    // Barang Routes
    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/barang', [BarangController::class, 'store']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
    Route::post('/barang/import', [BarangController::class, 'import']);
    Route::post('/barang/bulk-delete', [BarangController::class, 'bulkDestroy']);

    // Riwayat Routes
    Route::get('/riwayat', [RiwayatController::class, 'index']);

    // Akun Routes
    Route::put('/akun', function (Request $request) {
        $user = $request->user();

        $rules = [];
        if ($request->filled('username')) {
            $rules['username'] = 'required|string|min:3';
        }
        if ($request->filled('password_baru')) {
            $rules['password_lama'] = 'required|string';
            $rules['password_baru'] = 'required|string|min:6';
        }

        $request->validate($rules);

        // Update username
        if ($request->filled('username') && $request->username !== $user->email) {
            $user->email = $request->username;
            $user->name = $request->username;
        }

        // Update password
        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama salah'
                ], 422);
            }
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil diperbarui',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    });

    // Generate Label Routes
    Route::get('/barang/{id}/generate-label', function (string $id) {
        $barang = \App\Models\Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Return basic info needed for label generation
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'tahun_perolehan' => $barang->tahun_perolehan,
                'nama_aset' => $barang->nama_aset,
            ]
        ]);
    });
});
