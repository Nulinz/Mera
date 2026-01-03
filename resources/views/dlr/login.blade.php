<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Stylesheets -->
    @include('dlr.layouts.cdn_style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">


</head>

<body>

    <!-- Login Nav -->
    <div class="loginnav mt-2">
        <div class="loginlogo">
            <img src="{{ asset('assets/images/logo.png') }}" height="50px" alt="">
        </div>
    </div>

    <!-- Login Div -->
    <div class="login">
        <div class="logindiv">

            <div class="loginimg d-flex justify-content-center align-items-center mx-auto">
                <img src="{{ asset('assets/images/loginimg.png') }}" width="80%" alt="">
            </div>

            <div class="loginform mx-auto">
                <h1 class="text-center">Login</h1>
                <h6 class="text-center">Enter your Contact Number and Password to access your account...</h6>
                <div class="formdiv container">
                    <form action="#" class="row" method="post" id="id_form" onsubmit="return btn_disable(this)">
                        <div class="col-md-8">
                            <label for="name">Contact Number</label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-phone"></i>
                                <input type="number" name="phone" id="contact" oninput="validate(this)" max="9999999999" autofocus>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="password">Password</label><br>
                            <div class="d-flex justify-content-between align-items-center pass">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" minlength="6" name="password" id="password" required>
                                <i class="fa-solid fa-eye-slash" id="passShow_1"
                                    onclick="togglePasswordVisibility('password')" style="cursor:pointer;"></i>
                                <i class="fa-solid fa-eye" id="passHide_1"
                                    onclick="togglePasswordVisibility('password')"
                                    style="display:none; cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="col-md-8 d-flex justify-content-end align-items-center forgot">
                            <a href="./forgot_password.php">
                                <p class="m-0">Forgot Password ?</p>
                            </a>
                        </div>
                        <div class="col-md-8 d-flex justify-content-center align-items-center button">
                            <input hidden type="text" name="login">
                            <a class="w-100 d-flex justify-content-center align-items-center"><button type="submit" id="submitBtn" class="loginbtn">Login</button></a>
                        </div>
                        <div class="col-md-8 text-center">
                            <h5>Don't have an account ? <a href="./register.php">Register</a></h5>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts CDN -->
    @include('dlr.layouts.cdn_script')

</body>

<script>
    function togglePasswordVisibility(inputId) {
        let $input = $('#' + inputId);
        let $passShow = $('#passShow_1');
        let $passHide = $('#passHide_1');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $passShow.hide();
            $passHide.show();
        } else {
            $input.attr('type', 'password');
            $passShow.show();
            $passHide.hide();
        }
    }
</script>

</html>
