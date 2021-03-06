<div class="wrapper">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light mt-3" style="background-color: #e3f2fd;">
            <div class="container-fluid">
              @php use App\Instansi; $datas= Instansi::where('id', '1')->first(); @endphp
              <b>{{$datas->nama_instansi}}</b>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('data-inbox.index')}}">Surat Masuk</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Surat Keluar</a>
                  </li>                  
                  <li class="nav-item">
                    <a class="nav-link" href="#">Disposisi</a>
                  </li>                  
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-target="#menuDropdown" data-toggle="dropdown"><i class="fa fa-cog"></i></a>
                    <ul class="dropdown-menu dropdown-menu-dark" id="menuDropdown">
                      <li><a class="dropdown-item" href="{{route('data-instansi.index')}}">Instansi</a></li>
                      <li><a class="dropdown-item" href="{{route('data-kategori.index')}}">Kategori</a></li>
                      <li><a class="dropdown-item" href="{{route('data-kop-surat.index')}}">Kop Surat</a></li>
                      <li><a class="dropdown-item" href="{{route('data-user.index')}}">User</a></li>
                    </ul>
                  </li>                  
                </ul>                
                </div>              
                <div class="user-area dropdown float-right">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form><i class="fa fa-sign-out-alt logout"></i></a>
                </div>
            </div>
        </nav>
        <hr>
        @yield('content')

        <!-- Footer -->
        {{-- <footer class="bg-dark text-center text-white fixed-bottom">
            <!-- Grid container -->
            <div class="container p-4">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-facebook-f"></i
                ></a>
        
                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-twitter"></i
                ></a>
        
                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-google"></i
                ></a>
        
                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-instagram"></i
                ></a>
        
                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-linkedin-in"></i
                ></a>
        
                <!-- Github -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
                ><i class="fab fa-github"></i
                ></a>
            </section>
            <!-- Section: Social media -->
        
            <!-- Section: Form -->
            <section class="">
                <form action="">
                <!--Grid row-->
                <div class="row d-flex justify-content-center">
                    <!--Grid column-->
                    <div class="col-auto">
                    <p class="pt-2">
                        <strong>Sign up for our newsletter</strong>
                    </p>
                    </div>
                    <!--Grid column-->
        
                    <!--Grid column-->
                    <div class="col-md-5 col-12">
                    <!-- Email input -->
                    <div class="form-outline form-white mb-4">
                        <input type="email" id="form5Example21" class="form-control" />
                        <label class="form-label" for="form5Example21">Email address</label>
                    </div>
                    </div>
                    <!--Grid column-->
        
                    <!--Grid column-->
                    <div class="col-auto">
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-outline-light mb-4">
                        Subscribe
                    </button>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
                </form>
            </section>
            <!-- Section: Form -->
        
            </div>
            <!-- Grid container -->
        
        </footer> --}}
        <!-- Footer -->

    </div> 
    
  </div>