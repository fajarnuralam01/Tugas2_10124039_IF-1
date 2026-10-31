<?php
require "lang.php";
require "koneksi.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
        $stmt = $pdo->prepare("DELETE FROM rutinitas WHERE id = :id");
        $stmt->execute([":id" => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo $t["gagal_hapus"] . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>
