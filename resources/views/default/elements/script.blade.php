<button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top"
        >
  <i class="fas fa-arrow-up"></i>
</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->

<!-- Popper js -->
<script src="{{ asset('public/default/js/popper.min.js') }}"></script>
<!-- Bootstrap js -->
<script src="{{ asset('public/default/js/bootstrap.min.js') }}"></script>
<!-- Plugins js -->
<script src="{{ asset('public/default/js/plugins.js') }}"></script>
<!-- Active js -->
<script src="{{ asset('public/default/js/active.js') }}"></script>
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->

<script src="{{ asset('public/default/js/popup.js') }}"></script>
<script>
    var element = document.getElementById('{{ $active }}').className = 'active';
  </script>
<script>
$(document).ready(function() {
  $(window).scroll(function() {
    if ($(this).scrollTop() > 20) {
      $('#scrollUp').fadeIn();
    } else {
      $('#scrollUp').fadeOut();
    }
  });

  $('#scrollUp').click(function() {
    $("html, body").animate({
      scrollTop: 0
    }, 1000);
    return false;
  });
});
  </script>