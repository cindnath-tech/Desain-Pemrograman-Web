<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = ($_POST['tahun'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');
$stok = ($_POST['stok'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$erros = [];
if ($judul === '') {
    $erros[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $erros[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $erros[] = "Tahun harus di antara 1900-2026";
}
if (!is_numeric($stok) || $stok < 0) {
    $erros[] = "Stok tidak boleh negatif.";
}

if (!empty($erros)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $erros)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE buku SET judul = :judul, pengarang = :pengarang, tahun = :tahun, 
    isbn = :isbn, stok = :stok, kategori = :kategori WHERE id = :id"
);
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil diperbarui.'];
header('Location: list.php');
exit;
