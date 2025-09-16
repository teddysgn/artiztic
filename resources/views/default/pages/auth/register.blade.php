

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="cart-title">
                            <h2>ĐĂNG KÝ</h2>
                        </div>

                        <form action="{{ route($controllerName . '/postRegister') }}" method="post" id="formRegister" name="formRegister">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email', '') }}" >
                                    <small class="text-danger" id="error-email">
                                        @if ($errors->has('email'))
                                            {!! $errors->first('email') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" value="" >
                                    <small class="text-danger" id="error-password">
                                        @if ($errors->has('password'))
                                            {!! $errors->first('password') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu" value="" >
                                    <small class="text-danger" id="error-confirm">
                                        @if ($errors->has('password'))
                                            {!! $errors->first('password') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Họ tên" value="{{ old('fullname', '') }}" >
                                    <small class="text-danger" id="error-fullname">
                                        @if ($errors->has('fullname'))
                                            {!! $errors->first('fullname') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-4 mb-3">
                                    <input required type="number" min="1" max="31" name="day" class="form-control" id="day" placeholder="Ngày (DD)" value="{{ old('day', '') }}" >
                                </div>
                                <div class="col-4 mb-3">
                                    <input required type="number" min="1" max="12" name="month" class="form-control" id="month" placeholder="Tháng (MM)" value="{{ old('month', '') }}" >
                                </div>
                                <div class="col-4 mb-3">
                                    <input required type="number" min="@php echo date("Y") - 60 @endphp" max="@php echo date("Y") - 15 @endphp" name="year" class="form-control" id="year" placeholder="Năm (YYYY)" value="{{ old('year', '') }}" >
                                </div>
                                <small class="text-danger col-12" id="error-birth"></small>
                                <div class="col-12 mb-3">
                                    <small>Bằng cách đăng ký tài khoản, bạn chắc chắn rằng đã đọc và hiểu các <a href="{{ route('customer-service/term-of-use') }}"><u>Điều khoản sử dụng</u></a> & <a href="{{ route('customer-service/information-collection') }}"><u>Chính sách bảo mật</u></a> của Artiz</small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="hidden" name="task" value="register">
                                    <button type="submit" class="btn artiz-btn w-100">ĐĂNG KÝ</button>
                                </div>
                                <div class="col-12">
                                    <hr style="width: 100%; height: 0.1px">
                                </div>
                                <div class="col-12">
                                    <p class="text-center">Bạn đã có tài khoản?</p>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <a href="{{ route('auth/login') }}" class="btn artiz-btn-black w-100">ĐĂNG NHẬP</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        const form = document.getElementById('formRegister');
        let email       = document.forms["formRegister"]["email"];
        let password    = document.forms["formRegister"]["password"];
        let confirm     = document.forms["formRegister"]["password_confirmation"];
        let fullname    = document.forms["formRegister"]["fullname"];
        let day         = document.forms["formRegister"]["day"];
        let month       = document.forms["formRegister"]["month"];
        let year        = document.forms["formRegister"]["year"];
        let now         = new Date();
        var date        = new Date(year.value + '-' + month.value + '-' + day.value);

        var errorEmail      = document.getElementById("error-email");
        var errorPassword   = document.getElementById("error-password");
        var errorConfirmm   = document.getElementById("error-confirm");
        var errorFullname   = document.getElementById("error-fullname");
        var errorBirth      = document.getElementById("error-birth");

        form.addEventListener('submit', function handler (e) {
            let messages    = [];

            // email
            errorEmail.textContent      = '';
            if (email.value == "") {
                messages.push('Error');
                errorEmail.textContent  = 'Đây là trường bắt buộc';
            } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
                messages.push('Error');
                errorEmail.textContent  = 'Vui lòng nhập email hợp lệ';
            }

           

            // password
            $("#error-password").addClass('text-danger');
            errorPassword.textContent   = '';
            if (password.value == "") {
                messages.push('Error');
                errorPassword.textContent  = 'Đây là trường bắt buộc';
            } else if (password.value.length < 8) {
                messages.push('Error');
                errorPassword.textContent  = 'Mật khẩu phải có ít nhất 8 ký tự';
            } else if (password.value == password.value.toLowerCase()) {
                messages.push('Error');
                errorPassword.textContent  = 'Mật khẩu phải chứa ít nhất 1 ký tự in hoa';
            }

            // confirm
            errorConfirmm.textContent   = '';
            if (password.value != confirm.value) {
                messages.push('Error');
                errorConfirmm.textContent  = 'Nhập lại mật khẩu không khớp';
            }

            // fullname
            errorFullname.textContent   = '';
            if (fullname.value == '') {
                messages.push('Error');
                errorFullname.textContent  = 'Đây là trường bắt buộc';
            }

            // date
            errorBirth.textContent   = '';
            var date        = new Date(year.value + '-' + month.value + '-' + day.value);
            if (isNaN(Date.parse(date)) || day.value == '' || month.value == '' || year.value == '') {
                messages.push('Error');
                errorBirth.textContent  = 'Vui lòng nhập ngày sinh đúng định dạng (DD/MM/YYYY)';
            } else {
                if (month.value == 02) { // Check for leap year
                    const isLeap = (year.value % 4 == 0 && (year.value % 100 != 0 || year.value % 400 == 0));
                    if (day.value > 29 || (day.value == 29 && !isLeap)) {
                        messages.push('Error');
                        errorBirth.textContent  = 'Ngày tháng không hợp lệ';
                    }
                }
                
                if ((month.value == 4 || month.value == 6 || month.value == 9 || month.value == 11) && day.value == 31) {
                    messages.push('Error');
                    errorBirth.textContent  = 'Ngày tháng không hợp lệ';
                }
            }

            if (year.value > now.getFullYear() - 15) {
                messages.push('Error');
                errorBirth.textContent  = 'Bạn phải đủ từ 15 tuổi trở lên';
            }
            
            if(messages.length > 0){
                e.preventDefault();
            } else {
                form.removeEventListener('submit', handler);
            }
        });


        $('#email').keyup(function(){
            let email       = document.forms["formRegister"]["email"].value;
            document.getElementById("error-email").textContent      = '';
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email == "") {
                document.getElementById("error-email").textContent  = 'Đây là trường bắt buộc';
            }

            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                document.getElementById("error-email").textContent  = 'Vui lòng nhập email hợp lệ';
            }
        });

        $('#password').keyup(function(){
            let password    = document.forms["formRegister"]["password"].value;
            
            $("#error-password").addClass('text-danger');
            document.getElementById("error-password").textContent   = '';
            if (password == "") {
                document.getElementById("error-password").textContent  = 'Đây là trường bắt buộc';
            } else if (password.length < 8) {
                document.getElementById("error-password").textContent  = 'Mật khẩu phải có ít nhất 8 ký tự';
            } else if (password == password.toLowerCase()) {
                document.getElementById("error-password").textContent  = 'Mật khẩu phải chứa ít nhất 1 ký tự in hoa';
            } else {
                $("#error-password").removeClass('text-danger');
                $("#error-password").addClass('text-success');
                document.getElementById("error-password").textContent  = 'Mật khẩu đảm bảo an toàn cần chứa ít nhất 8 ký tự, 1 ký tự in hoa, 1 ký tự in thường và 1 chữ số';
            }
        });

        $('#password_confirmation').keyup(function(){
            let password    = document.forms["formRegister"]["password"].value;
            let confirm     = document.forms["formRegister"]["password_confirmation"].value;
            document.getElementById("error-confirm").textContent   = '';
            if (password != confirm) {
                document.getElementById("error-confirm").textContent  = 'Nhập lại mật khẩu không khớp';
            }
        });

        $('#fullname').keyup(function(){
            let fullname    = document.forms["formRegister"]["fullname"].value;
            document.getElementById("error-fullname").textContent   = '';
            if (fullname == '') {
                document.getElementById("error-fullname").textContent  = 'Đây là trường bắt buộc';
            }
        });

        $('#year').keyup(function(){
            let day     = document.forms["formRegister"]["day"].value;
            let month   = document.forms["formRegister"]["month"].value;
            let year    = document.forms["formRegister"]["year"].value;
            let now     = new Date();
            var date = new Date(year + '-' + month + '-' + day);

            document.getElementById("error-birth").textContent   = '';

            if (isNaN(Date.parse(date)) || year == '') {
                document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh đúng định dạng (DD/MM/YYYY)';
            }

            if (month == 02) { // Check for leap year
                const isLeap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
                if (day > 29 || (day == 29 && !isLeap)) {
                    document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày hợp lệ';
                }
            }


            if (year > now.getFullYear() - 15) {
                document.getElementById("error-birth").textContent  = 'Bạn phải đủ từ 15 tuổi trở lên';
            }
        
        });

        $('#month').keyup(function(){
            let day     = document.forms["formRegister"]["day"].value;
            let month   = document.forms["formRegister"]["month"].value;
            document.getElementById("error-birth").textContent   = '';
            if (day == '') {
                document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh đúng định dạng (DD/MM/YYYY)';
            }
            if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
                document.getElementById("error-birth").textContent  = 'Ngày tháng không hợp lệ';
            }
        });

        $('#day').keyup(function(){
            let day     = document.forms["formRegister"]["day"].value;
            let month   = document.forms["formRegister"]["month"].value;
            if (month == '') {
                document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh đúng định dạng (DD/MM/YYYY)';
            }
            document.getElementById("error-birth").textContent   = '';
            if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
                document.getElementById("error-birth").textContent  = 'Ngày tháng không hợp lệ';
            }
        });
    });
</script>
@endsection