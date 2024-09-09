<?php
class Hallo
{
    public function index()
    {
        echo "Ini adalah halaman Beranda";
    }

    public function yuhu($param1 = '', $param2 = '')
    {
        echo "Ini adalah halaman Tentang. Param1: {$param1}, Param2: {$param2}";
    }
}