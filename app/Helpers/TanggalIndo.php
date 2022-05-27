<?php

namespace App\Helpers;

class TanggalIndo {
    public static function tanggal_indo($tanggal)
    {
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return date("d", strtotime($tanggal)).' '.$bulan[date("n", strtotime($tanggal))].' '.date("Y", strtotime($tanggal));
    }
}