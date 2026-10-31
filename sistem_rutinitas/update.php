<?php
require "lang.php";
require "koneksi.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM rutinitas WHERE id = :id");
$stmt->execute([":id" => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header("Location: index.php");
    exit;
}

$error = [];
if (isset($_POST["nama_kegiatan"])) {
    $kegiatan = htmlspecialchars($_POST["nama_kegiatan"]);
    $deskripsi = "";
    if (isset($_POST["deskripsi"])) {
        $deskripsi = htmlspecialchars($_POST["deskripsi"]);
    }
    $waktu = "";
    if (isset($_POST["waktu"])) {
        $waktu = htmlspecialchars($_POST["waktu"]);
    }
    $prioritas = "";
    if (isset($_POST["prioritas"])) {
        $prioritas = htmlspecialchars($_POST["prioritas"]);
    }
    $status = "";
    if (isset($_POST["status"])) {
        $status = htmlspecialchars($_POST["status"]);
    }

    // Pertahankan input pengguna di form jika validasi gagal
    $data["nama_kegiatan"] = $kegiatan;
    $data["deskripsi"] = $deskripsi;
    $data["waktu"] = $waktu;
    $data["prioritas"] = $prioritas;
    $data["status"] = $status;

    if (empty($kegiatan) || empty($deskripsi) || empty($waktu) || empty($prioritas)) {
        $error[] = $t["err_kosong"];
    } elseif (!in_array($prioritas, ["Tinggi", "Sedang", "Rendah"]) || !in_array($status, ["Selesai", "Belum Selesai"])) {
        $error[] = $t["err_pilihan"];
    } else {
        try {
            $stmt_update = $pdo->prepare("UPDATE rutinitas SET nama_kegiatan = :kegiatan, deskripsi = :deskripsi, waktu = :waktu, prioritas = :prioritas, status = :status WHERE id = :id");
            $stmt_update->execute([
                ":kegiatan" => $kegiatan,
                ":deskripsi" => $deskripsi,
                ":waktu" => $waktu,
                ":prioritas" => $prioritas,
                ":status" => $status,
                ":id" => $id
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error[] = $t["gagal_ubah"] . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $t["ubah"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f6f7fb;color:#1f2937}
        .card{border:1px solid #e5e7eb!important;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.04)!important}
        .form-label{font-weight:600;font-size:.9rem}
        .form-control,.form-select{border-radius:8px}
        .form-control:focus,.form-select:focus{border-color:#4f46e5;box-shadow:0 0 0 .2rem rgba(79,70,229,.15)}
        .btn{border-radius:8px;font-weight:600}
        .btn-accent{background:#4f46e5;border-color:#4f46e5;color:#fff}
        .btn-accent:hover{background:#4338ca;border-color:#4338ca;color:#fff}
        .lang a{text-decoration:none;font-weight:600;color:#9ca3af}
        .lang a.active{color:#4f46e5}
        h4,h5{color:#1f2937}
        .form-check-input:checked{background-color:#4f46e5;border-color:#4f46e5}
        .form-check-input:focus{border-color:#4f46e5;box-shadow:0 0 0 .2rem rgba(79,70,229,.15)}
        .btn-outline-primary{color:#4f46e5;border-color:#c7d2fe}
        .btn-outline-primary:hover{background:#4f46e5;border-color:#4f46e5;color:#fff}
        .btn-outline-danger{border-color:#fecaca}
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-end mb-3 lang small">
                    <a href="?id=<?= $data["id"] ?>&lang=id" class="<?= $_SESSION['lang'] == 'id' ? 'active' : '' ?>">ID</a> |
                    <a href="?id=<?= $data["id"] ?>&lang=en" class="<?= $_SESSION['lang'] == 'en' ? 'active' : '' ?>">EN</a>
                </div>
                <div class="card">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold"><?= $t["ubah"] ?></h5>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($error as $e) echo "<li>$e</li>"; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label"><?= $t["kegiatan"] ?></label>
                                <input type="text" name="nama_kegiatan" class="form-control" value="<?= $data['nama_kegiatan'] ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><?= $t["desk"] ?></label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><?= $t["waktu"] ?></label>
                                <input type="text" name="waktu" class="form-control" value="<?= $data['waktu'] ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label d-block"><?= $t["prio"] ?></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Tinggi" <?= ($data['prioritas'] == 'Tinggi') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-danger fw-semibold"><?= $t["tinggi"] ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Sedang" <?= ($data['prioritas'] == 'Sedang') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-warning fw-semibold"><?= $t["sedang"] ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Rendah" <?= ($data['prioritas'] == 'Rendah') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-success fw-semibold"><?= $t["rendah"] ?></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><?= $t["status"] ?></label>
                                <select name="status" class="form-select">
                                    <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>><?= $t["selesai"] ?></option>
                                    <option value="Belum Selesai" <?= $data['status'] == 'Belum Selesai' ? 'selected' : '' ?>><?= $t["belum_selesai"] ?></option>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-accent px-4"><?= $t["simpan"] ?></button>
                                <a href="index.php" class="btn btn-outline-secondary px-4"><?= $t["batal"] ?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
