<!DOCTYPE html>
<html>

<head>
    <title>Data Kategori Barang</title>
</head>

<body>
    <h1>Data Kategori Barang</h1>
    <table border="1" cellpadding="2" cellspacing="2">
        <tr>
            <th>ID</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->kategori_id }}</td>
                <td>{{ $item->kategori_kode }}</td>
                <td>{{ $item->kategori_nama }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
