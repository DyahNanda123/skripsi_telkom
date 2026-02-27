<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Telkom Ngawi</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <style>
        /* CSS Khusus untuk Background Full Screen */
        body.login-page {
            background-image: url('{{ asset('img/bg-telkom.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }
        
        /* CSS Khusus untuk Kotak Login */
        .login-card-custom {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 20px;
        }

        /* Modifikasi Input Field agar mirip desainmu */
        .form-control-custom {
            background-color: #f4f6f9;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }
        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #dc3545;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width: 450px;">
    
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="card login-card-custom">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="font-weight-bold" style="color: #333;">Telkom Ngawi</h2>
                <p class="text-muted">Please log in to continue</p>
            </div>

            <form action="{{ url('/login') }}" method="post">
                @csrf
                
                <div class="form-group mb-4">
                    <label style="font-size: 14px; font-weight: 500;">NIP</label>
                    <input type="text" name="nip" class="form-control form-control-custom py-4" placeholder="Masukkan NIP Anda" required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 14px; font-weight: 500;">Password</label>
                    <input type="password" name="password" class="form-control form-control-custom py-4" placeholder="Masukkan Password" required>
                    <small class="text-muted mt-1 d-block" style="font-size: 11px;">It must be a combination of minimum 8 letters, numbers, and symbols.</small>
                </div>

                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <div class="icheck-danger">
                            <input type="checkbox" id="remember">
                            <label for="remember" style="font-weight: normal; font-size: 14px;">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger btn-block py-2 font-weight-bold">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>