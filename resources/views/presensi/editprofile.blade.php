@extends('layouts.presensi')

@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="{{ route('dashboard') }}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profile</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection

@section('content')
<div class="row" style="margin-top:4rem">
    <div class="col">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
    @csrf

    <div class="col">
        {{-- Nama Lengkap --}}
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" 
                       class="form-control" 
                       value="{{ $karyawan->nama_lengkap }}" 
                       name="nama_lengkap" 
                       placeholder="Nama Lengkap" 
                       autocomplete="off">
            </div>
        </div>

        {{-- Nomor HP --}}
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" 
                       class="form-control" 
                       value="{{ $karyawan->no_hp }}" 
                       name="no_hp" 
                       placeholder="No. HP" 
                       autocomplete="off">
            </div>
        </div>

        {{-- Password --}}
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" 
                       class="form-control" 
                       name="password" 
                       placeholder="Password Baru (opsional)" 
                       autocomplete="off">
            </div>
        </div>

        {{-- Upload Foto --}}
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>

        {{-- Tombol Submit --}}
        <div class="form-group boxed mt-3">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
