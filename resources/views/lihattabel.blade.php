<!DOCTYPE html>
<html>
<head>
    <title>Lihat Tabel</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Password (hashed)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name ?? '-' }}</td>
                <td>{{ $user->password }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama Lengkap</th>
 
                <th>Password (hashed)</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $k)
            <tr>
                <td>{{ $k->nik }}</td>
                <td>{{ $k->nama_lengkap }}</td>
  
                <td>{{ $k->password }}</td>
                <td>{{ $k->jabatan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
