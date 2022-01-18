<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aplikasi Surat') }}</title>

    <link href="https://getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style> .nama_pengguna { margin-bottom: 10px; } .kata_sandi { margin-bottom: 15px; } </style>
</head>
<body>
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
          <b>{{config('app.name')}}</b>
        </div>
        <div class="lockscreen-item">          
          <div id="err" style="color: red">
            @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
          </div>
      
            <form class="sign-in-credentials" method="POST" action="{{route('login')}}">
              {{csrf_field()}}
              
              <div class="login">
                <input type="text" value="{{old('email')}}" name="email" class="nama_pengguna form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Username" autofocus>
                @if ($errors->has('email'))
                  <div class="invalid-feedback">
                    {{$errors->first('email')}}
                  </div>          
                @endif
                <input type="password" name="password" class="kata_sandi form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password">
                @if ($errors->has('password'))
                  <div class="invalid-feedback">
                    {{$errors->first('password')}}
                  </div>          
                @endif
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
              </div>
            </form>
            <p class="mt-4 text-muted">&copy;{{date('Y')}} - {{config('app.name')}} Alright Reserved</p>
          
        </div>
      </div>

    <script src="{{asset('template/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>
</html>
