<!DOCTYPE html>
<html lang="en">

<head>
    @include('default.elements.head')
</head>

<body id="body" class="over-flow-hidden">
    <div id="preloader">
		<div class="preloader-logo">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1724 2048" width="120">
                <path id="Path_1" transform="translate(861,1)" d="m0 0h2l12 28 19 45 17 40 17 41 38 90 20 48 23 54 36 86 17 40 19 45 17 41 17 40 19 45 17 41 17 40 19 45 17 41 17 40 19 45 18 43 16 38 19 45 36 86 23 54 17 41 19 45 20 47 19 46 20 47 19 45 17 41 19 45 20 47 17 41 19 45 17 40 17 41 19 45 17 40 20 48 19 45 17 40 20 48 19 45 1 3-1 1h-498v-46l54-1 19-3 17-5 21-10 13-9 13-11 11-12 12-18 9-19 6-20 2-13v-30l-4-21-10-28-15-39-27-72-21-55-18-48-23-61-18-47-18-48-17-45-21-55-15-40-11-29v-2l-137 19-24 4-20 6-19 9-13 9-12 11-8 9-9 14-8 16-6 18-5 25-3 34-15 209-14 191-15 205-1 7-1 1h-24l-1-1-9-120-20-274-14-193-4-54-4-23-6-20-7-16-8-14-9-11-13-13-15-10-16-8-15-5-17-4-152-21-1 5-26 70-15 39-16 42-24 64-21 55-26 69-20 53-16 42-15 40-20 53-11 29-5 18-2 14v24l3 19 7 21 8 16 10 15 13 15 11 9 13 9 15 8 17 6 17 4 9 1 54 1v46h-498l1-5 35-84 23-54 18-43 20-48 23-54 36-86 17-40 16-38 17-41 23-54 36-86 17-40 36-86 17-40 19-45 12-29 19-45 17-40 15-36 18-43 17-40 36-86 20-47 36-86 20-47 20-48 38-90 36-86 23-54 17-41 19-45 17-40 20-48 38-90 20-48 17-40 19-45zm-16 454-17 45-16 42-24 64-18 47-26 69-20 53-21 55-27 72-19 50-17 45-23 61-18 47-33 88 1 3 122-17 25-6 20-8 15-9 11-9 10-10 11-15 8-15 7-19 5-21 3-24 17-237 14-191 11-150v-10zm33 0 1 19 23 315 15 207 4 55 4 24 6 21 7 16 8 14 9 11 10 11 15 11 19 10 22 7 22 4 107 15h8l-1-6-26-69-17-45-18-47-27-72-21-55-24-64-22-58-16-42-15-40-17-45-16-42-17-45-18-48-18-47-6-15z" fill="#800020"/>
            </svg>
		</div>
	</div>
    
    <div class="main-content-wrapper d-flex clearfix">
        @include('default.elements.sidebar')
        
        <!-- Header Area End -->
    
        <!-- Product Catagories Area Start -->
        @yield('content')
        <!-- Product Catagories Area End -->
    </div>
   

    @include('default.elements.footer')
    @include('default.elements.script')
    <script>
        window.addEventListener('load', () => {
            const loader = document.querySelector('.preloader-logo');
            const parentLoader = document.querySelector('#preloader');
            $('#body').removeClass('over-flow-hidden');
            parentLoader.classList.add('loader-hidden');
        })

        
    </script>
</body>
</html>