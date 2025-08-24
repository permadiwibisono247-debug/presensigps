<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabelController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel users dan karyawan
        $users = DB::table('user')->get();
        $karyawan = DB::table('karyawan')->get();

        return view('lihattabel', compact('users', 'karyawan'));
    }
}
