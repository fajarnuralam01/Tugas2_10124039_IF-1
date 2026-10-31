<?php
require "lang.php";
require "koneksi.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$error = [];
$kegiatan = "";
$deskripsi = "";
$waktu = "";
$prioritas = "";
$status = "Belum Selesai";

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

    if (empty($kegiatan) || empty($deskripsi) || empty($waktu) || empty($prioritas)) {
        $error[] = $t["err_kosong"];
    } elseif (!in_array($prioritas, ["Tinggi", "Sedang", "Rendah"]) || !in_array($status, ["Selesai", "Belum Selesai"])) {
        $error[] = $t["err_pilihan"];
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO rutinitas (nama_kegiatan, deskripsi, waktu, prioritas, status) VALUES (:kegiatan, :deskripsi, :waktu, :prioritas, :status)");
            $stmt->execute([
                ":kegiatan" => $kegiatan,
                ":deskripsi" => $deskripsi,
                ":waktu" => $waktu,
                ":prioritas" => $prioritas,
                ":status" => $status
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error[] = $t["gagal_simpan"] . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $t["tambah"] ?></title>
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
                    <a href="?lang=id" class="<?= $_SESSION['lang'] == 'id' ? 'active' : '' ?>">ID</a> |
                    <a href="?lang=en" class="<?= $_SESSION['lang'] == 'en' ? 'active' : '' ?>">EN</a>
                </div>
                <div class="card">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold"><?= $t["tambah"] ?></h5>
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
                                <input type="text" name="nama_kegiatan" class="form-control" placeholder="<?= $t["ph_kegiatan"] ?>" value="<?= $kegiatan ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><?= $t["desk"] ?></label>
                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="<?= $t["ph_desk"] ?>"><?= $deskripsi ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><?= $t["waktu"] ?></label>
                                <input type="text" name="waktu" class="form-control" placeholder="<?= $t["ph_waktu"] ?>" value="<?= $waktu ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label d-block"><?= $t["prio"] ?></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Tinggi" <?= $prioritas == 'Tinggi' ? 'checked' : '' ?>>
                                    <label class="form-check-label text-danger fw-semibold"><?= $t["tinggi"] ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Sedang" <?= $prioritas == 'Sedang' ? 'checked' : '' ?>>
                                    <label class="form-check-label text-warning fw-semibold"><?= $t["sedang"] ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="prioritas" value="Rendah" <?= $prioritas == 'Rendah' ? 'checked' : '' ?>>
                                    <label class="form-check-label text-success fw-semibold"><?= $t["rendah"] ?></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><?= $t["status"] ?></label>
                                <select name="status" class="form-select">
                                    <option value="Selesai" <?= $status == 'Selesai' ? 'selected' : '' ?>><?= $t["selesai"] ?></option>
                                    <option value="Belum Selesai" <?= $status == 'Belum Selesai' ? 'selected' : '' ?>><?= $t["belum_selesai"] ?></option>
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
