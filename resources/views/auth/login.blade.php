<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PAGE TITLE HERE -->
    <title>Management And Administration Website Templates | Fillow : Fillow Saas Admin Bootstrap 5 Template -
        Empowering Your Administration Work | Dexignlabs</title>



    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="{{asset('assets/vendor/nouislider/nouislider.min.css')}}">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body>
    <div class="fix-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card mb-0 h-auto">
                        <div class="card-body my-5">
                            <h4 class="text-center mb-4">Sign in your account</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md">
                                        <label for="email" class="form-label">Email Address</label>
                                        
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md">
                                        <label for="password" class="form-label">Password</label>
                                        
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                               

                                <div class="row mb-0 mt-4">
                                    <div class="col-md">
                                        <button type="submit" class="btn btn-primary w-100">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/js/dlabnav-init.js')}}"></script>
    <script src="{{asset('assets/js/demo.js')}}"></script>
    <script src="{{asset('assets/js/styleSwitcher.js')}}"></script>
</body>

</html>