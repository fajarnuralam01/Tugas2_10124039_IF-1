<?php
session_start();

// Hanya bahasa yang terdaftar yang boleh disimpan ke session
$bahasa_tersedia = ["id", "en"];

if (isset($_GET["lang"]) && in_array($_GET["lang"], $bahasa_tersedia)) {
    $_SESSION["lang"] = $_GET["lang"];
}
if (!isset($_SESSION["lang"]) || !in_array($_SESSION["lang"], $bahasa_tersedia)) {
    $_SESSION["lang"] = "id";
}

$kamus = [
    "id" => [
        "judul" => "Sistem Manajemen Rutinitas",
        "daftar_judul" => "Daftar Rutinitas",
        "login" => "Masuk",
        "user" => "Nama Pengguna",
        "pass" => "Kata Sandi",
        "halo" => "Halo",
        "tambah" => "Tambah Rutinitas",
        "kegiatan" => "Nama Kegiatan",
        "waktu" => "Waktu",
        "status" => "Status",
        "desk" => "Deskripsi Kegiatan",
        "prio" => "Prioritas",
        "tinggi" => "Tinggi",
        "sedang" => "Sedang",
        "rendah" => "Rendah",
        "selesai" => "Selesai",
        "belum_selesai" => "Belum Selesai",
        "aksi" => "Aksi",
        "simpan" => "Simpan",
        "ubah" => "Ubah",
        "hapus" => "Hapus",
        "batal" => "Batal",
        "keluar" => "Keluar",
        "konfirmasi" => "Yakin dihapus?",
        "belum_ada" => "Belum ada rutinitas yang ditambahkan.",
        "ph_kegiatan" => "Contoh: Olahraga",
        "ph_desk" => "Detail kegiatan...",
        "ph_waktu" => "Contoh: 19:00 - 21:00",
        "err_kosong" => "Data tidak boleh kosong!",
        "err_login" => "Username atau password salah.",
        "err_pilihan" => "Pilihan prioritas atau status tidak valid.",
        "gagal_ambil" => "Gagal mengambil data: ",
        "gagal_simpan" => "Gagal menyimpan data: ",
        "gagal_ubah" => "Gagal mengubah data: ",
        "gagal_hapus" => "Gagal menghapus data: "
    ],
    "en" => [
        "judul" => "Routine Management System",
        "daftar_judul" => "Routine List",
        "login" => "Login",
        "user" => "Username",
        "pass" => "Password",
        "halo" => "Hello",
        "tambah" => "Add Routine",
        "kegiatan" => "Activity Name",
        "waktu" => "Time",
        "status" => "Status",
        "desk" => "Activity Description",
        "prio" => "Priority",
        "tinggi" => "High",
        "sedang" => "Medium",
        "rendah" => "Low",
        "selesai" => "Done",
        "belum_selesai" => "Not Done",
        "aksi" => "Action",
        "simpan" => "Save",
        "ubah" => "Edit",
        "hapus" => "Delete",
        "batal" => "Cancel",
        "keluar" => "Logout",
        "konfirmasi" => "Are you sure you want to delete?",
        "belum_ada" => "No routines have been added yet.",
        "ph_kegiatan" => "Example: Exercise",
        "ph_desk" => "Activity details...",
        "ph_waktu" => "Example: 19:00 - 21:00",
        "err_kosong" => "Data cannot be empty!",
        "err_login" => "Incorrect username or password.",
        "err_pilihan" => "Invalid priority or status selection.",
        "gagal_ambil" => "Failed to load data: ",
        "gagal_simpan" => "Failed to save data: ",
        "gagal_ubah" => "Failed to update data: ",
        "gagal_hapus" => "Failed to delete data: "
    ]
];
$t = $kamus[$_SESSION["lang"]];

// Label tampilan untuk nilai yang disimpan di database (selalu Indonesia)
$label_prio = ["Tinggi" => $t["tinggi"], "Sedang" => $t["sedang"], "Rendah" => $t["rendah"]];
$label_status = ["Selesai" => $t["selesai"], "Belum Selesai" => $t["belum_selesai"]];
?>
