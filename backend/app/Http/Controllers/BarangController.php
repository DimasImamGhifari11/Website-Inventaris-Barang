<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $query = Barang::orderBy('kode_aset', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%");
            });
        }

        $barang = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $barang->items(),
            'pagination' => [
                'current_page' => $barang->currentPage(),
                'last_page' => $barang->lastPage(),
                'per_page' => $barang->perPage(),
                'total' => $barang->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_aset' => 'required|string|unique:barang,kode_aset',
            'kode_barang' => 'required|string',
            'nama_aset' => 'required|string',
            'jenis_aset' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $barang = Barang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $barang
        ], 201);
    }

    public function show(string $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_aset' => 'required|string|unique:barang,kode_aset,' . $id,
            'kode_barang' => 'required|string',
            'nama_aset' => 'required|string',
            'jenis_aset' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $barang
        ]);
    }

    public function destroy(string $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*.kode_aset' => 'required|string',
            'data.*.kode_barang' => 'required|string',
            'data.*.nama_aset' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $count = 0;
        $errors = [];

        foreach ($request->data as $index => $row) {
            try {
                Barang::create([
                    'kode_aset' => $row['kode_aset'] ?? '',
                    'kode_barang' => $row['kode_barang'] ?? '',
                    'nama_aset' => $row['nama_aset'] ?? '',
                    'jenis_aset' => $row['jenis_aset'] ?? '',
                    'jumlah' => (int)($row['jumlah'] ?? 1),
                    'kondisi' => $row['kondisi'] ?? 'Baik',
                    'lokasi_penyimpanan' => $row['lokasi_penyimpanan'] ?? '',
                    'penanggung_jawab' => $row['penanggung_jawab'] ?? '',
                    'tahun_perolehan' => (int)($row['tahun_perolehan'] ?? date('Y')),
                ]);
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil import $count data",
            'count' => $count,
            'errors' => $errors
        ]);
    }
}
