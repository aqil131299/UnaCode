<?php
defined('BASEPATH') or exit('Akses langsung ke skrip ini tidak diizinkan');

class Perutean
{
    private $rute;

    public function __construct()
    {
        require_once './AppUnaCode/Rute.php';
        global $Rute;
        $this->rute = $Rute;
    }

        public function Rute()
    {
        $PecahRequest = explode('/', $_SERVER['REQUEST_URI']);
        $Request = array_filter($PecahRequest, function ($Nilai) {
            return $Nilai !== "";
        });
        array_shift($Request);

        $Rute = $this->rute;
        $URL = '';

        if (empty($Request)) {
            $URL = $Rute['SelamatDatang'];
        } else {
            $ditemukan = false;
            foreach ($Request as $key) {
                if (array_key_exists($key, $Rute)) {
                    $URL = $Rute[$key];
                    $ditemukan = true;
                    break;
                }
            }

            if (!$ditemukan) {
                return ['Error' => 'URL {' . $key . '} Tak Ditemukan Dalam Peta Rute'];
            }
        }

        if (count($URL) == 2) {
            return $this->arahkan($URL[1], $URL[0]);
        } else {
            return $this->arahkan($URL);
        }
    }

    public function arahkan($URL, $Folder = null)
    {
        $hasil = [];
        if (is_array($URL)) {
            $URL = implode('', $URL);
        }

        $URL = explode('@', $URL);
        if ($Folder === null) {
            $ArahFile = './AppUnaCode/Kendali/' . $URL[0] . '.php';

            if (file_exists($ArahFile)) {
                $NamaClass = $URL[0];
                $NamaMetode = $URL[1] ?? null;

                require_once $ArahFile;

                if (class_exists($NamaClass)) {
                    if (method_exists($NamaClass, $NamaMetode)) {
                        $hasil['File'] = $ArahFile;
                        $hasil['Class'] = $NamaClass;
                        $hasil['Method'] = $NamaMetode;
                    } else {
                        $hasil['Error'] = 'Metode yang Diharapkan Tak Tersedia';
                    }
                } else {
                    $hasil['Error'] = 'Kelas {' . $NamaClass . '} Tak Ditemukan di File Kendali ' . $URL[0] . '.php';
                }
            } else {
                $hasil['Error'] = 'File ' . $URL[0] . '.php Seolah Terhapus Dari Kendali';
            }
        } else {
            if (is_dir('./AppUnaCode/Kendali/' . $Folder)) {
                $ArahFile = './AppUnaCode/Kendali/' . $Folder . '/' . $URL[0] . '.php';
                if (file_exists($ArahFile)) {
                    $NamaClass = $URL[0];
                    $NamaMetode = $URL[1] ?? null;
                    require_once $ArahFile;

                    if (class_exists($NamaClass)) {
                        if (method_exists($NamaClass, $NamaMetode)) {
                            $hasil['File'] = $ArahFile;
                            $hasil['Class'] = $NamaClass;
                            $hasil['Method'] = $NamaMetode;
                        } else {
                            $hasil['Error'] = 'Metode yang Diharapkan Tak Tersedia';
                        }
                    } else {
                        $hasil['Error'] = 'Kelas {' . $NamaClass . '} Tak Ditemukan di File Kendali ' . $URL[0] . '.php';
                    }
                } else {
                    $hasil['Error'] = 'File ' . $URL[0] . '.php Seolah Terhapus Dari Kendali /AppUnaCode/Kendali/'. $Folder;
                }
            } else {
                $hasil['Error'] = "Folder {" . $Folder . "} Seolah Menghilang Dari Dunia Kendali.";
            }
        }

        return $hasil;
    }
}