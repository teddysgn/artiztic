

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>ĐIỀU KHOẢN CỦA ARTIZ</h2>
                            <small>Cập nhật lần cuối 24/09/2024</small>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">1. THÔNG BÁO QUAN TRỌNG</strong>
                                        <div class="container-fluid">
                                            <div class="container-fluid">
                                                <small>CÁC ĐIỀU KHOẢN TRONG DỊCH VỤ NÀY CHỨA MỘT SỐ THỎA THUẬN VÀ YÊU CẦU GIỮA BẠN VÀ ARTIZ STORE (GỌI TẮT LÀ ARTIZ).
                                                    BẰNG VIỆC TRUY CẬP, SỬ DỤNG VÀ/HOẶC MUA BẤT KỲ SẢN PHẨM NÀO THÔNG QUA CÁC DỊCH VỤ, HÃY CHẮC CHẮN RẰNG BẠN ĐÃ ĐỌC VÀ HIỂU CÁC ĐIỀU KHOẢN TRONG TỪNG THỎA THUẬN VÀ ĐÃ DÀNH THỜI GIAN ĐỂ XEM XÉT CÁC QUYẾT ĐỊNH NÀY.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">2. ĐIỀU KHOẢN SỬ DỤNG</strong>
                                        <div class="container-fluid">
                                            <p class="text-primary">2.1. Lời nói đầu</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Chào mừng bạn đến với trang web Artiz, <a href="artiz.store"><u>www.artiz.store</u></a>, Điều khoản này sẽ chi phối việc bạn sử dụng các trang web, ứng dụng di động và bất kỳ chương trình, công cụ, ứng dụng, phần mềm kỹ thuật, tính năng, trò chơi, trải nghiệm hoặc các tài liệu do Artiz cung cấp.
                                                            Các điều khoản này bao gồm <a href="{{ route('customer-service/information-collection') }}"><u>Chính sách quyền riêng tư</u></a>, được đưa vào đây để tham khảo. 
                                                            Các dịch vụ được cung cấp tùy thuộc vào việc bạn chấp nhận các điều khoản này. 
                                                            Các điều khoản này tạo thành một thỏa thuận ràng buộc về mặt pháp lý giữa bạn với Artiz và bạn nên đọc kỹ các điều khoản này. Bạn đồng ý các điều khoản này bằng cách sử dụng các dịch vụ của Artiz. 
                                                            Các điều khoản bổ sung có thể chi phối một số tính năng hoặc nội dung nhất định trên dịch vụ, chẳng hạn như chương trình mua hàng và chương trình giảm giá, đăng ký tài khoản, ưu đãi, và bằng cách tham gia vào bất kỳ hoạt động nào bạn đồng ý rằng bạn sẽ phải tuân theo các điều khoản bổ sung đó ngoài các điều khoản này.</small></li>
                                                        <li class="mb-3"><small>Artiz có thể sửa đổi các điều khoản này theo thời gian. Vui lòng xem lại định kỳ phiên bản của các điều khoản này. Bằng cách nhấp vào "Tôi đồng ý", "ok" hoặc tiếp tục sử dụng trang web sau khi Artiz cung cấp phiên bản sửa đổi của các điều khoản này, bạn thừa nhận, đồng ý và chấp thuận việc sửa đổi đó.</small></li>
                                                        <li class="mb-3"><small>NẾU BẠN ĐỒNG Ý VỚI CÁC ĐIỀU KHOẢN NÀY, BẠN CÓ THỂ TRUY CẬP VÀ SỬ DỤNG DƯỚI SỰ THỎA THUẬN VÀ RÀNG BUỘC GIỮA BẠN VÀ ARTIZ.</small></li>
                                                        <li class="mb-3"><small>NẾU BẠN KHÔNG ĐỒNG Ý VỚI CÁC ĐIỀU KHOẢN NÀY, BẠN KHÔNG ĐƯỢC TRUY CẬP, DUYỆT HOẶC SỬ DỤNG TRANG WEB HOẶC CÁC DỊCH VỤ KHÁC VÀ NÊN NGỪNG HOẠT ĐỘNG CỦA BẠN NGAY LẬP TỨC. NẾU BẠN TRUY CẬP VÀO CÁC DỊCH VỤ CỦA ARTIZ, BẠN ĐANG ĐỒNG Ý VỚI CÁC ĐIỀU KHOẢN NÀY.</small></li>
                                                        <li class="mb-3"><small>Khi sử dụng dịch vụ, bạn phải tuân theo tất cả các quy tắc và chính sách được hiển thị. Các quy tắc và chính sách đó được đưa vào đây bằng cách tham chiếu vào các điều khoản này.</small></li>
                                                        <li class="mb-3"><small>Artiz không tuyên bố rằng các dịch vụ được quản lý hoặc vận hành theo luật pháp của các quốc gia khác hoặc bất kỳ địa điểm cụ thể nào. 
                                                            Nếu bạn chọn truy cập các dịch vụ, bạn tự chịu rủi ro và bạn có trách nhiệm tuân thủ mọi luật pháp, quy tắc và quy định của địa phương.</small></li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.2. Về dịch vụ của Artiz</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Artiz cung cấp cho người dùng quyền truy cập vào dịch vụ, có thể truy cập thông qua bất kỳ phương tiện hoặc thiết bị nào hiện được biết đến hoặc được phát minh sau này, bao gồm các trang web, phần mềm và ứng dụng cung cấp và nhận thông tin thông qua mạng lưới mạng. Trừ khi được nêu rõ ràng khác, bất kỳ công cụ mới nào thay đổi hoặc cải thiện dịch vụ hiện tại sẽ được bao gồm trong định nghĩa về "Truy cập các dịch vụ".</small></li>
                                                        <li class="mb-3"><small>Dịch vụ của Artiz cung cấp thông tin và cơ hội mua nhiều loại sản phẩm khác nhau.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.3. Truy cập các dịch vụ</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Bạn có thể truy cập một số phần của dịch vụ mà không cần tạo tài khoản. 
                                                            Tuy nhiên, để truy cập một số phần và tính năng của dịch vụ, bạn sẽ được yêu cầu tạo tài khoản và đăng nhập vào dịch vụ. 
                                                            Bạn phải đảm bảo rằng dữ liệu này và bất kỳ thông tin nào khác mà bạn cung cấp cho Artiz liên quan đến dịch vụ là chính xác và được cập nhật. 
                                                            Bạn chỉ có thể có một tài khoản tại bất kỳ thời điểm nào. 
                                                            Bạn có trách nhiệm duy trì tính bảo mật của tên người dùng, mật khẩu và thông tin khác được sử dụng để đăng ký và đăng nhập vào dịch vụ và bạn hoàn toàn chịu trách nhiệm cho mọi hoạt động diễn ra dưới mật khẩu và tên người dùng này.</small></li>
                                                        <li class="mb-3"><small>Vui lòng thông báo ngay cho Artiz về bất kỳ hành vi sử dụng trái phép nào đối với tài khoản của bạn hoặc bất kỳ vi phạm bảo mật nào khác bằng cách liên hệ với Artiz theo địa chỉ <a href="mailto: letter@artiz.store"><u>letter@artiz.store</u></a>. 
                                                            Trong trường hợp bạn sử dụng dịch vụ của Artiz qua thiết bị di động, bạn thừa nhận rằng các mức giá và phí thông thường của nhà mạng của bạn, chẳng hạn như phí băng thông rộng vượt mức, vẫn có thể được áp dụng.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.4. Sản phẩm & Mua hàng</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Bạn chỉ có thể sử dụng Dịch vụ để đặt hàng sản phẩm theo điều khoản của Artiz. 
                                                            Tất cả sản phẩm đều tùy thuộc vào tình trạng còn hàng. 
                                                            Artiz có quyền áp đặt giới hạn số lượng cho bất kỳ đơn hàng nào, từ chối toàn bộ hoặc một phần đơn hàng và ngừng cung cấp sản phẩm và kèm theo lý do. 
                                                            Việc bạn đặt hàng với tư cách là khách hàng không nhất thiết đảm bảo rằng Artiz sẽ chấp nhận đơn hàng của bạn. 
                                                            Artiz có quyền từ chối bất kỳ đơn hàng nào theo quyết định riêng của mình. 
                                                            Ngoài ra, trước khi chấp nhận đơn hàng của bạn, Artiz có thể yêu cầu thông tin bổ sung nếu bạn chưa cung cấp tất cả thông tin mà Artiz yêu cầu để hoàn tất đơn hàng của bạn. 
                                                            Artiz có quyền sửa bất kỳ lỗi nào trong đơn hàng hoặc hủy đơn hàng và hoàn lại số tiền đó cho bạn.</small></li>
                                                        <li class="mb-3"><small>NẾU BẠN NHẬN ĐƯỢC ĐƠN HÀNG MÀ BẠN TIN RẰNG CÓ SAI SÓT, ARTIZ KHUYẾN KHÍCH BẠN LIÊN HỆ NGAY VỚI ARTIZ ĐỂ ARTIZ CÓ THỂ SỬA LỖI.</small></li>
                                                        <li class="mb-3"><small>Mặc dù Artiz nỗ lực hợp lý để cung cấp thông tin giá cả và mô tả sản phẩm chính xác, nhưng lỗi về giá cả, lỗi đánh máy hoặc lỗi liên quan đến tình trạng sẵn có của sản phẩm vẫn có thể xảy ra. 
                                                            Artiz có quyền sửa những lỗi đó. Artiz không thể đảm bảo rằng thông tin hiển thị trên trang web là chính xác 100%. 
                                                            Trong trường hợp sản phẩm được liệt kê với mức giá không chính xác hoặc mô tả sản phẩm không chính xác, Artiz có quyền, theo quyết định riêng của mình, từ chối bất kỳ đơn hàng nào hoặc hủy bất kỳ đơn hàng nào đã đặt cho sản phẩm đó. 
                                                            Trong những trường hợp đó, nếu bạn đã thanh toán cho đơn hàng, Artiz sẽ hoàn lại tiền vào cho bạn trong khoảng thời gian hợp lý về mặt thương mại.</small></li>
                                                        <li class="mb-3"><small>Artiz nỗ lực để hiển thị màu sắc của sản phẩm một cách chính xác nhất có thể. 
                                                            Tuy nhiên, màu sắc thực tế bạn nhìn thấy phụ thuộc vào màn hình hoặc thiết bị của bạn và do đó Artiz không thể đảm bảo rằng màu sắc của sản phẩm bạn nhìn thấy khi xem dịch vụ sẽ chính xác.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.5. Chính sách vận chuyển và đổi trả</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Vui lòng truy cập vào <a href="{{ route('customer-service/shipping') }}"><u>Chính sách vận chuyển</u></a> và <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi trả</u></a> để biết thêm thông tin về giá chi phí vận chuyển cũng như các chính sách và thủ tục khác, tất cả đều được đưa vào đây để tham khảo.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.6. Nội dung người dùng</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Bạn và những người dùng khác có thể tải lên, đăng, tạo, cung cấp, gửi, chia sẻ, truyền đạt hoặc truyền dữ liệu (Đăng), thông tin, hình ảnh, bình luận, đánh giá, ý tưởng hoặc văn bản (Nội dung) đến dịch vụ của Artiz. 
                                                            Bạn hiểu rằng mọi nội dung do người dùng đăng là trách nhiệm của Artiz, tuy nhiên không kiểm soát nội dung của người dùng và Artiz không đưa ra bất kỳ bảo đảm nào liên quan đến nội dung của người dùng. 
                                                            Mặc dù đôi khi Artiz có xem xét nội dung của người dùng, nhưng Artiz không có nghĩa vụ phải làm như vậy. Trong mọi trường hợp, Artiz sẽ không chịu trách nhiệm theo bất kỳ cách nào đối với bất kỳ khiếu nại nào liên quan đến dội dung của người dùng.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.7. Đánh giá & Bình luận</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Artiz khuyến khích người dùng gửi phản hồi về trải nghiệm với Artiz và/hoặc sản phẩm của Artiz, vì phản hồi của khách hàng giúp Artiz cải thiện dịch vụ và kết nối với cộng đồng của mình. 
                                                            Bằng cách gửi nội dung của người dùng có chứa đánh giá về sản phẩm, bạn đồng ý rằng:</small></li>
                                                            <div class="container-fluid">
                                                                <ul>
                                                                    <li class="mb-3"><small>Đánh giá tuân thủ các điều khoản.</small></li>
                                                                    <li class="mb-3"><small>Trên thực tế, bạn là người dùng sản phẩm hoặc dịch vụ đang được đánh giá và là người đã trải nghiệm sản phẩm.</small></li>
                                                                    <li class="mb-3"><small>Đánh giá phản ánh ý kiến ​​trung thực dựa trên trải nghiệm thực tế của bạn khi sử dụng sản phẩm.</small></li>
                                                                    <li class="mb-3"><small>Đánh giá sẽ được hiển thị khi Artiz chấp nhận.</small></li>
                                                                </ul>
                                                            </div>
                                                        <li class="mb-3"><small>Artiz có quyền không đăng hoặc xóa bất kỳ đánh giá nào khi:</small></li>
                                                            <div class="container-fluid">
                                                                <ul>
                                                                    <li class="mb-3"><small>Nội dung không phù hợp.</small></li>
                                                                    <li class="mb-3"><small>Không liên quan đến hàng hóa hoặc dịch vụ do Artiz cung cấp.</small></li>
                                                                    <li class="mb-3"><small>Nội dung sai lệch hoặc gây hiểu lầm.</small></li>
                                                                    <li class="mb-3"><small>Quấy rối hoặc lạm dụng, không phù hợp về chủng tộc, giới tính, khuynh hướng tình dục, dân tộc hoặc các vấn đề về chính trị, quốc gia.</small></li>
                                                                    <li class="mb-3"><small>Phỉ báng, bôi nhọ hoặc vu khống.</small></li>
                                                                    <li class="mb-3"><small>Vi phạm các điều khoản.</small></li>
                                                                </ul>
                                                            </div>
                                                        <li class="mb-3"><small>Artiz cố gắng kiểm tra và hiển thị đánh giá trong khoảng thời gian hợp lý sau khi gửi thành công cho Artiz. Nếu đánh giá không được hiển sau khi bạn gửi cho Artiz, thì có thể đánh giá đó đã vi phạm điều khoản.</small></li>
                                                        <li class="mb-3"><small>Xin lưu ý rằng đánh giá về dịch vụ có thể được người khác xem. Artiz không thể đảm bảo rằng bạn sẽ có bất kỳ biện pháp khắc phục nào thông qua dịch vụ của Artiz.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.7. Vô hiệu hóa tài khoản</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Bạn đồng ý rằng Artiz có thể, mà không cần thông báo trước, ngay lập tức chấm dứt, hạn chế quyền truy cập của bạn hoặc đình chỉ tài khoản của bạn dựa trên bất kỳ điều nào sau đây:</small></li>
                                                            <div class="container-fluid">
                                                                <ul>
                                                                    <li class="mb-3"><small>Vi phạm các Điều khoản</small></li>
                                                                    <li class="mb-3"><small>Theo yêu cầu của cơ quan thực thi pháp luật.</small></li>
                                                                    <li class="mb-3"><small>Các vấn đề hoặc sự cố kỹ thuật hoặc bảo mật không lường trước được.</small></li>
                                                                    <li class="mb-3"><small>Thời gian không hoạt động kéo dài hoặc hoạt động gian lận, lừa đảo hoặc bất hợp pháp hoặc hoạt động khác mà Artiz tin rằng có hại cho dịch vụ hoặc lợi ích kinh doanh của Artiz.</small></li>
                                                                    <li class="mb-3"><small>Phỉ báng, bôi nhọ hoặc vu khống.</small></li>
                                                                </ul>
                                                            </div>
                                                        <li class="mb-3"><small>Bạn đồng ý rằng việc chấm dứt, hạn chế quyền truy cập và/hoặc đình chỉ sẽ được thực hiện theo quyết định riêng của Artiz và Artiz sẽ không chịu trách nhiệm với bạn hoặc bất kỳ bên thứ ba nào về việc chấm dứt, hạn chế quyền truy cập và/hoặc đình chỉ tài khoản của bạn.</small></li>
                                                        <li class="mb-3"><small>Bạn có thể chấm dứt tài khoản của mình với Artiz và các điều khoản này bất kỳ lúc nào bằng cách gửi email cho Artiz theo địa chỉ <a href="mailto: letter@artiz.store"><u>letter@artiz.store</u></a>.</small></li>
                                                        <li class="mb-3"><small>Sau khi chấm dứt, bạn sẽ không còn quyền truy cập vào tài khoản hoặc nội dung người dùng của mình nữa. 
                                                            Artiz sẽ không có nghĩa vụ hỗ trợ bạn di chuyển dữ liệu hoặc nội dung người dùng của bạn và Artiz có thể không lưu giữ bất kỳ bản sao lưu nào của bất kỳ nội dung người dùng nào của bạn. Artiz sẽ không chịu trách nhiệm xóa nội dung người dùng của bạn.</small></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <p class="text-primary">2.8. Các điều khoản khác</p>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li class="mb-3"><small>Các điều khoản này cấu thành toàn bộ thỏa thuận giữa bạn với Artiz và điều chỉnh việc bạn sử dụng dịch vụ cũng như các giao dịch mua được thực hiện trên đó.</small></li>
                                                        <li class="mb-3"><small>Các điều khoản này và các quyền, lợi ích và nghĩa vụ có trong đây hoàn toàn có thể được Artiz chuyển nhượng và sẽ ràng buộc và có lợi cho những người kế nhiệm và người được chuyển nhượng của Artiz. 
                                                            Bạn không được chuyển nhượng hoặc chuyển giao các điều khoản này, thông qua hoạt động của luật pháp hoặc cách khác, mà không có sự đồng ý trước bằng văn bản của Artiz.</small></li>
                                                        <li class="mb-3"><small>Không bên nào, cũng như bất kỳ luật sư nào của các bên, được coi là người soạn thảo thỏa thuận này nhằm mục đích giải thích bất kỳ điều khoản nào tại đây trong bất kỳ thủ tục tư pháp hoặc thủ tục nào khác có thể phát sinh giữa các bên.</small></li>
                                                        <li class="mb-3"><small>Trừ khi có quy định rõ ràng khác trong các điều khoản này, sẽ không có bên thứ ba nào được hưởng lợi từ thỏa thuận này.</small></li>
                                                        <li class="mb-3"><small>Bất kỳ sự từ bỏ điều khoản nào của trong các điều khoản này phải được thực hiện bằng văn bản.</small></li>
                                                        <li class="mb-3"><small>Nếu bất kỳ điều khoản nào trong các điều khoản này được tòa án có thẩm quyền phán quyết là không hợp lệ, tòa án vẫn phải nỗ lực thực hiện ý định của các bên như được phản ánh trong điều khoản đó và các điều khoản khác trong các điều khoản này vẫn có hiệu lực đầy đủ.</small></li>
                                                        <li class="mb-3"><small>Các tiêu đề trong điều khoản này chỉ nhằm mục đích thuận tiện và không có hiệu lực pháp lý hoặc hợp đồng.</small></li>
                                                    </ul>
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