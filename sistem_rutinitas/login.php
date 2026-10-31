<?php
require "lang.php";
require "koneksi.php";

// Jika sudah login, arahkan ke index
if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

$error = [];

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $user = htmlspecialchars($_POST["username"]);
    $pass = htmlspecialchars($_POST["password"]);

    if (empty($user) || empty($pass)) {
        $error[] = $t["err_kosong"];
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$user, $pass]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $_SESSION["username"] = $data["username"];
            header("Location: index.php");
            exit;
        } else {
            $error[] = $t["err_login"];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $t["login"] ?></title>
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <!-- Navigasi Bahasa -->
                <div class="text-end mb-3 lang small">
                    <a href="?lang=id" class="<?= $_SESSION['lang'] == 'id' ? 'active' : '' ?>">ID</a> | 
                    <a href="?lang=en" class="<?= $_SESSION['lang'] == 'en' ? 'active' : '' ?>">EN</a>
                </div>
                
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-1 fw-bold">📅 <?= $t["judul"] ?></h4>
                        <h6 class="text-center mb-4 text-muted"><?= $t["login"] ?></h6>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($error as $e) echo "<li>$e</li>"; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label"><?= $t["user"] ?></label>
                                <input type="text" name="username" class="form-control" placeholder="<?= $t["user"] ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><?= $t["pass"] ?></label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>
                            <button type="submit" class="btn btn-accent w-100"><?= $t["login"] ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
