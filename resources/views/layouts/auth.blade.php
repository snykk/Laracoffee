<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} Page</title>
    @include('/partials/bootstrap_css')
    @stack('css-dependencies')
</head>

<body>
    @yield("content")

    @include('/partials/bootstrap_js')
    @stack('scripts-dependencies')
</body>

</html>