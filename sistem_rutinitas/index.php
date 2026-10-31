<?php
require "lang.php";
require "koneksi.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$data_rutinitas = [];
try {
    $stmt = $pdo->query("SELECT * FROM rutinitas");
    $data_rutinitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $t["gagal_ambil"] . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $t["judul"] ?></title>
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
        .navbar{background:#fff;border-bottom:1px solid #e5e7eb}
        .table thead th{background:#f9fafb;color:#6b7280;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600}
        .table td,.table th{padding:.9rem 1rem}
        .badge{font-weight:600;padding:.4em .75em;border-radius:999px}
        .badge.bg-danger{background:#fee2e2!important;color:#b91c1c!important}
        .badge.bg-warning{background:#fef3c7!important;color:#b45309!important}
        .badge.bg-success{background:#dcfce7!important;color:#15803d!important}
        .badge.bg-secondary{background:#eef2ff!important;color:#4338ca!important}
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar mb-4 py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="index.php">📋 <?= $t["judul"] ?></a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><?= $t["halo"] ?>, <strong class="text-dark"><?= $_SESSION["username"] ?></strong>!</span>
                <span class="lang small">
                    <a href="?lang=id" class="<?= $_SESSION['lang'] == 'id' ? 'active' : '' ?>">ID</a> |
                    <a href="?lang=en" class="<?= $_SESSION['lang'] == 'en' ? 'active' : '' ?>">EN</a>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm"><?= $t["keluar"] ?></a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container pb-5">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0">
                <h5 class="mb-0 fw-bold"><?= $t["daftar_judul"] ?></h5>
                <a href="create.php" class="btn btn-accent btn-sm">+ <?= $t["tambah"] ?></a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th class="text-start"><?= $t["kegiatan"] ?></th>
                                <th class="text-start"><?= $t["desk"] ?></th>
                                <th width="15%"><?= $t["waktu"] ?></th>
                                <th width="10%"><?= $t["prio"] ?></th>
                                <th width="12%"><?= $t["status"] ?></th>
                                <th width="15%"><?= $t["aksi"] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($data_rutinitas as $row): 
                                $badgeStatus = ($row["status"] == 'Selesai') ? 'bg-success' : 'bg-warning text-dark';

                                // Terjemahan label sesuai bahasa yang dipilih
                                $teks_prio = $row["prioritas"];
                                if (isset($label_prio[$row["prioritas"]])) {
                                    $teks_prio = $label_prio[$row["prioritas"]];
                                }
                                $teks_status = $row["status"];
                                if (isset($label_status[$row["status"]])) {
                                    $teks_status = $label_status[$row["status"]];
                                }
                                
                                // Pengondisian warna badge prioritas
                                $badgePrio = 'bg-secondary';
                                if(isset($row["prioritas"])) {
                                    if($row["prioritas"] == 'Tinggi') $badgePrio = 'bg-danger';
                                    elseif($row["prioritas"] == 'Sedang') $badgePrio = 'bg-warning text-dark';
                                    elseif($row["prioritas"] == 'Rendah') $badgePrio = 'bg-success';
                                }
                            ?>
                            <tr>
                                <td class="text-muted"><?= $no++ ?></td>
                                <td class="text-start fw-semibold"><?= $row["nama_kegiatan"] ?></td>
                                <td class="text-start text-muted small"><?= $row["deskripsi"] ?></td>
                                <td><span class="badge bg-secondary"><?= $row["waktu"] ?></span></td>
                                <td><span class="badge <?= $badgePrio ?>"><?= $teks_prio ?></span></td>
                                <td><span class="badge <?= $badgeStatus ?>"><?= $teks_status ?></span></td>
                                <td class="text-nowrap">
                                    <a href="update.php?id=<?= $row["id"] ?>" class="btn btn-outline-primary btn-sm"><?= $t["ubah"] ?></a>
                                    <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= $t["konfirmasi"] ?>');"><?= $t["hapus"] ?></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($data_rutinitas)): ?>
                            <tr>
                                <td colspan="7" class="text-muted py-4"><i><?= $t["belum_ada"] ?></i></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
