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
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            width: 500px;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        @include("partials.register")
    </div>
</div>
</body>
</html>
