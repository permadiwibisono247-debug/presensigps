<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->count();

        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        $latitudekantor = -2.915727530993619;
        $longitudekantor = 104.62842311987237;

        // Validasi lokasi user
        if (!$request->lokasi) {
            return response()->json(['error' => 'Lokasi tidak ditemukan']);
        }

        $lokasiuser = explode(",", $request->lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->count();

        $ket = $cek > 0 ? "out" : "in";

        // Upload foto absensi
        if (!$request->image) {
            return response()->json(['error' => 'Foto tidak ditemukan']);
        }

        $folderPath = "uploads/absensi/"; // path storage/app/public/uploads/absensi
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $request->image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";

        // Simpan di storage/public/uploads/absensi
        $stored = Storage::disk('public')->put($folderPath . $fileName, $image_base64);

        if ($radius > 10) {
            return response()->json([
                'status' => 'error',
                'message' => "Maaf Anda Berada Diluar Radius, Jarak Anda Adalah " . $radius . " Meter Dari Kantor"
            ]);
        }

        if ($cek > 0) {
            // update pulang
            $data_pulang = [
                'jam_out'   => $jam,
                'foto_out'  => $fileName,
                'lokasi_out'=> $request->lokasi
            ];
            $update = DB::table('presensi')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('nik', $nik)
                ->update($data_pulang);

            $status = $update ? 'success' : 'error';
            $message = $update ? 'Terimakasih, Hati-Hati dijalan' : 'Maaf Absensi Gagal, Hubungi Tim IT';
            return response()->json(['status' => $status, 'message' => $message, 'type' => 'out']);
        } else {
            // simpan masuk
            $data = [
                'nik'          => $nik,
                'tgl_presensi' => $tgl_presensi,
                'jam_in'       => $jam,
                'foto_in'      => $fileName,
                'lokasi_in'    => $request->lokasi
            ];

            $simpan = DB::table('presensi')->insert($data);
            $status = $simpan ? 'success' : 'error';
            $message = $simpan ? 'Terimakasih, Selamat Bekerja' : 'Maaf Absensi Gagal, Hubungi Tim IT';
            return response()->json(['status' => $status, 'message' => $message, 'type' => 'in']);
        }
    }

    // Menghitung Jarak
    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) +
                 (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

        // handle foto profile
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('uploads/karyawan', $foto, 'public');
        } else {
            $foto = $karyawan->foto;
        }

        // Data update
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'foto'         => $foto
        ];

        // Update password kalau ada
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);

        $status = $update ? 'success' : 'error';
        $message = $update ? 'Profil berhasil diperbarui' : 'Profil gagal diperbarui';

        return redirect()->back()->with([$status => $message]);
    }
}
