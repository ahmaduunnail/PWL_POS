<!DOCTYPE html>
<html>

<head>
    <title>User tambah</title>

<body>
    <h1>Form Tambah Data Use</h1>
    <form action="./tambah_simpan" method="post">
        {{ csrf_field() }}
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan username">
        <label>Nama</label>
        <input type="text" name="name" placeholder="Mauskkan nama">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password">
        <label>Lavel id</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>
        <input type="submit" value="Simpan" class="btn btn-success">
    </form>
</body>
</head>

</html>
