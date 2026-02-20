<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Akun</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>

<body>
    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="registration-container">
            <h2>Registrasi Akun</h2>
            <div class="registration-form">

                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" class="@error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" required value="{{old('nama')}}">
                @error('nama')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror

                <br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="@error('username') is-invalid @enderror" placeholder="Masukkan username" required value="{{old('username')}}">
                @error('username')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror

                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" placeholder="Masukkan email" required value="{{old('email')}}">
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror

                <br>
                <label for="alamat">alamat:</label>
                <input type="text" id="alamat" name="alamat" class="@error('alamat') is-invalid @enderror" placeholder="Masukkan alamat" required value="{{old('alamat')}}">
                @error('alamat')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror

                
                <br>
                <label for="nohp">No. HP:</label>
                <input type="tel" id="nohp" name="nohp" class="@error('nohp') is-invalid @enderror" placeholder="Masukkan nomor HP" required value="{{old('nohp')}}">
                @error('nohp')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror

                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <button type="submit" class="btn btn-primary btn-block">Buat Akun</button>
                <!-- <a href="{{ route('register.store') }}"><button class="signup-button">BUAT AKUN</button></a> -->
            </div>
        </div>
    </form>
</body>
</html>