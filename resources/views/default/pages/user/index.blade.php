@extends('default.pages.user.main')
@section('user')
<hr style="height: 1.1px; background: transparent">
     <div class="cart-table-area">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-12 col-lg-6">
                            <div class="checkout_details_area clearfix">
                                <div class="cart-title">
                                    <h3>Cập nhật tài khoản</h3>
                                </div>
                                @php
                                    $orderdate = explode('-', $user['birthday']);
                                    $year  = $orderdate[0];
                                    $month = $orderdate[1];
                                    $day   = $orderdate[2];
                                @endphp
                                @if (session('artiz_notify_success'))
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <small>{{ session('artiz_notify_success') }}</small>
                                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                        <i style="color: green" class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                @endif
                                <form action="{{ route($controllerName . '/postUpdate') }}" method="post" id="formUpdate" name="formUpdate" class="block-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Email"  value="{{ $user['email'] }}">
                                            <small class="text-danger" id="error-email">
                                                @if ($errors->has('email'))
                                                    {!! $errors->first('email') !!}
                                                @endif
                                            </small>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên" value="{{ $user['fullname'] }}">
                                            <small class="text-danger" id="error-fullname"></small>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="{{ $user['phone'] }}">
                                        </div>
                                        <div class="col-4 col-lg-3  mb-3">
                                            <input required type="number" min="1" max="31" name="day" class="form-control" id="day" placeholder="DD" value="{{ old('day',  $day) }}" >
                                        </div>
                                        
                                        <div class="col-4 col-lg-3 mb-3">
                                            <input required type="number" min="1" max="12" name="month" class="form-control" id="month" placeholder="MM" value="{{ old('month', $month) }}" >
                                        </div>
                                        <div class="col-4 col-lg-3 mb-3">
                                            <input required type="number" min="@php echo date("Y") - 60 @endphp" max="@php echo date("Y") - 15 @endphp" name="year" class="form-control" id="year" placeholder="YYYY" value="{{ old('year', $year) }}" >
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <small class="text-danger" id="error-birth"></small>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Mật khẩu hiện tại (*)"  >
                                            <small class="text-danger" id="error-confirm"></small>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input type="hidden" name="task" value="update">
                                            <input type="hidden" name="option" value="">
                                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                                            <button type="submit" class="btn artiz-btn w-100 btn-submit" disabled>CẬP NHẬT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="checkout_details_area clearfix">
                                <div class="cart-title">
                                    <h3>Thành viên</h3>
                                </div>
                                <div class="row">
                                    @php
                                        $milestone = 0;
                                        foreach($total as $key => $value){
                                            $milestone += str_replace('.', '', $value['total']);
                                        }
                                        
                                        $result = $milestone / $maxMember['max'] * 100;

                                        foreach($members as $key => $value){
                                            if($milestone < $value['min']){
                                                $newMilestone = $value['min'] - $milestone;
                                                $nameMember = $value['name'];
                                                $totalValue = $value['min'];
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="col-12">
                                        <small>Bạn đã dùng <span class="text-danger">{{ number_format($milestone) }}<span class="currency">đ</span></span></small>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small>Mua thêm <span class="text-danger">{{ number_format($newMilestone) }}<span class="currency">đ</span></span> nữa để nâng lên hạng <span class="text-danger">{{ $nameMember }} </span><img style="width: 20px" src="{{ asset('public/default/img/member/'.strtolower($nameMember).'.png') }}" alt=""></small>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $result }}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="50000000"></div>
                                        </div>
                                        
                                        <div class="row pt-2" style="position: relative">
                                            <div  style="left: 0%; position: absolute; padding-left: 15px"><img style="width: 30px" src="{{ asset('public/default/img/member/opal.png') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Opal - 0%"></div>
                                            <div  style="left: 19%; position: absolute"><img style="width: 30px" src="{{ asset('public/default/img/member/topaz.png') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Topaz - 5%"></div>
                                            <div  style="left: 57%; position: absolute"><img style="width: 30px" src="{{ asset('public/default/img/member/ruby.png') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Ruby - 10%"></div>
                                            <div  style="right: 0%; left: auto; position: absolute; padding-right: 15px"><img style="width: 30px" src="{{ asset('public/default/img/member/diamond.png') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Diamond - 15%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            const form      = document.getElementById('formUpdate');
            let email       = document.forms["formUpdate"]["email"];
            let fullname    = document.forms["formUpdate"]["fullname"];
            let day         = document.forms["formUpdate"]["day"];
            let month       = document.forms["formUpdate"]["month"];
            let year        = document.forms["formUpdate"]["year"];
            let now         = new Date();

            var errorEmail      = document.getElementById("error-email");
            var errorFullname   = document.getElementById("error-fullname");
            var errorBirth      = document.getElementById("error-birth");

            form.addEventListener('submit', function handler (e) {
                let messages    = [];

                e.preventDefault();
                // email
                errorEmail.textContent      = '';
                if (email.value == "") {
                    messages.push('Error');
                    errorEmail.textContent  = 'Đây là trường bắt buộc nhập';
                } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
                    messages.push('Error');
                    errorEmail.textContent  = 'Vui lòng nhập đùng Email';
                }

                // fullname
                errorFullname.textContent   = '';
                if (fullname.value == '') {
                    messages.push('Error');
                    errorFullname.textContent  = 'Đây là trường bắt buộc nhập';
                }

                // date
                errorBirth.textContent   = '';
                if(day.value == '' || month.value == '' || year.value == ''){
                    messages.push('Error');
                    errorBirth.textContent  = 'Vui lòng nhập ngày sinh theo định dạng (DD/MM/YYYY)';
                } else {
                    var date        = new Date(year.value + '-' + month.value + '-' + day.value);
                    if (isNaN(Date.parse(date))) {
                    messages.push('Error');
                    errorBirth.textContent  = 'Vui lòng nhập ngày sinh theo định dạng (DD/MM/YYYY)';
                    } else {
                        if (month.value == 02) { // Check for leap year
                            const isLeap = (year.value % 4 == 0 && (year.value % 100 != 0 || year.value % 400 == 0));
                            if (day.value > 29 || (day.value == 29 && !isLeap)) {
                                messages.push('Error');
                                errorBirth.textContent  = 'Ngày sinh không hợp lệ';
                            }
                        }
                        
                        if ((month.value == 4 || month.value == 6 || month.value == 9 || month.value == 11) && day.value == 31) {
                            messages.push('Error');
                            errorBirth.textContent  = 'Ngày sinh không hợp lệ';
                        }
                    }
                }

                if (year.value > now.getFullYear() - 15) {
                    messages.push('Error');
                    errorBirth.textContent  = 'Bạn phải đủ 15 tuổi trở lên';
                }
                
                if(messages.length > 0){
                    console.table(messages);
                    e.preventDefault();
                } else {
                    form.removeEventListener('submit', handler);
                }
            });


            $('#email').keyup(function(){
                let email       = document.forms["formUpdate"]["email"].value;
                document.getElementById("error-email").textContent      = '';
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email == "") {
                    document.getElementById("error-email").textContent  = 'Đây là trường bắt buộc nhập';
                }

                if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                    document.getElementById("error-email").textContent  = 'Vui lòng nhập đùng Email';
                }
            });

            $('#password_confirmation').keyup(function(){
                let confirm     = document.forms["formUpdate"]["password_confirmation"].value;
                document.getElementById("error-confirm").textContent   = '';

                if (confirm == "") {
                    document.getElementById("error-confirm").textContent  = 'Đây là trường bắt buộc nhập';
                } else {
                    $.ajax({
                    url: "{{ route('user/check-password') }}",
                    type: "GET",
                    data: {
                        confirm_password: confirm,
                    },
                    success: function(response){
                        if (response == false) {
                            document.getElementById("error-confirm").textContent  = 'Mật khẩu hiện tại không khớp';
                            $('.btn-submit').attr('disabled','disabled');
                        } else {
                            document.getElementById("error-confirm").textContent  = '';
                            $('.btn-submit').removeAttr("disabled");
                        }
                    }
                });
                }
                
                
            });

            $('#fullname').keyup(function(){
                let fullname    = document.forms["formUpdate"]["fullname"].value;
                document.getElementById("error-fullname").textContent   = '';
                if (fullname == '') {
                    document.getElementById("error-fullname").textContent  = 'Đây là trường bắt buộc nhập';
                }
            });

            $('#year').keyup(function(){
                let day     = document.forms["formUpdate"]["day"].value;
                let month   = document.forms["formUpdate"]["month"].value;
                let year    = document.forms["formUpdate"]["year"].value;
            
                let now     = new Date();
                var date = new Date(year + '-' + month + '-' + day);

                document.getElementById("error-birth").textContent   = '';

                if (isNaN(Date.parse(date)) || year == '') {
                    document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh theo định dạng (DD/MM/YYYY)';
                }

                if (month == 02) { // Check for leap year
                    const isLeap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
                    if (day > 29 || (day == 29 && !isLeap)) {
                        document.getElementById("error-birth").textContent  = 'Ngày sinh không hợp lệ';
                    }
                }


                if (year > now.getFullYear() - 15) {
                    document.getElementById("error-birth").textContent  = 'Bạn phải đủ 15 tuổi trở lên';
                }
            
            });

            $('#month').keyup(function(){
                let day     = document.forms["formUpdate"]["day"].value;
                let month   = document.forms["formUpdate"]["month"].value;
                let year    = document.forms["formUpdate"]["year"].value;
                document.getElementById("error-birth").textContent   = '';

                if (day == '' || month == '') {
                    alert(123);
                    document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh theo định dạng (DD/MM/YYYY)';
                }
                if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
                    document.getElementById("error-birth").textContent  = 'Ngày sinh không hợp lệ';
                }

                if (month == 02) { // Check for leap year
                    const isLeap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
                    if (day > 29 || (day == 29 && !isLeap)) {
                        document.getElementById("error-birth").textContent  = 'Ngày sinh không hợp lệ';
                    }
                }
            });

            $('#day').keyup(function(){
                let day     = document.forms["formUpdate"]["day"].value;
                let month   = document.forms["formUpdate"]["month"].value;
                let year    = document.forms["formUpdate"]["year"].value;
                if (day == null ) {
                    document.getElementById("error-birth").textContent  = 'Vui lòng nhập ngày sinh theo định dạng (DD/MM/YYYY)';
                }
                document.getElementById("error-birth").textContent   = '';
                if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
                    document.getElementById("error-birth").textContent  = 'Ngày sinh không hợp lệ';
                }

                if (month == 02) { // Check for leap year
                    const isLeap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
                    if (day > 29 || (day == 29 && !isLeap)) {
                        document.getElementById("error-birth").textContent  = 'Ngày sinh không hợp lệ';
                    }
                }
            });
        });
    </script>

    <style>
    .progress {
        height: 0.25rem;
    }
    .progress-bar {
      background: #968B7E;
    }
    </style>

@endsection
