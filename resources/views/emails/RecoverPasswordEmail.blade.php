<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titulo correito</title>
</head>

<body>

    <h1>{{ $details["title"] }}</h1>

    <p>{{ $details["body"] }}</p>

    <a href="{{ $details['url'] }}" blank>{{ $details['url'] }}</a>

</body>

</html>