<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama'] ?? null);
$noAnggota = trim($_POST['no_anggota'] ?? null);
$alamat = trim($_POST['alamat'] ?? null);
$noHp = trim($_POST['no_hp'] ?? null);

if (!$id) {
    header('Location: list.php');
    exit;
}

$erros = [];
if ($nama === '') {
    $erros[] = "Nama wajib diisi.";
}
if ($noAnggota === '') {
    $erros[] = "No. Anggota wajib diisi.";
}

if (!empty($erros)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $erros)];
    header('Location: edit.php?id' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE anggota SET nama = :nama, no_anggota = :no_anggota,
    alamat = :alamat, no_hp = :no_hp WHERE id = :id"
);
$stmt->execute([
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;
