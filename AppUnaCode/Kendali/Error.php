<?php
class Error extends Perlengkapan
{
    public function index()
    {
        $x['hai'] = 'hallo';

        $this->Tampilkan('Error', $x);
    }
}