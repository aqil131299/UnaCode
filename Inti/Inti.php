<?php
defined('BASEPATH') or exit('Akses langsung ke skrip ini tidak diizinkan');

require_once './AppUnaCode/Konfigurasi/Konfigurasi.php';
class Inti
{
    private $Perutean;
    private $Portal;
    private $BaseUrl;
    public function __construct()
    {
        global $Konfigurasi;
        $this->BaseUrl = $Konfigurasi['URL'];
        if ($Konfigurasi['URL'] == NULL) {
            Kesalahan("URL Belum Di atur, Silahkan Masukan URL di Konfigurasi.php ($ Konfigurasi['URL']=''");
        } else {
            $this->Kebutuhan($Konfigurasi);
            die;
        }
        $this->CekRute();
    }

    private function CekRute()
    {
        require_once 'Perutean.php';
        $this->Perutean = new Perutean();
        $hasil = $this->Perutean->Rute();

        if (isset($hasil['Error'])) {
            Kesalahan($hasil['Error']);
        } else {
            $this->Mulai($hasil['File'], $hasil['Class'], $hasil['Method']);
        }
    }
    public function Kebutuhan($Konfigurasi)
    {
        foreach ($Konfigurasi['Perpustakaan'] as $P) {
            if (file_exists('./AppUnaCode/Perpustakaan/' . $P . '.php')) {
                require_once './AppUnaCode/Perpustakaan/' . $P . '.php';
                if (class_exists($P)) {
                } else {
                    Kesalahan('Nama Perpustakaan ' . $P . ' Harus Sama dengan Nama class di ' . $P . '.php');
                }
            } else {
                Kesalahan('Una Tidak Menemukan Perpustakaan ' . $P . '.php Di dalam Folder Perpustakaan');
                exit;
            }
        }
    }
    public function Mulai($Arah, $Kendali, $Metode)
    {
        require_once 'Perlengkapan.php';
        $this->Portal = new Perlengkapan();
        $this->Portal->Masuk($Arah, $Kendali, $Metode);
    }
}
