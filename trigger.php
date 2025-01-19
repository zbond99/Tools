<?php
// Tentukan lokasi file yang dilindungi
$file_path = 'file_terproteksi.txt'; // Nama file yang ingin dilindungi
$script_name = 'file_proteksi.php'; // Nama skrip PHP yang sedang berjalan

// Fungsi untuk membuat atau memulihkan file yang dilindungi
function createFile() {
    global $file_path;
    $content = "Ini adalah file yang dilindungi. File ini akan muncul kembali jika dihapus.";
    file_put_contents($file_path, $content);
    echo "File telah dibuat kembali pada: " . date("Y-m-d H:i:s") . "\n";
}

// Fungsi untuk memeriksa apakah proses PHP masih berjalan
function isScriptRunning() {
    global $script_name;
    $process = shell_exec("ps aux | grep $script_name | grep -v grep");
    return !empty($process); // Mengembalikan true jika proses sedang berjalan
}

// Fungsi untuk menjalankan skrip ini kembali jika dihentikan
function restartScript() {
    global $script_name;
    // Menjalankan ulang skrip jika tidak berjalan
    echo "Skrip dihentikan, memulai ulang...\n";
    shell_exec('nohup php ' . __FILE__ . ' > /dev/null 2>&1 &'); // Menjalankan skrip ini di background
}

// Langkah 1: Cek apakah file yang dilindungi ada
if (!file_exists($file_path)) {
    echo "File telah dihapus! Memulihkan file dalam 10 detik...\n";
    sleep(10); // Tunggu 10 detik
    createFile(); // Membuat file kembali
} else {
    echo "File sudah ada dan tidak dihapus.\n";
}

// Langkah 2: Memeriksa apakah skrip PHP ini masih berjalan
if (!isScriptRunning()) {
    restartScript(); // Jika tidak berjalan, restart skrip
} else {
    echo "Skrip PHP sedang berjalan dengan baik.\n";
}
?>
