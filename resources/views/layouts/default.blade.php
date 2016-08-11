<!DOCTYPE html>
<html>
<head>
    <title>Clean Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="{{ asset('css/clean-blog.css') }}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

@include('themes.clean-blog.includes.navbar')

<!-- Page Header -->
@yield("header")

<!-- Main Content -->
<div class="container">
    <div class="row">
        @yield("content")
        @section('sidebar')

        @show
    </div>
</div>

@include('themes.clean-blog.includes.footer')
@include('themes.clean-blog.includes.scripts')


</body>

</html>
