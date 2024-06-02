@section('styles')
    @parent
    <style>
        html {
            scrollbar-width: none; /* Firefox */
        }
        body::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Edge, Opera */
        }
        :root {
            --bg-color: #F8F8FF;
            --text-color: #303030;
        }
        * {
            margin: 0;
            padding: 0;
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
            background: var(--bg-color);
            color: var(--text-color);
            box-sizing: border-box;
        }
        a {
            text-decoration: none;
            color: var(--text-color);
        }
        .container {
            width: 1250px;
            margin: 0 auto;
        }
        h3 {
            font-weight: 600;
            font-size: 22px;
        }
    </style>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Каталог')</title>
    @yield('styles')
    @yield('scripts')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        @include('components.header')
        @yield('content')
    </div>
</body>
</html>
