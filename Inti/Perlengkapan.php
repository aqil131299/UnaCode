<?php
// Dalam perjalanan ini, aku, Mazeluna, memastikan bahwa hanya yang diizinkan yang dapat mengakses kode ini, menjaga kerahasiaan dan keamanan.
defined('BASEPATH') or exit('Akses langsung ke skrip ini tidak diizinkan');

class Perlengkapan
{
     public function Masuk($Arah, $Kendali, $Metode)
    {
        require_once $Arah;
        $Rumah = new $Kendali;
        $Rumah->$Metode();
    }

    function Tampilkan($Tampilkan, $Tas = array())
    {
        $Data = $Tas;
        $Arah = './AppUnaCode/Tampilan/' . $Tampilkan . '.php';

        if (file_exists($Arah)) {
            if (is_array($Data)) {
                extract($Data);

                $result = @require_once $Arah;

                if ($result === false) {
                    Kesalahan('Bencana terjadi saat memuat file tampilan: ' . $Arah);
                }
            } else {
                Kesalahan('Data yang dikirimkan ke fungsi Tampilkan haruslah berupa ARRAY.');
            }
        } else {
            Kesalahan('File tampilan bagaikan harta karun yang hilang: ' . $Arah);
        }
    }

    
}