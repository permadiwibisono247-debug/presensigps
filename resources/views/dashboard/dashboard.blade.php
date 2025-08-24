@extends('layouts.presensi')

@section('content')
<div id="appCapsule">
    {{-- User Section --}}
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @php
                    $fotoProfil = $karyawan->foto && file_exists(public_path('storage/uploads/karyawan/'.$karyawan->foto)) 
                                  ? asset('storage/uploads/karyawan/'.$karyawan->foto) 
                                  : asset('assets/img/sample/avatar/avatar1.jpg');
                @endphp
                <img src="{{ $fotoProfil }}" alt="avatar" class="imaged w64 rounded" style="height:60px">
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap ?? '-' }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Menu Section --}}
    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu d-flex justify-content-around">
                    <div class="item-menu text-center">
                        <a href="#" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                        <div class="menu-name">Profil</div>
                    </div>
                    <div class="item-menu text-center">
                        <a href="#" class="danger" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                        <div class="menu-name">Cuti</div>
                    </div>
                    <div class="item-menu text-center">
                        <a href="#" class="warning" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                        <div class="menu-name">Histori</div>
                    </div>
                    <div class="item-menu text-center">
                        <a href="#" class="orange" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                        <div class="menu-name">Lokasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Presensi Hari Ini --}}
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                {{-- Masuk --}}
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @php
                                        $fotoMasuk = $presensihariini->foto_in && file_exists(public_path('storage/uploads/absensi/'.$presensihariini->foto_in)) 
                                                     ? asset('storage/uploads/absensi/'.$presensihariini->foto_in) 
                                                     : null;
                                    @endphp
                                    @if($fotoMasuk)
                                        <img src="{{ $fotoMasuk }}" alt="foto masuk" class="imaged w64 rounded">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini->jam_in ?? 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pulang --}}
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @php
                                        $fotoPulang = $presensihariini->foto_out && file_exists(public_path('storage/uploads/absensi/'.$presensihariini->foto_out)) 
                                                      ? asset('storage/uploads/absensi/'.$presensihariini->foto_out) 
                                                      : null;
                                    @endphp
                                    @if($fotoPulang)
                                        <img src="{{ $fotoPulang }}" alt="foto pulang" class="imaged w64 rounded">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini->jam_out ?? 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rekap Presensi --}}
        <div id="rekappresensi" class="mt-2">
            <h3>Rekap Presensi {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body p-2">
                            <span class="badge bg-danger position-absolute" style="top:3px; right:10px; font-size:0.6rem;">
                                {{ $rekappresensi->jmlhadir ?? 0 }}
                            </span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body p-2">
                            <span class="badge bg-danger position-absolute" style="top:3px; right:10px; font-size:0.6rem;">
                                0
                            </span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body p-2">
                            <span class="badge bg-danger position-absolute" style="top:3px; right:10px; font-size:0.6rem;">
                                0
                            </span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body p-2">
                            <span class="badge bg-danger position-absolute" style="top:3px; right:10px; font-size:0.6rem;">
                                {{ $rekappresensi->jmlterlambat ?? 0 }}
                            </span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Presensi --}}
        <div class="presencetab mt-2">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Bulan Ini</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Leaderboard</a>
                </li>
            </ul>

            <div class="tab-content mt-2 mb-5">
                {{-- Histori Bulan Ini --}}
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach($historibulanini as $d)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        @php
                                            $fotoHistori = $d->foto_in && file_exists(public_path('storage/uploads/absensi/'.$d->foto_in))
                                                          ? asset('storage/uploads/absensi/'.$d->foto_in)
                                                          : null;
                                        @endphp
                                        @if($fotoHistori)
                                            <img src="{{ $fotoHistori }}" alt="foto histori" class="imaged w64">  
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in ?? '-' }}</span>
                                        <span class="badge badge-danger">{{ $d->jam_out ?? 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Leaderboard --}}
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    @php
                                        $fotoLb = $d->foto && file_exists(public_path('storage/uploads/karyawan/'.$d->foto))
                                                  ? asset('storage/uploads/karyawan/'.$d->foto)
                                                  : asset('assets/img/sample/avatar/avatar1.jpg');
                                    @endphp
                                    <img src="{{ $fotoLb }}" alt="avatar" class="imaged w64 rounded" style="height:60px">
                                    <div class="in">
                                        <b>{{ $d->nama_lengkap }}</b><br>
                                        <small>{{ $d->jabatan }}</small>
                                        <span class="tbadge {{ $d->jam_in < '07:00' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $d->jam_in ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.bottomNav')
@endsection
