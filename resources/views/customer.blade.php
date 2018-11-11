<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/fonts/themify/themify-icons.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/fonts/elegant-font/html-css/style.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/animate/animate.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/css-hamburgers/hamburgers.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/animsition/css/animsition.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/select2/select2.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/slick/slick.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/lightbox2/css/lightbox.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/css/util.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/customer/css/main.css")}}">
    <style type="text/css">
        .slide-leave-active,
        .slide-enter-active {
          transition: 0.5s;
        }
        .slide-enter {
          transform: translate(100%, 0);
        }
        .slide-leave-to {
          transform: translate(-100%, 0);
          display: none;
        }
        #loader {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000;
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
            animation: sk-scaleout 1.0s infinite ease-in-out;
        }

        @-webkit-keyframes sk-scaleout {
            0% { -webkit-transform: scale(0) }
            100% {
                -webkit-transform: scale(1.0);
                opacity: 0;
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            } 100% {
                  -webkit-transform: scale(1.0);
                  transform: scale(1.0);
                  opacity: 0;
              }
        }
    </style>
</head>
<body class="app">
    <div id="app">
        {{--Loading effect--}}
        <div id='loader'>
            <div class="spinner"></div>
        </div>

        <transition name="slide">
            <router-view></router-view>
        </transition>
    </div>
</body>
<script type="text/javascript">
    window.addEventListener('load', () => {
        const loader = document.getElementById('loader');
        setTimeout(() => {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/customer/main.js')}}"></script>
</html>