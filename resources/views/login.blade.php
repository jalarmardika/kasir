<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aplikasi Kasir</title>
    <link href="{{ url('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Cashier Application</h1>
                            </div>
                            @if(session()->has('error'))
                            <div class="alert alert-danger my-3">
                                {{ session('error') }}
                            </div>
                            @endif
                            <form action="{{ url('login') }}" method="post" class="user">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail">Email</label>
                                    <input type="text" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') }}"></script>
</body>
</html>