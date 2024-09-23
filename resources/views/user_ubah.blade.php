<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form usbah data user</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/user">Kembali</a>
    <br><br>
    
    <form action="../ubah_simpan/{{$data->user_id}}" method="post">
        {{ csrf_field() }}
        {{method_field('PUT')}}

        <label>Username</label>
        <label>Username</label>
        <input type="text" name="username" value={{$data->username}}>
        <label>Nama</label>
        <input type="text" name="name" value={{$data->name}}>
        <label>Password</label>
        <input type="password" name="password" value={{$data->password}}>
        <label>Lavel id</label>
        <input type="number" name="level_id" value={{$data->level_id}}>
        <br><br>
        <input type="submit" value="Ubah" class="btn btn-success">
    </form>
</body>
</html>