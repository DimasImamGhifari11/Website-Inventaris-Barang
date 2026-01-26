<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_aset' => 'EGOV' . fake()->unique()->numberBetween(1, 9999),
            'kode_barang' => fake()->year() . '.' . fake()->numberBetween(100, 999) . '/EGOV',
            'nama_aset' => fake()->randomElement([
                'Laptop Dell',
                'Monitor LG',
                'Printer Canon',
                'Scanner Epson',
                'Router Cisco',
                'Server HP',
                'AC Daikin',
                'Proyektor BenQ',
                'Keyboard Logitech',
                'Mouse Wireless'
            ]) . ' ' . fake()->word(),
            'jenis_aset' => fake()->randomElement([
                'Peralatan IT',
                'Elektronik',
                'Furniture',
                'Kendaraan',
                'Alat Tulis'
            ]),
            'jumlah' => fake()->numberBetween(1, 20),
            'kondisi' => fake()->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
            'lokasi_penyimpanan' => fake()->randomElement([
                'Ruang Server',
                'Gudang',
                'Ruang Kantor',
                'Ruang Meeting',
                'Lobby'
            ]),
            'penanggung_jawab' => fake()->name(),
            'tahun_perolehan' => fake()->numberBetween(2000, date('Y')),
        ];
    }

    /**
     * Indicate that the barang kondisi is "Baik".
     */
    public function kondisiBaik(): static
    {
        return $this->state(fn (array $attributes) => [
            'kondisi' => 'Baik',
        ]);
    }

    /**
     * Indicate that the barang kondisi is "Rusak Ringan".
     */
    public function kondisiRusakRingan(): static
    {
        return $this->state(fn (array $attributes) => [
            'kondisi' => 'Rusak Ringan',
        ]);
    }

    /**
     * Indicate that the barang kondisi is "Rusak Berat".
     */
    public function kondisiRusakBerat(): static
    {
        return $this->state(fn (array $attributes) => [
            'kondisi' => 'Rusak Berat',
        ]);
    }
}
