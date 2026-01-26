# Test Cases - Sistem Inventaris Barang

## A. WHITE BOX TESTING

---

### 1. CREATE - Positive Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-CR-P01 | Tambah data dengan semua field valid | 1. Buka halaman Tambah Data<br>2. Isi semua field dengan data valid<br>3. Klik tombol Simpan | kode_aset: "EGOV01"<br>kode_barang: "2025.001/EGOV"<br>nama_aset: "Laptop Dell"<br>jenis_aset: "Peralatan IT"<br>jumlah: 5<br>kondisi: "Baik"<br>lokasi: "Ruang Server"<br>penanggung_jawab: "John Doe"<br>tahun: 2025 | Data berhasil disimpan, muncul notifikasi sukses | |
| 2 | WB-CR-P02 | Import data dari Excel | 1. Buka halaman Tambah Data<br>2. Drag & drop file Excel valid<br>3. Klik Import | File Excel dengan data valid | Data berhasil diimport, muncul notifikasi sukses | |
| 3 | WB-CR-P03 | Tambah data tercatat di Riwayat | 1. Tambah data baru<br>2. Buka halaman Riwayat | Data baru ditambahkan | Riwayat mencatat "Tambah Data" dengan stok sebelum dan sesudah | |
| 4 | WB-CR-P04 | Tambah data dengan kondisi Rusak Ringan | 1. Buka Tambah Data<br>2. Pilih kondisi "Rusak Ringan"<br>3. Klik Simpan | kondisi: "Rusak Ringan" | Data tersimpan dengan kondisi Rusak Ringan | |
| 5 | WB-CR-P05 | Tambah data dengan kondisi Rusak Berat | 1. Buka Tambah Data<br>2. Pilih kondisi "Rusak Berat"<br>3. Klik Simpan | kondisi: "Rusak Berat" | Data tersimpan dengan kondisi Rusak Berat | |

---

### 2. CREATE - Negative Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-CR-N01 | Tambah data dengan kode_aset duplikat | 1. Buka halaman Tambah Data<br>2. Isi kode_aset yang sudah ada<br>3. Klik Simpan | kode_aset: "EGOV01" (sudah ada) | Gagal simpan, muncul pesan error | |
| 2 | WB-CR-N02 | Tambah data dengan field kosong | 1. Buka halaman Tambah Data<br>2. Kosongkan field required<br>3. Klik Simpan | nama_aset: "" (kosong) | Form tidak bisa disubmit | |
| 3 | WB-CR-N03 | Tambah data dengan jumlah 0 | 1. Buka halaman Tambah Data<br>2. Isi jumlah dengan 0<br>3. Klik Simpan | jumlah: 0 | Gagal simpan, validasi error | |
| 4 | WB-CR-N04 | Tambah data dengan tahun tidak valid | 1. Buka halaman Tambah Data<br>2. Isi tahun dengan 1999<br>3. Klik Simpan | tahun_perolehan: 1999 | Gagal simpan, validasi error | |
| 5 | WB-CR-N05 | Import Excel dengan format tidak valid | 1. Upload file bukan Excel | File: document.pdf | Gagal import, muncul pesan error | |

---

### 3. READ - Positive Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-RD-P01 | Menampilkan semua data di halaman Home | 1. Login<br>2. Buka halaman Home | - | Semua data ditampilkan dalam tabel dengan pagination | |
| 2 | WB-RD-P02 | Pencarian data dengan keyword valid | 1. Buka halaman Home<br>2. Ketik keyword di search box | search: "Laptop" | Data yang mengandung "Laptop" ditampilkan | |
| 3 | WB-RD-P03 | Navigasi pagination | 1. Buka halaman Home<br>2. Klik tombol Next<br>3. Klik tombol Prev | - | Navigasi halaman berfungsi dengan benar | |
| 4 | WB-RD-P04 | Menampilkan data Riwayat | 1. Buka halaman Riwayat | - | Log aktivitas ditampilkan dengan lengkap | |
| 5 | WB-RD-P05 | Tetap di halaman saat clear search | 1. Buka page 3<br>2. Search keyword<br>3. Hapus keyword | - | Kembali ke page 3 (bukan page 1) | |

---

### 4. UPDATE - Positive Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-UP-P01 | Update data dengan data valid | 1. Buka Update Data<br>2. Klik edit<br>3. Ubah data<br>4. Klik Simpan | nama_aset: "Laptop Asus ROG" | Data berhasil diupdate, notifikasi sukses | |
| 2 | WB-UP-P02 | Update jumlah (stok bertambah) | 1. Buka form update<br>2. Ubah jumlah dari 5 ke 10<br>3. Klik Simpan | jumlah: 5 → 10 | Riwayat mencatat "Edit Stok (+5)" | |
| 3 | WB-UP-P03 | Update jumlah (stok berkurang) | 1. Buka form update<br>2. Ubah jumlah dari 10 ke 7<br>3. Klik Simpan | jumlah: 10 → 7 | Riwayat mencatat "Edit Stok (-3)" | |
| 4 | WB-UP-P04 | Update dengan keterangan | 1. Ubah data<br>2. Isi keterangan<br>3. Klik Simpan | keterangan: "Perbaikan unit" | Keterangan tercatat di riwayat | |
| 5 | WB-UP-P05 | Tetap di halaman setelah update | 1. Buka page 3<br>2. Edit data<br>3. Simpan | - | Kembali ke page 3 (bukan page 1) | |

---

### 5. UPDATE - Negative Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-UP-N01 | Update tanpa perubahan data | 1. Buka form update<br>2. Tidak mengubah apapun<br>3. Klik Simpan | Tidak ada perubahan | Muncul notifikasi "Tidak ada perubahan data" | |
| 2 | WB-UP-N02 | Update dengan kode_aset duplikat | 1. Ubah kode_aset ke yang sudah ada<br>2. Klik Simpan | kode_aset: "EGOV02" (milik data lain) | Gagal simpan, error duplikat | |
| 3 | WB-UP-N03 | Update dengan jumlah 0 | 1. Ubah jumlah ke 0<br>2. Klik Simpan | jumlah: 0 | Gagal simpan, validasi error | |
| 4 | WB-UP-N04 | Update dengan field kosong | 1. Kosongkan nama_aset<br>2. Klik Simpan | nama_aset: "" | Form tidak bisa disubmit | |
| 5 | WB-UP-N05 | Update data yang tidak ada | 1. Akses URL /update-data/9999 | id: 9999 (tidak ada) | Halaman menampilkan "Data tidak ditemukan" | |

---

### 6. DELETE - Positive Test Cases

| No | Test Case ID | Nama Test Case | Langkah Pengujian | Input Data | Expected Result | Status |
|----|--------------|----------------|-------------------|------------|-----------------|--------|
| 1 | WB-DL-P01 | Hapus single data | 1. Buka Hapus Data<br>2. Klik icon hapus<br>3. Konfirmasi "Ya, Hapus" | id: 1 | Data terhapus, notifikasi sukses | |
| 2 | WB-DL-P02 | Hapus multiple data (bulk delete) | 1. Checklist 3 data<br>2. Klik "Hapus Terpilih"<br>3. Konfirmasi | ids: [1, 2, 3] | 3 data terhapus | |
| 3 | WB-DL-P03 | Batalkan hapus data | 1. Klik icon hapus<br>2. Klik "Batal" di modal | - | Modal tertutup, data tidak terhapus | |
| 4 | WB-DL-P04 | Select all checkbox | 1. Klik checkbox di header tabel | - | Semua data terselect | |
| 5 | WB-DL-P05 | Hapus data tercatat di Riwayat | 1. Hapus satu data<br>2. Buka Riwayat | - | Riwayat mencatat "Hapus Data" | |

---

## B. BLACK BOX TESTING

---

### 1. FUNCTIONAL TESTING

| No | Test Case ID | Modul | Nama Test Case | Pre-condition | Langkah Pengujian | Expected Result | Status |
|----|--------------|-------|----------------|---------------|-------------------|-----------------|--------|
| 1 | BB-FN-01 | Login | Login dengan data valid | Di halaman login | 1. Isi username & password valid<br>2. Klik Login | Berhasil masuk ke dashboard | |
| 2 | BB-FN-02 | Tambah Data | Simpan data baru | Form terisi valid | 1. Isi semua field<br>2. Klik Simpan | Data tersimpan, notifikasi muncul | |
| 3 | BB-FN-03 | Update Data | Simpan perubahan | Ada perubahan data | 1. Ubah data<br>2. Klik Simpan | Data terupdate, notifikasi muncul | |
| 4 | BB-FN-04 | Hapus Data | Hapus data | Modal terbuka | 1. Klik "Ya, Hapus" | Data terhapus, notifikasi muncul | |
| 5 | BB-FN-05 | Riwayat | Menampilkan log aktivitas | Ada aktivitas sebelumnya | 1. Klik menu Riwayat | Log aktivitas ditampilkan dengan detail | |

---

### 2. BOUNDARY VALUE ANALYSIS

| No | Test Case ID | Field | Boundary | Test Value | Expected Result | Status |
|----|--------------|-------|----------|------------|-----------------|--------|
| 1 | BB-BV-01 | jumlah | Minimum valid | 1 | Data tersimpan | |
| 2 | BB-BV-02 | jumlah | Below minimum | 0 | Validasi error | |
| 3 | BB-BV-03 | tahun_perolehan | Minimum valid | 2000 | Data tersimpan | |
| 4 | BB-BV-04 | tahun_perolehan | Below minimum | 1999 | Validasi error | |
| 5 | BB-BV-05 | kode_aset | Empty string | "" | Validasi error (required) | |

---

## C. RINGKASAN TEST CASES

| Kategori | Jumlah Test Case |
|----------|------------------|
| **WHITE BOX TESTING** | |
| Create Positive | 5 |
| Create Negative | 5 |
| Read Positive | 5 |
| Update Positive | 5 |
| Update Negative | 5 |
| Delete Positive | 5 |
| **Subtotal White Box** | **30** |
| **BLACK BOX TESTING** | |
| Functional Testing | 5 |
| Boundary Value Analysis | 5 |
| **Subtotal Black Box** | **10** |
| **TOTAL** | **40** |

---

## D. CATATAN PENGUJIAN

**Status Legend:**
- ✅ Pass
- ❌ Fail
- ⏳ Pending

---

*Dokumen ini dibuat untuk keperluan pengujian Sistem Inventaris Barang Diskominfo HSU*
