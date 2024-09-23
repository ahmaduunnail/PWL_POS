<!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
</head>

<body>
    <h1>Data User</h1>
    <a href="{{ url('/user/tambah') }}">+ Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
            <th>Kode Level</th>
            <th>Nama Level</th>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->user_id }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->level_id }}</td>
                <td>{{ $d->level->level_kode }}</td>
                <td>{{ $d->level->level_nama }}</td>
                <td><a href="{{ url('/user/ubah') . '/' . $d->user_id }}">Ubah</a> | <a
                        href="{{ url('/user/hapus') . '/' . $d->user_id }}">Hapus</a>
                </td>
            </tr>
        @endforeach
        {{-- <tr>
            <th>Jumlah Pengguna</th>
        </tr> --}}
        {{-- @foreach ($data as $item)
            <tr>
                <td>{{ $item->user_id }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->level_id }}</td>
            </tr>
        @endforeach --}}
        {{-- <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->level_id }}</td>
        </tr> --}}
        {{-- <tr>
            <td>{{ $data }}</td>
        </tr> --}}
    </table>
</body>

</html>
