<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ url('css/bootstrap-rtl.css') }}" rel="stylesheet">
    <link href="{{ url('css/font-awesome.css') }}" rel="stylesheet">
    {{--for footer--}}
    <meta name="keywords" content="footer, basic, centered, links" />
    <link rel="stylesheet" href="{{ url('css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('css/footer-basic-centered.css') }}">
    {{--finished for footer--}}
    @yield('style')
    <link href="{{ url('css/site.css') }}" rel="stylesheet">
    <title>فروشگاه دکان مارکت</title>

</head>
<body>

<div class="container-fluid header">

    <div class="container">

        <div class="row">

            <div class="col-lg-9 col-md-9 col-sm-9">
                <ul class="list-inline header_ul">
                    <li><span class="fa fa-lock" style="padding-left:5px"></span><a href="/">فروشگاه اینترنتی دکان مارکت</a> @if(!Auth::check()) <a href="{{ url('login') }}">وارد شوید</a> @endif</li>
                    @if(Auth::check())
                        <li><span class="fa fa-user"></span><a href="{{ url('user') }}">
                                {{ Auth::user()->username }}
                            </a></li>
                        <li><span class="fa fa-lock"></span><a href="{{ route('logout') }}"
                                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">خروج</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @else
                        <li><span class="fa fa-user"></span><a href="{{ url('register') }}">ثبت نام</a></li>
                    @endif
                    <li><span class="fa fa-gift"></span><a href="">کارت هدیه</a></li>

                </ul>

                <ul class="list-inline">

                    <li>
                        <a href="{{ url('Cart') }}">
                            <div class="btn-shopping-cart">
                                <div class="shopping-cart-icon"><span class="fa fa-shopping-cart"></span></div>
                                <div class="shopping-cart-text">
                                    <span style="float:right">سبد خرید</span>
                                    <span class="number-product-cart">{{ \App\Cart::count() }}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>


                        <div class="form-group" id="header_header">

                            <div class="input-group index_search_input">
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                <input type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" placeholder="... محصول، دسته یا برند مورد نظرتان را جستجو کنید">
                            </div>
                        </div>

                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="{{ url('images/logo.jpg') }}" class="logo">
            </div>

        </div>

    </div>
</div>

<div class="container" style="padding-bottom:40px">
    @yield('content')
</div>


<script type="text/javascript" src="{{ url('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('js/js.js') }}"></script>
<script type="text/javascript" src="{{ url('js/bootstrap.js') }}"></script>

<footer class="footer-basic-centered">

    <p class="footer-company-motto" style="font-family:Serif;font-weight: bold;">فروشگاه اینترنتی دکان مارکت</p>


    <p class="footer-links" style="font-size: 27px;">
        <a href="/">خانه</a>
        ·
        <a href="/about">درباره ما</a>
        ·
        <a href="/faq">سوالات متداول</a>
        ·
        <a href="/callus">تماس با ما</a>
    </p>

    <p class="footer-company-name">تمامی حقوق این وبسایت متعلق به وبساید دکان مارکت میباشد.ستفاده از مطالب فروشگاه اینترنتی دکان مارکت فقط برای مقاصد غیر تجاری و با ذکر منبع بلامانع است.</p>

</footer>

</body>
</html>