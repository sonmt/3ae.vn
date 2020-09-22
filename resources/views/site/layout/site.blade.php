<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta name="ROBOTS" content="index, follow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="title" content="@yield('title')" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="geo.position" content="10.763945;106.656201" />
    <meta itemprop="image" content="@yield('meta_image')" />

    <!-- facebook gooogle -->
    <link rel="canonical" href="@yield('meta_url')" />
    <meta property="og:url"                content="@yield('meta_url')" />
    <meta property="og:type"               content="Website" />
    <meta property="og:title"              content="@yield('title')" />
    <meta property="og:description"        content="@yield('meta_description')" />
    <meta property="og:image"              content="@yield('meta_image')" />

	
	<link rel="icon" type="image/x-icon" href="{{ $information['favicon'] }}"/>

    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.css') }}" media="all" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}" media="all" type="text/css" />
	<link rel="stylesheet" href="{{ asset('site/css/stylecustom.css') }}" media="all" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/font-awesome.css') }}" media="all" type="text/css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}">

    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,800&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
    <script src="{{ asset('site/js/jquery.min.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('site/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap-transition.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('site/js/wow.min.js') }}"></script>
    <script src="{{ asset('site/js/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('site/js/smooth-scroll.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminstration/moment/min/moment.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('adminstration/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('site/js/jquery.tosrus.min.all.js') }}"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111763488-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-111763488-1');
	</script>

    <script>
        $(document).ready(function(){
            $('#datepicker').datetimepicker({
                format:'DD-MM-YYYY HH:mm:ss',
            });
            //stick menu
            var s = $(".navbar");
            var pos = s.position();
            $(window).scroll(function() {
                var windowpos = $(window).scrollTop();

                if (windowpos >= pos.top) {
                    s.addClass("sticker");
                } else {
                    s.removeClass("sticker");
                }
            });
            //top
            // Hide the toTop button when the page loads.
            $("#toTop").css("display", "none");

            // This function runs every time the user scrolls the page.
            $(window).scroll(function(){

                // Check weather the user has scrolled down (if "scrollTop()"" is more than 0)
                if($(window).scrollTop() > 0){

                    // If it's more than or equal to 0, show the toTop button.
                    console.log("is more");
                    $("#toTop").fadeIn("slow");

                }
                else {
                    // If it's less than 0 (at the top), hide the toTop button.
                    console.log("is less");
                    $("#toTop").fadeOut("slow");
                }
            });


            // When the user clicks the toTop button, we want the page to scroll to the top.
            $("#toTop").click(function(){

                // Disable the default behaviour when a user clicks an empty anchor link.
                // (The page jumps to the top instead of // animating)
                event.preventDefault();

                // Animate the scrolling motion.
                $("html, body").animate({
                    scrollTop:0
                },"slow");
            });



            $('.Navbutton').click(function(){
                $('body').addClass('Nobody');
            });
            $('#hiddenNav').click(function(){
                $('#navMobile').removeClass('in');
                $('body').removeClass('Nobody');
            });
            $('.navMenu .searchMain').click(function(){
                $('.searchMenu').slideDown();
            });
            wow = new WOW(
                {
                    animateClass: 'animated',
                    offset:       100,
                    callback:     function(box) {
                        console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                    }
                }
            );
            wow.init();
        });
    </script>
</head>
<body>
<style>
    .changeColor {
        background: {!! $colorLogo !!} !important;
    }
    .Color {
        color: {!! $colorLogo !!} !important;
    }
    .changeColor .navbar-nav > .active > a, .changeColor .navbar-nav > li:hover > a {
        background: rgba(0, 0, 0, 0.25);
    }
    .mainMenu .listMenu li.active a,.mainMenu .listMenu li:hover a {
        color: {!! $colorLogo !!};
        text-decoration: none;
    }
    .Navigation .navbar-nav > .active > a, .Navigation .navbar-nav > li:hover > a {
        background: {!! $colorLogo !!} !important;
    }
	footer .list li::before {
		color: {!! $colorLogo !!} !important;
	}
</style>
    @include('site.common.header')

    <!-- Phần nội dung -->
    @yield('content')
    
    @include('site.common.footer')
    <script>
        function subcribeEmailSubmit(e) {
            var email = $(e).find('.emailSubmit').val();
            var token =  $(e).find('input[name=_token]').val();

            $.ajax({
                type: "POST",
                url: '{!! route('subcribe_email', ['languageCurrent' => $languageCurrent]) !!}',
                data: {
                    email: email,
                    _token: token
                },
                success: function(data){
                    var obj = jQuery.parseJSON(data);

                    alert(obj.message);
                }
            });
            return false;
        }
        
        function showLogin(e) {
            $('#myModalLogin .notify ').empty();
            $('#myModalLogin').modal('show');
        }
    </script>
	<a href="tel:{{ $information['so-dien-thoai-cong-ty'] }}" class="fancybox"> 
		<div class="coccoc-alo-phone coccoc-alo-green coccoc-alo-show" id="coccoc-alo-phoneIcon" style="left:-50px; bottom: 0"> 
			<div class="coccoc-alo-ph-circle"></div> 
			<div class="coccoc-alo-ph-circle-fill"></div> <div class="coccoc-alo-ph-img-circle"></div> 
		</div>
	</a>
</body>
</html>




