<?php
define('BASEPATH', TRUE);
function Kesalahan($hasil)
{
    $Tipe = 'Kesalahan';
    $Pesan = $hasil;
    $File = '';
    $Baris = '';
    require_once 'AppUnaCode/Tampilan/Kesalahan.php';
    exit;
}
function KesalahanPHP($TipeKesalahan, $PesanKesalahan, $errfile, $errline)
{
    $Tipe   =    $TipeKesalahan;
    $Pesan  =    $PesanKesalahan;
    $File   =    $errfile;
    $Baris  =    $errline;
    $Pesan = "$Pesan <br> Di File : <code style='color:#ff2143;'> $File </code> <br> Baris : <b style='color:#48fba2;'> $Baris </b>";
    require_once 'AppUnaCode/Tampilan/Kesalahan.php';
    exit;
}
error_reporting(0);

// Fungsi untuk menerjemahkan jenis error
function TerjemahanKesalahan($errno)
{
    $errors = [
        E_ERROR => 'Kesalahan Fatal',
        E_WARNING => 'Peringatan',
        E_PARSE => 'Kesalahan Penulisan',
        E_NOTICE => 'Pemberitahuan',
        E_CORE_ERROR => 'Kesalahan Inti PHP',
        E_CORE_WARNING => 'Peringatan Inti PHP',
        E_COMPILE_ERROR => 'Kesalahan Kompilasi',
        E_COMPILE_WARNING => 'Peringatan Kompilasi',
        E_USER_ERROR => 'Kesalahan Pengguna',
        E_USER_WARNING => 'Peringatan Pengguna',
        E_USER_NOTICE => 'Pemberitahuan Pengguna',
        E_STRICT => 'Peringatan Standar',
        E_RECOVERABLE_ERROR => 'Kesalahan Dapat Dipulihkan',
        E_DEPRECATED => 'Peringatan Depresiasi',
        E_USER_DEPRECATED => 'Peringatan Depresiasi Pengguna',
    ];
    return $errors[$errno] ?? 'Kesalahan Tidak Dikenal';
}

// Fungsi untuk menerjemahkan pesan error spesifik ke bahasa Indonesia
function TerjemahanKesalahanPesan($errstr)
{
    $translations = [
        'Undefined variable' => 'Variabel tidak dikenali',
        'Undefined index' => 'Indeks tidak dikenali',
        'Division by zero' => 'Pembagian dengan nol',
        'Failed to open stream: No such file or directory' => 'Gagal membuka stream: File atau direktori tidak ditemukan',
        'Function mysql_connect() is deprecated' => 'Fungsi mysql_connect() sudah tidak digunakan lagi',
        'Use of undefined constant' => 'Penggunaan konstanta yang tidak didefinisikan',
        'Trying to access array offset on value of type null' => 'Mencoba mengakses offset array pada nilai tipe null',
        'syntax error, unexpected variable' => 'Kesalahan Penulisan Sebelum Variabel',
        'Cannot access offset of type string on string in' => 'Tidak dapat mengakses offset tipe string pada string masuk',
        'Constant expression contains invalid operations' => 'Ekspresi konstan berisi operasi yang tidak valid',
        'syntax error, unexpected token' => 'Kesalahan Sintaks, Simbol Tak Terduga',
        // Tambahkan terjemahan lain jika diperlukan
    ];

    foreach ($translations as $en => $id) {
        if (strpos($errstr, $en) !== false) {
            return str_replace($en, $id, $errstr);
        }
    }
    return $errstr; // Jika tidak ada terjemahan, kembalikan pesan asli
}

// Fungsi untuk menangani error kustom
function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    $TipeKesalahan = TerjemahanKesalahan($errno);
    $PesanKesalahan = TerjemahanKesalahanPesan($errstr);


    KesalahanPHP($TipeKesalahan, $PesanKesalahan, $errfile, $errline);
}

// Fungsi untuk menangani error fatal
function handleShutdown()
{
    $error = error_get_last();
    if ($error !== null) {
        $TipeKesalahan  = TerjemahanKesalahan($error['type']);
        $PesanKesalahan = TerjemahanKesalahanPesan($error['message']);
        $errfile        = $error['file'];
        $errline        = $error['line'];
        KesalahanPHP($TipeKesalahan, $PesanKesalahan, $errfile, $errline);
    }
}

// Setel error handler kustom
set_error_handler("customErrorHandler");

// Daftarkan fungsi shutdown untuk menangani error fatal
register_shutdown_function('handleShutdown');

require_once './Inti/Perlengkapan.php';
require_once './AppUnaCode/Rute.php';
require_once './Inti/Inti.php';
new Inti();
