@extends('layouts.whole')
@section('title','Dashboard')
@section('content')
<div class="row mt-2 mb-2">
    <div class="col-sm-12 position-relative p-4">
        <h1 class="display-1 text-truncate tebel-sedang judul1">{{Auth::user()->name}}</h1>
        <h1 class="display-1 text-truncate tebel-sedang judul2">Welcome</h1>
        <div class="hr"></div>

        <div class="desc mt-4">
            <p>Hi {{Auth::user()->name}}, ini merupakan halaman dashboard aplikasi surat masuk dan surat keluar yang dibangun menggunakan framework laravel v7. Anda bisa langsung mencobanya. Terimakasih.</p>
        </div>

        <div class="mt-5">
            <a href="#" class="button rounded-pill shadow tebel-sedang">Buat Surat?</a>
        </div>

    </div>
</div>

@endsection


