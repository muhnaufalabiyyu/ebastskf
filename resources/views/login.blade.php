<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - {{ config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="shortcut icon" href="{{ asset('img/logoskf.svg') }}" type="image/x-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center pt-4">
                                        <img src="{{ asset('img/logoskf.svg') }}" alt="" style="width: 150px">
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <p><b>e-BAST System</b></p>
                                    </div>
                                    {{-- <marquee class="mb-1" behavior="sliding" direction="left" scrolldelay="100">
                                        <b>Berita Acara yang
                                            dibuat pada periode 26 Desember 2023 hingga 1 Januari 2024 akan di
                                            approve mulai tanggal 2 Januari 2024.</b>
                                    </marquee> --}}
                                    <form class="row g-3 needs-validation" action="{{ route('actionlogin') }}"
                                        method="post" autocomplete="off">
                                        @csrf
                                        <div class="col-12">
                                            <div class="has-validation form-floating">
                                                <input type="email" name="email" class="form-control" id="email"
                                                    placeholder="Email" required autofocus autocomplete="off">
                                                <label for="email" class="form-label">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="has-validation form-floating">
                                                <input type="password" name="password" class="form-control"
                                                    id="password" placeholder="Password" required>
                                                <label for="password" class="form-label">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="has-validation form-floating">
                                                <span id="captcha_img">{!! captcha_img() !!}</span>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="has-validation form-floating">
                                                <input type="text" name="captcha" class="form-control" id="captcha"
                                                    placeholder="Captcha" required maxlength="6">
                                                <label for="captcha" class="form-label">Captcha</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Captcha tidak terbaca? Refresh <a href="#"
                                                    id="refreshcaptcha">disini.</a></p>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have an account? Please contact Administrator at
                                                <a href="mailto:superuser@skf.com">superuser@skf.com</a>.
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $('#refreshcaptcha').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $("#captcha_img").html(data.captcha);
                }
            });
        });
    </script>
</body>

</html>
