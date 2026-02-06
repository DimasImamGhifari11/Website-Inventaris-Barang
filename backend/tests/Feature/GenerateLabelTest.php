<?php

namespace Tests\Feature;

use App\Models\Barang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * =====================================================
 * WHITE BOX TESTING - GENERATE LABEL
 * =====================================================
 */
class GenerateLabelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * WB-GL-P01: Generate label single data
     */
    public function test_generate_label_single_data(): void
    {
        $barang = Barang::create([
            'kode_aset' => 'EGOV01',
            'kode_barang' => '2025.001/EGOV',
            'nama_aset' => 'Laptop Dell',
            'jenis_aset' => 'Peralatan IT',
            'jumlah' => 5,
            'kondisi' => 'Baik',
            'lokasi_penyimpanan' => 'Ruang Server',
            'penanggung_jawab' => 'John Doe',
            'tahun_perolehan' => 2025,
        ]);

        $response = $this->authenticatedGetJson("/api/barang/{$barang->id}/generate-label");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $barang->id,
                         'kode_barang' => '2025.001/EGOV',
                         'tahun_perolehan' => 2025,
                         'nama_aset' => 'Laptop Dell',
                     ],
                 ]);
    }

    /**
     * WB-GL-P02: Generate label data yang tidak ditemukan
     */
    public function test_generate_label_data_not_found(): void
    {
        $response = $this->authenticatedGetJson('/api/barang/9999/generate-label');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Data tidak ditemukan',
                 ]);
    }

    /**
     * WB-GL-P03: Generate label dengan data valid
     */
    public function test_generate_label_with_valid_data(): void
    {
        $barang = Barang::create([
            'kode_aset' => 'EGOV02',
            'kode_barang' => '2025.002/EGOV',
            'nama_aset' => 'Monitor LG',
            'jenis_aset' => 'Peralatan IT',
            'jumlah' => 3,
            'kondisi' => 'Rusak Ringan',
            'lokasi_penyimpanan' => 'Ruang Kantor',
            'penanggung_jawab' => 'Jane Smith',
            'tahun_perolehan' => 2024,
        ]);

        $response = $this->authenticatedGetJson("/api/barang/{$barang->id}/generate-label");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ])
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'kode_barang',
                         'tahun_perolehan',
                         'nama_aset',
                     ],
                 ]);

        $responseData = $response->json('data');
        $this->assertEquals($barang->id, $responseData['id']);
        $this->assertEquals($barang->kode_barang, $responseData['kode_barang']);
        $this->assertEquals($barang->tahun_perolehan, $responseData['tahun_perolehan']);
        $this->assertEquals($barang->nama_aset, $responseData['nama_aset']);
    }
}