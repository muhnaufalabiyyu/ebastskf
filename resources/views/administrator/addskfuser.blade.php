@extends('administrator.layouts.app')
@section('title', 'Add User SKF')

@section('blockstyle')
    <style>
        .select2-container .select2-selection--single {
            height: 37.5px;
            border-color: rgb(229, 229, 229);
        }

        #passwordStrength {
            width: 100%;
            height: 5px;
            margin: 10px 0;
            display: none;
        }

        #passwordStrength span {
            position: relative;
            height: 100%;
            width: 100%;
            background: lightgrey;
            border-radius: 5px;
        }

        #passwordStrength span:nth-child(2) {
            margin: 0 3px;
        }

        #passwordStrength span.active:before {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: 5px;
        }

        #passwordStrength span#poor:before {
            background-color: #ff4757;
        }

        #passwordStrength span#weak:before {
            background-color: orange;
        }

        #passwordStrength span#strong:before {
            background-color: #23ad5c;
        }

        #passwordInfo {
            font-size: 15px;
        }

        #passwordInfo #poor {
            color: red;
        }

        #passwordInfo #weak {
            color: orange;
        }

        #passwordInfo #strong {
            color: green;
        }

        .error-message {
            display: none;
            color: red;
            font-size: 12px;
        }

        .error {
            border: 1px solid red;
        }
    </style>
@endsection

@section('main')
    <div class="pagetitle">
        <h1>Add SKF User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User Access</li>
                <li class="breadcrumb-item"><a href="{{ route('userskf') }}">SKF User</a></li>
                <li class="breadcrumb-item active">Add</li>

            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="card py-2">
            <div class="card-body">
                <h5 class="card-title">Please fill in the form with the correct information.</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3" action="{{ route('storeskfuser') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input name="fullname" type="text" class="form-control" id="fullname"
                                placeholder="Fullname">
                            <label for="fullname">Fullname</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="departemen" class="form-select" aria-label="Departemen" id="departemen">
                                <option value="" selected disabled>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->alias }}">{{ $dept->alias }} - {{ $dept->nama_dept }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="departemen">Departemen</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="jabatan" class="form-select" aria-label="jabatan" id="jabatan">
                                <option value="" selected disabled>Pilih Jabatan</option>
                                <option value="spv">Supervisor</option>
                                <option value="mgr">Manager</option>
                            </select>
                            <label for="jabatan">Jabatan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control" id="password"
                                placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="password2" type="password" class="form-control" id="confirm_password"
                                placeholder="" required>
                            <label for="confirm_password" id="pass_placeholder">Re-type your
                                password</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating" id="passwordStrength">
                            <span id="poor"></span>
                            <span id="weak"></span>
                            <span id="strong"></span>
                        </div>
                    </div>
                    <div class="input-group mb-4 row">
                        <div id="passwordInfo" class="col-6"></div>
                        <div id="passwordguide" class="col-6"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" id="addbutton" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End floating Labels Form -->

            </div>
        </div>
    </section>
@endsection

@section('blockjs')
    @if (session('success'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "User berhasil dibuat!",
                icon: "success",
                confirmButtonText: "Tutup"
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                title: "ERROR!",
                text: "Tidak dapat membuat user!",
                icon: "error",
                confirmButtonText: "Tutup"
            });
        </script>
    @endif

    {{-- for password confirmation purpose --}}
    <script>
        let passwordInput = document.getElementById('password');
        let passwordStrength = document.getElementById("passwordStrength");
        let poor = document.querySelector("#passwordStrength #poor");
        let weak = document.querySelector("#passwordStrength #weak");
        let strong = document.querySelector("#passwordStrength #strong");
        let passwordInfo = document.getElementById("passwordInfo");
        let passwordGuide = document.getElementById("passwordguide");

        let poorRegExp = /[a-z]/;
        let weakRegExp = /(?=.*?[0-9])/;
        let strongRegExp = /(?=.*?[#?!@$%^&*-])/;
        let whitespaceRegExp = /^$|\s+/;

        passwordInput.oninput = function() {
            let passwordValue = passwordInput.value;
            let passwordLength = passwordValue.length;

            let poorPassword = passwordValue.match(poorRegExp);
            let weakPassword = passwordValue.match(weakRegExp);
            let strongPassword = passwordValue.match(strongRegExp);
            let whitespace = passwordValue.match(whitespaceRegExp);

            if (passwordValue != "") {
                passwordStrength.style.display = "block";
                passwordStrength.style.display = "flex";
                passwordInfo.style.display = "block";
                passwordInfo.style.color = "black";

                if (whitespace) {
                    passwordInfo.textContent = "Whitespaces are not allowed";
                } else {
                    poorPasswordStrength(
                        passwordLength,
                        poorPassword,
                        weakPassword,
                        strongPassword
                    );
                    weakPasswordStrength(
                        passwordLength,
                        poorPassword,
                        weakPassword,
                        strongPassword
                    );
                    strongPasswordStrength(
                        passwordLength,
                        poorPassword,
                        weakPassword,
                        strongPassword
                    );
                }
            } else {
                passwordStrength.style.display = "none";
                passwordInfo.style.display = "none";
            }
        };

        function poorPasswordStrength(
            passwordLength,
            poorPassword,
            weakPassword,
            strongPassword
        ) {
            if (poorPassword || weakPassword || strongPassword) {
                poor.classList.add("active");
                passwordInfo.style.display = "block";
                passwordInfo.style.color = "red";
                passwordInfo.textContent = "Your password is poor";
            }
        }

        function weakPasswordStrength(
            passwordLength,
            poorPassword,
            weakPassword,
            strongPassword
        ) {
            if (poorPassword && (weakPassword || strongPassword)) {
                weak.classList.add("active");
                passwordInfo.textContent = "Your password is Weak";
                passwordInfo.style.color = "orange";
            } else {
                weak.classList.remove("active");
            }
        }

        function strongPasswordStrength(
            passwordLength,
            poorPassword,
            weakPassword,
            strongPassword
        ) {
            if (poorPassword && weakPassword && strongPassword) {
                poor.classList.add("active");
                weak.classList.add("active");
                strong.classList.add("active");
                passwordInfo.textContent = "Your password is strong";
                passwordInfo.style.color = "green";
            } else {
                strong.classList.remove("active");
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#password").bind('keyup change', function() {
                check_Password($("#password").val(), $("#confirm_password").val())
            })
            $("#confirm_password").bind('keyup change', function() {
                check_Password($("#password").val(), $("#confirm_password").val())
            })
            $("#addbutton").click(function() {
                check_Password($("#password").val(), $("#confirm_password").val())
            })
        })

        function check_Password(Pass, Con_Pass) {
            if (!Pass) {
                // document.getElementById('confirm_password').style.borderColor = "red";
                // document.getElementById('pass_placeholder').textContent = "Your password does'nt match";
                // document.getElementById('pass_placeholder').style.color = "red";
            } else if (Pass === Con_Pass) {
                $("#register_btn").removeAttr("onclick")
                document.getElementById('confirm_password').style.borderColor = "green";
                document.getElementById('pass_placeholder').textContent = 'Password Matched';
                document.getElementById('pass_placeholder').style.color = "green";
            } else if (Con_Pass === '') {
                document.getElementById('confirm_password').style.borderColor = "#E5E5E5";
                document.getElementById('pass_placeholder').textContent = "Re-type your password";
                document.getElementById('pass_placeholder').style.color = "black";
            } else {
                // $("#confirm_password").focus()
                document.getElementById('confirm_password').style.borderColor = "red";
                document.getElementById('pass_placeholder').textContent = "Your password does'nt match";
                document.getElementById('pass_placeholder').style.color = "red";
            }
        }
    </script>
    {{-- end of password purpose --}}
@endsection
