<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <link rel="shortcut icon" href="/img/favicon.png">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/theme.css" rel="stylesheet">
    <link href="/css/bootstrap-reset.css" rel="stylesheet">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet">-->

    <!--external css-->
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/flexslider.css"/>
    <link href="/assets/bxslider/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/assets/owlcarousel/owl.carousel.css">
    <link rel="stylesheet" href="/assets/owlcarousel/owl.theme.css">

    <link href="/css/superfish.css" rel="stylesheet" media="screen">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> -->

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="/css/component.css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="/css/parallax-slider/parallax-slider.css" />
    <script type="text/javascript" src="/js/parallax-slider/modernizr.custom.28468.js"></script>

    <!-- Custom -->
    <link rel="stylesheet" href="/css/nouislider.min.css"/>
    <link rel="stylesheet" href="/css/nouislider.pips.css"/>
    <link rel="stylesheet" href="/css/nouislider.tooltips.css"/>
    <link rel="stylesheet" href="/css/awesome-bootstrap-checkbox.css"/>
    <link href="/css/custom.css" rel="stylesheet">




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js">
    </script>
    <script src="/js/respond.min.js">
    </script>
    <![endif]-->

    @yield('header')
</head>
<body>

@include('header')

@yield('body')

@include('footer')


<!-- js placed at the end of the document so the pages load faster-->
<script src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/hover-dropdown.js"></script>
<script defer src="/js/jquery.flexslider.js"></script>
<script type="text/javascript" src="/assets/bxslider/jquery.bxslider.js"></script>
<script type="text/javascript" src="/js/jquery.parallax-1.1.3.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/assets/owlcarousel/owl.carousel.js"></script>
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/link-hover.js"></script>
<script src="/js/superfish.js"></script>
<script src="/js/nouislider.min.js"></script>
<script src="/js/wNumb.js"></script>
<script src="/js/sorttable.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>

<script src="/thingiview/javascripts/Three.js"></script>
<script src="/thingiview/javascripts/plane.js"></script>
<script src="/thingiview/javascripts/thingiview.js"></script>

<script type="text/javascript" src="/js/parallax-slider/jquery.cslider.js"></script>
<script type="text/javascript">
    $(function() {

        $('#da-slider').cslider({
            autoplay    : true,
            bgincrement : 100
        });

    });
</script>


<!--common script for all pages-->
<script src="/js/common-scripts.js"></script>
@include('auth.login')
@yield('script')

</body>
</html>
