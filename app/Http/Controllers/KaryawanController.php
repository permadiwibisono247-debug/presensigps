<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(){
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')
        ->join('departemen','karyawan.kode_departemen','=','departemen.kode_departemen')
        ->get();
        return view('karyawan.index', compact('karyawan'));
    }
}
