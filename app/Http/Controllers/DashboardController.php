<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = (int) date("m");
        $tahunini = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;

        // Ambil data karyawan
        $karyawan = DB::table('karyawan')
            ->where('nik', $nik)
            ->first();

        // Presensi hari ini
        $presensihariini = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->first();


            
        // Histori bulan ini
        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulanini])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])
            ->orderBy('tgl_presensi')
            ->get();

        // Rekap presensi bulan ini
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulanini])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])
            ->first();

        // Leaderboard hari ini (menggunakan leftJoin supaya foto tidak hilang)
        $leaderboard = DB::table('presensi')
            ->leftJoin('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->select(
                'presensi.*',
                'karyawan.nama_lengkap',
                'karyawan.jabatan',
                'karyawan.foto'
            )
            ->get();

        $namabulan = [
            "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        return view('dashboard.dashboard', compact(
            'karyawan',
            'presensihariini',
            'historibulanini',
            'namabulan',
            'bulanini',
            'tahunini',
            'rekappresensi',
            'leaderboard'
        ));
    }

    public function dashboardadmin()
    {
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('tgl_presensi',$hariini)
        ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi'));
    }
}
