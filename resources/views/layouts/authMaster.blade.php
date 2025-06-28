<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Auth')</title>

    <!-- Vendor & custom CSS -->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('loginStyle/style.css') }}" rel="stylesheet">
    @stack('styles') {{-- kalau nanti ada css ekstra --}}
</head>

<body class="bg-animated">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            {{-- Logo kiri --}}
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/logoWilangan.png') }}"
                                    class="img-fluid px-5" style="max-height:250px" alt="Logo SMK">
                            </div>

                            {{-- Konten dinamis (login / register / forgot) --}}
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">@yield('heading')</h1>
                                    </div>

                                    <!-- {FLASH MESSAGE GLOBAL} -->
                                    @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif

                                    @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif

                                    @yield('form') {{-- tempat form masing-masing --}}

                                    @yield('extra-links') {{-- link bawah --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')
</body>

</html>