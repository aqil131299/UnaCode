<?php

// Konfigurasi database
$Konfig = [
    'db_host' => 'localhost',
    'db_name' => 'una',
    'db_user' => 'root',
    'db_pass' => '',
    'db_socket' => null, // Tambahkan ini jika Anda menggunakan soket
];

class Database
{
    private $pdo;
    private $config;

    // Konstruktor kelas untuk inisialisasi koneksi
    public function __construct($Konfig)
    {
        $this->config = $Konfig; // Simpan konfigurasi dalam properti kelas

        // Tentukan DSN, termasuk soket jika ada
        $dsn = $this->config['db_socket'] 
            ? "mysql:unix_socket={$this->config['db_socket']};dbname={$this->config['db_name']};charset=utf8" 
            : "mysql:host={$this->config['db_host']};dbname={$this->config['db_name']};charset=utf8";
        $user = $this->config['db_user'];
        $pass = $this->config['db_pass'];

        // Mencoba membuat koneksi
        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            handleConnectionError($e, $this->config);
        }
    }

    // Metode untuk mendapatkan instance PDO
    public function getPdo()
    {
        return $this->pdo;
    }
}

// Fungsi global untuk menangani kesalahan koneksi
function handleConnectionError(PDOException $e, $config)
{
    $errorCode = $e->getCode();
    $errorMessage = $e->getMessage();

    switch ($errorCode) {
        case 1044: // Access denied for user to database
            Kesalahan("Akses ditolak untuk user: {$config['db_user']}. Periksa hak akses untuk database '{$config['db_name']}'.");
            break;
        case 1045: // Access denied for user (wrong password)
            Kesalahan("Akses ditolak untuk user: {$config['db_user']}. Periksa username dan password untuk host '{$config['db_host']}'.");
            break;
        case 1046: // No database selected
            Kesalahan("Tidak ada database yang dipilih. Pastikan database '{$config['db_name']}' dipilih sebelum menjalankan kueri.");
            break;
        case 1049: // Unknown database
            Kesalahan("Database '{$config['db_name']}' tidak ditemukan. Periksa nama database pada konfigurasi.");
            break;
        case 1050: // Table already exists
            Kesalahan("Tabel '{$e->getTable()}' sudah ada di database '{$config['db_name']}'.");
            break;
        case 1051: // Unknown table
            Kesalahan("Tabel '{$e->getTable()}' tidak ditemukan dalam database '{$config['db_name']}'.");
            break;
        case 1054: // Unknown column
            Kesalahan("Kolom '{$e->getColumn()}' tidak ditemukan dalam tabel '{$e->getTable()}' di database '{$config['db_name']}'.");
            break;
        case 1062: // Duplicate entry
            Kesalahan("Entri duplikat untuk nilai '{$e->getValue()}' pada kunci '{$e->getKey()}'.");
            break;
        case 1064: // SQL syntax error
            Kesalahan("Terjadi kesalahan sintaks SQL. Pesan: {$errorMessage}");
            break;
        case 1065: // Query was empty
            Kesalahan("Kueri SQL kosong.");
            break;
        case 1146: // Table doesn't exist
            Kesalahan("Tabel '{$e->getTable()}' tidak ada dalam database '{$config['db_name']}'.");
            break;
        case 1149: // Command not allowed
            Kesalahan("Perintah tidak diizinkan dengan versi MySQL ini.");
            break;
        case 1213: // Deadlock found
            Kesalahan("Deadlock ditemukan saat mencoba mendapatkan kunci. Coba restart transaksi.");
            break;
        case 1227: // Access denied for operation
            Kesalahan("Akses ditolak; Anda memerlukan hak istimewa untuk operasi ini.");
            break;
        case 1451: // Cannot delete/update a parent row
            Kesalahan("Tidak dapat menghapus atau memperbarui baris induk; pelanggaran batasan kunci asing.");
            break;
        case 1452: // Cannot add/update a child row
            Kesalahan("Tidak dapat menambahkan atau memperbarui baris anak; pelanggaran batasan kunci asing.");
            break;
        case 2002: // Can't connect to MySQL server through socket
            Kesalahan("Tidak dapat terhubung ke server MySQL pada socket '{$config['db_socket']}'. Periksa alamat socket dan port. <br> Atau Server MySQL Belum di Aktifkan");
            break;
        case 2003: // Can't connect to MySQL server on 'host'
            Kesalahan("Tidak dapat terhubung ke server MySQL pada host '{$config['db_host']}'. Periksa alamat host dan port.");
            break;
        case 2005: // Unknown MySQL server host
            Kesalahan("Server MySQL tidak dapat ditemukan pada host '{$config['db_host']}'.");
            break;
        case 2013: // Lost connection during query
            Kesalahan("Koneksi ke server MySQL terputus saat menjalankan kueri.");
            break;
        case 2014: // Commands out of sync
            Kesalahan("Perintah tidak sinkron; Anda tidak dapat menjalankan perintah ini sekarang.");
            break;
        case 2026: // SSL connection error
            Kesalahan("Koneksi SSL error: verifikasi sertifikat gagal (result: 19).");
            break;
        case 2049: // Password hash should be a string
            Kesalahan("Hash kata sandi harus berupa string.");
            break;
        case 2054: // Authentication method unknown
            Kesalahan("Metode autentikasi yang diminta tidak dikenal oleh klien.");
            break;
        default:
            Kesalahan("Tidak dapat terhubung ke database. Pesan: {$errorMessage}. Periksa konfigurasi koneksi seperti nama database, host, dan kredensial.");
            break;
    }
}


// Menggunakan kelas Database dengan konfigurasi dari baris pertama
$db = new Database($Konfig);
