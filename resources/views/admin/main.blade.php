<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.elements.head')
</head>

<body class="">
    <div class="wrapper">
      <!-- Sidebar -->
      @include('admin.elements.sidebar')
      <!-- End Sidebar -->
        <div class="main-panel">
            <!-- Navbar -->
            @include('admin.elements.navbar')
            <!-- End Navbar -->
            
            <!-- Content -->
            @yield('content')
            <!-- End Content -->

        </div>
    </div>
    
    @include('admin.elements.footer')
    @include('admin.elements.script')
</body>

</html>
