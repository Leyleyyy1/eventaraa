<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin | EvenTara</title>

    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }
        .left img {
            max-width: 80%;
            height: auto;
        }
        .right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .form-wrapper {
            width: 100%;
            max-width: 400px;
        }
        .form-wrapper h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 14px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
        }
        .form-group input[type="password"] {
            letter-spacing: 1px;
        }
        .form-row {
            display: flex;
            gap: 10px;
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #F4A825;
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.2s;
            font-family: 'Poppins', sans-serif;
        }
        .btn-submit:hover {
            background-color: #d9931f;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- KIRI -->
        <div class="left">
            <img src="{{ asset('images/registeradm.png') }}" alt="Register Admin">
        </div>

        <!-- KANAN -->
        <div class="right">
            <div class="form-wrapper">
                <h3>Register as Event Organizer</h3>

                <!-- Pesan sukses -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Menampilkan error validasi -->
                @if ($errors->any())
                    <div class="alert">
                        <ul style="margin-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.register.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="organization" placeholder="Nama Organisasi / Komunitas / Instansi" value="{{ old('organization') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="email@email.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Nomor telepon" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Register →</button>

                    <p style="text-align: center; margin-top: 15px; font-size: 14px;">
                        Sudah punya akun? <a href="{{ route('admin.login') }}" style="color: #F4A825; text-decoration: none;">Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
