<x-app-layout>
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    @endsection

    @section('content')
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="wrap d-md-flex">
                            <div class="img" style="background-color: #035103">
                                <div class="mx-2 text-white text-center d-flex justify-content-center align-items-center flex-column h-100" style="font-size: 1.5rem;">
                                    <img class="mb-2" height="150" src="images/ccsLogo.png" alt="CCS Logo">
                                    <span>QuickPick: Automated Pre-enlistment System</span>
                                </div>
                            </div>
                            <div class="login-wrap p-4 p-md-5">
                                <div class="d-flex">
                                    <div class="w-100">
                                        <h3 class="mb-4">Sign In</h3>
                                    </div>
                                    <div class="w-100">
                                        <p class="social-media d-flex justify-content-end">
                                            {{-- <a href="#"
                                                class="social-icon d-flex align-items-center justify-content-center"><span
                                                    class="fa fa-facebook"></span></a>
                                            <a href="#"
                                                class="social-icon d-flex align-items-center justify-content-center"><span
                                                    class="fa fa-twitter"></span></a> --}}
                                        </p>
                                    </div>
                                </div>

                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4" :status="session('status')" />

                                <form method="POST" action="{{ route('login') }}" class="signin-form">

                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="label" for="email">Email</label>
                                        <input id="email" type="email" name="email" class="form-control" :value="old('email')" required autofocus autocomplete="username" placeholder="Username">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="label" for="password">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required autocomplete="current-password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                                    </div>

                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />

                                        
                                    <div class="form-group d-md-flex">
                                        <div class="w-50 text-left">
                                            <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                                <input type="checkbox" id="remember_me" name="remember">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="w-50 text-md-right">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">Forgot Password</a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </form>
                                <p class="text-center">Not a member? <a href="{{ route('register') }}">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @section('scripts')
        <script src="{{ asset('js/main.js') }}"></script>
    @endsection

</x-app-layout>
