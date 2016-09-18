<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <!-- Bootstrap Core CSS -->
    {!! Html::style('/bower/bootstrap/dist/css/bootstrap.css') !!}

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-family: 'Lato';
        }

        .container {
            width: 500px;
            height: 100%;
        }

        .content {
            margin-top: 30px;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="text-align: center;"><img style="height: 80px;" src="img/logo.png" alt="商有道"></div>
    <div class="content">
        @include("partials.register")
    </div>
</div>
</body>
</html>
