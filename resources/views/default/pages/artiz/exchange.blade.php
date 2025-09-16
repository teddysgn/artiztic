

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>CHÍNH SÁCH ĐỔI HÀNG</h2>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">1. ĐIỂU KIỆN ĐỔI HÀNG</strong>
                                        <div class="container-fluid">
                                            <p><small class="text-primary">1.1. THỜI GIAN ĐỔI:</small></p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li><small>7 ngày kể từ ngày khách hàng nhận được hàng.</small></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p><small class="text-primary">1.2. LOẠI SẢN PHẨM:</small></p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li><small>Áp dụng cho các sản phẩm nguyên giá (không sale).</small></li>
                                                        <li><small>Lỗi do nhà sản xuất.</small></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p><small><span class="text-primary">1.3. TÌNH TRẠNG SẢN PHẨM:</span></small></p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li><small>Chưa qua sử dụng và còn nguyên nhãn mác.</small></li>
                                                        <li><small>Có hóa đơn mua hàng nguyên vẹn.</small></li>
                                                        <li><small>Trường hợp đổi hàng nhưng không có hóa đơn, quý khách vui lòng liên hệ theo Hotline <a href="tel: 0903838081" class="text-primary">0903838081</a> để được hỗ trợ chi tiết.</small></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p><small><span class="text-primary">1.4. HÌNH THỨC ĐỔI HÀNG:</span></small></p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li><small>Đổi 1 lần cho mỗi hóa đơn.</small></li>
                                                        <li><small>Giá trị sản phẩm đổi hàng phải bằng hoặc cao hơn giá sản phẩm đã mua.</small></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">2. TRƯỜNG HỢP TỪ CHỐI ĐỔI HÀNG</strong>
                                        <div class="container-fluid">
                                            <div class="container-fluid">
                                                <ul>
                                                    <li><small>Thời gian nhận hàng <span class="text-primary" style="text-decoration: underline">quá 7 ngày</span>.</small></li>
                                                    <li><small>Nhãn mác <span class="text-primary" style="text-decoration: underline">bị tháo rời</span> khỏi sản phẩm.</small></li>
                                                    <li><small>Sản phẩm đã <span class="text-primary" style="text-decoration: underline">qua sử dụng</span> (bị dơ, rách, hư, rút sợi, phai màu, có mùi khác thường).</small></li>
                                                    <li><small>Sản phẩm <span class="text-primary" style="text-decoration: underline">giảm giá</span>.</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">3. QUY TRÌNH ĐỔI HÀNG</strong>
                                        <div class="container-fluid">
                                            <div class="container-fluid">
                                                <ul>
                                                    <li><small>Liên hệ Hotline <a href="tel: 0903838081" class="text-primary">0903838081</a> để được hướng dẫn chi tiết.</small></li>
                                                    <li><small>Hoặc thực hiện theo các thao tác sau:</small></li>
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Bước 1: Truy cập <a class="text-primary" style="text-decoration: underline" href="{{ route('user/history') }}">lịch sử đơn hàng</a> hoặc <a class="text-primary" style="text-decoration: underline" href="{{ route('user/tracking') }}">tìm kiếm đơn hàng</a> và nhập mã đơn hàng.</small></li>
                                                            <li><small>Bước 2: Click chọn 'Đổi hàng'.</small></li>
                                                            <li><small>Bước 3: Chọn sản phẩm cẩn đổi.</small></li>
                                                            <li><small>Bước 4: Chọn lý do đổi hàng.</small></li>
                                                            <li><small>Bước 5: Gửi yêu cầu.</small></li>
                                                        </ul>
                                                    </div>
                                                    <li><small>Đóng gói sản phẩm kèm hóa đơn và gởi về địa chỉ theo thông tin hướng dẫn.</small></li>
                                                </ul>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>CHÍNH SÁCH TRẢ HÀNG</h2>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">ARTIZ KHÔNG NHẬN TRẢ HÀNG TRONG MỌI TRƯỜNG HỢP </br>BẠN VUI LÒNG KIỂM TRA SẢN PHẨM KỸ TRƯỚC KHI ĐẶT HÀNG</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .checkout_details_area li {
        list-style: disc !important;
    }

    .checkout_details_area p {
        margin-bottom: 0;
        color: black;
    }
</style>
@endsection