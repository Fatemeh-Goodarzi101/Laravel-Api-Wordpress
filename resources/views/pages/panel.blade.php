<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mouldifi - A fully responsive, HTML5 based admin theme">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
    <title>پنل مدیریتی</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!-- Site favicon -->
    <link rel='shortcut icon' type='image/x-icon' href='./public/images/favicon.ico' />
    <!-- /site favicon -->
    <!-- Entypo font stylesheet -->
    <link href="/staticFiles/css/entypo.css" rel="stylesheet">
    <!-- /entypo font stylesheet -->
    <!-- Font awesome stylesheet -->
    <link href="/staticFiles/css/font-awesome.min.css" rel="stylesheet">
    <!-- /font awesome stylesheet -->
    <!-- CSS3 Animate It Plugin Stylesheet -->
    <link href="/staticFiles/css/plugins/css3-animate-it-plugin/animations.css" rel="stylesheet">
    <!-- /css3 animate it plugin stylesheet -->
    <!-- Bootstrap stylesheet min version -->
    <link href="/staticFiles/css/bootstrap.min.css" rel="stylesheet">
    <!-- /bootstrap stylesheet min version -->
    <!-- Mouldifi core stylesheet -->
    <link href="/staticFiles/css/mouldifi-core.css" rel="stylesheet">
    <!-- /mouldifi core stylesheet -->

    <link href="/staticFiles/css/mouldifi-forms.css" rel="stylesheet">

    <!-- Bootstrap RTL stylesheet min version -->
    <link href="/staticFiles/css/bootstrap-rtl.min.css" rel="stylesheet">
    <!-- /bootstrap rtl stylesheet min version -->
    <!-- Mouldifi RTL core stylesheet -->
    <link href="/staticFiles/css/mouldifi-rtl-core.css" rel="stylesheet">
    <!-- /mouldifi rtl core stylesheet -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/staticFiles/js/html5shiv.min.js"></script>
    <script src="/staticFiles/js/respond.min.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="/staticFiles/js/plugins/flot/excanvas.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Page container -->
<div class="page-container">

    <!-- Page Sidebar -->
    <div class="page-sidebar">

        <!-- Site header  -->
        <header class="site-header">
            <div class="site-logo">پنل مدیریتی</div>
            <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
            <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
        </header>
        <!-- /site header -->
        <!-- Main navigation -->
        <ul id="side-nav" class="main-menu navbar-collapse collapse">
            <li class="has-sub {{ (request()->is('api/index')) ? 'active' : '' }}">
                <a href="{{ route('index') }}"><i class="icon-gauge"></i><span class="title">راهنما</span></a>
            </li>
            <li class="has-sub">
                <a href="#"><i class="icon-layout"></i><span class="title">گزارش گیری</span></a>
                <ul class="main-menu navbar-collapse">
                    <li class="{{ (request()->is('api/reportForm')) ? 'active' : '' }}"><a href="{{ route('reportForm') }}"><span class="title">گزارش سفارشات</span></a></li>
                    <li class="{{ (request()->is('api/reportProduct')) ? 'active' : '' }}"><a href="{{ route('productReportForm') }}"><span class="title">گزارش موجودی محصولات</span></a></li>
                </ul>
            </li>
            <li class="has-sub">
                <a href="#"><i class="icon-newspaper"></i><span class="title">آپلود اطلاعات</span></a>
                <ul class="main-menu navbar-collapse">
                    <li class="{{ (request()->is('api/importRegPrice')) ? 'active' : '' }}"><a href="{{ route('importRegPrice') }}"><span class="title">قیمت عادی محصولات</span></a></li>
                    <li class="{{ (request()->is('api/importSalePrice')) ? 'active' : '' }}"><a href="{{ route('importSalePrice') }}"><span class="title">قیمت فروش ویژه محصولات</span></a></li>
                    <li class="{{ (request()->is('api/importPrice')) ? 'active' : '' }}"><a href="{{ route('importPrice') }}"><span class="title">قیمت عادی و فروش ویژه محصولات</span></a></li>
                    <li class="{{ (request()->is('api/importQuantity')) ? 'active' : '' }}"><a href="{{ route('importQuantity') }}"><span class="title">موجودی محصولات</span></a></li>
                    <li class="{{ (request()->is('api/importName')) ? 'active' : '' }}"><a href="{{ route('importName') }}"><span class="title">نام محصولات</span></a></li>
                </ul>
            </li>
        </ul>
        <!-- /main navigation -->
    </div>
    <!-- /page sidebar -->

    <!-- Main container -->
    <div class="main-container gray-bg">
        @yield('content')
    </div>
    <!-- /main container -->

</div>
<!-- /page container -->

<!--Load JQuery-->
<script src="/staticFiles/js/jquery.min.js"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="/staticFiles/js/plugins/css3-animate-it-plugin/css3-animate-it.js"></script>
<script src="/staticFiles/js/bootstrap.min.js"></script>
<script src="/staticFiles/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="/staticFiles/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="/staticFiles/js/plugins/blockui-master/jquery.blockUI.js"></script>

<!--Float Charts-->
<script src="/staticFiles/js/plugins/flot/jquery.flot.min.js"></script>
<script src="/staticFiles/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/staticFiles/js/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/staticFiles/js/plugins/flot/jquery.flot.selection.min.js"></script>
<script src="/staticFiles/js/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="/staticFiles/js/plugins/flot/jquery.flot.time.min.js"></script>
<script src="/staticFiles/js/functions.js"></script>

<!-- Option: Bootstrap Script-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>
