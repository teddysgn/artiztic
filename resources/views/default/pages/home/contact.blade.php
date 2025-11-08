@extends('default.main')
@section('content')
<div class="artiz_product_area section-padding-50">
    <div class="container-fluid">
        <div class="cart-table-area">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-12 mb-5">
                        <img src="https://sixdo.vn/images/banners/original/banner-web-03-1609146496.jpg" alt="">
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="checkout_details_area clearfix">
                            <form action="#" method="post" id="formUpdate" name="formUpdate" class="block-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                        <small class="text-danger" id="error-email">
                                            @if ($errors->has('email'))
                                                {!! $errors->first('email') !!}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname" value="">
                                        <small class="text-danger" id="error-fullname"></small>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <textarea name="mesage" id="" cols="30" rows="10" class="form-control" placeholder="Enter Message"></textarea>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <button type="submit" class="btn artiz-btn w-100 btn-submit" disabled>Send Message</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="checkout_details_area clearfix">
                            <div class="cart-title">
                                <h3>Get in touch</h3>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div><h4><i class="fa-solid fa-compass text-primary"></i></h4></div>
                                        <div class="pl-3">Saigon Vietnam</div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div><h4><i class="fa-solid fa-phone text-primary"></i></h4></div>
                                        <div class="pl-3">090.3838.081</div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div><h4><i class="fa-solid fa-envelope text-primary"></i></h4></div>
                                        <div class="pl-3">support@artiz.com</div>
                                    </div>
                                </div>
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
                    errorEmail.textContent  = 'Email is required';
                } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
                    messages.push('Error');
                    errorEmail.textContent  = 'Enter a valid Email';
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
                    document.getElementById("error-email").textContent  = 'Email is required';
                }

                if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                    document.getElementById("error-email").textContent  = 'Enter a valid Email';
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
