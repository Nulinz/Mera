
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- StyleSheets CDN -->

    <!-- Stylesheets -->
    @include('dlr.layouts.cdn_style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">

</head>
<style>
    #phone_val1 {
        display: none;
        color: red;
        font-size: 13px;
    }
</style>

<body>

    <!-- Login Nav -->
    <div class="loginnav d-flex justify-content-end align-items-center mt-2">
        <div class="loginlogo">
            <img src="{{ asset('assets/images/logo.png') }}" height="50px" alt="">
        </div>
    </div>

    <!-- Login Div -->
    <div class="login">
        <div class="logindiv">

            <div class="loginimg d-flex justify-content-center align-items-center mx-auto">
                <img src="{{ asset('assets/images/registerimg.png') }}" width="80%" alt="">
            </div>

            <div class="loginform mx-auto">
                <h1 class="text-center">Register</h1>
                <h6 class="text-center">Enter Your Details to Register.</h6>
                <div class="formdiv container">
                    <form action="" class="row" method="post">
                        <div class="col-md-8">
                            <label for="name">Company Name <span>*</span></label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-building-user"></i>
                                <input type="text" name="c_name" id="c_name" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="dr">Name <span>*</span></label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="name" id="name" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="email">Email ID <span>*</span></label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="contact">Contact Number <span>*</span></label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-phone"></i>
                                <input type="number" name="c_contact" id="clinic_contact" oninput="validate(this)"
                                    min="1000000000" max="9999999999" required>
                            </div>
                            <p id="phone_val1"></p>
                        </div>
                        <div class="col-md-8">
                            <label for="password">Password <span>*</span></label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" name="c_password" id="password" minlength="6" required>
                                <i class="fa-solid fa-eye-slash" id="passShow_1"
                                    onclick="togglePasswordVisibility('password')" style="cursor:pointer;"></i>
                                <i class="fa-solid fa-eye" id="passHide_1"
                                    onclick="togglePasswordVisibility('password')"
                                    style="display:none; cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="col-md-8 d-flex justify-content-center align-items-center button">
                            <input hidden type="text" name="regs_btn" id="">
                            <button type="submit" id="submitbtn" class="loginbtn">Register</button>
                        </div>
                        <div class="col-md-8 text-center">
                            <h5>Already have an account ? <a href="./index.php">Login</a></h5>
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

<script>
    $(document).ready(function() {
        $('#clinic_contact').on('change', function() {
            var cli_contact = $('#clinic_contact').val();


            // alert(table);
            $.ajax({
                url: 'maindb_ajax.php',
                type: 'POST',
                data: {
                    user_contact: cli_contact
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response.count);

                    if (response.count > 0) {
                        $('#phone_val1').text("Phone Number Already Exists").show();
                        $('#submitbtn').prop('disabled', true);
                    } else {
                        $('#phone_val1').hide();
                        $('#submitbtn').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                }
            });
        })
    })
</script>

</html>
