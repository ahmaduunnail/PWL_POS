<!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
</head>

<body>
    <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr>
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
        <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->level_id }}</td>
        </tr>
        {{-- <tr>
            <td>{{ $data }}</td>
        </tr> --}}
    </table>
</body>

</html>
