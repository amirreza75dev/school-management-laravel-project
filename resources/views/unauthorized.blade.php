<?php
$url = url()->current();
$query = parse_url($url, PHP_URL_PATH);
$userRule = Auth::user() ? Auth::user()->rule : 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>warning</title>
</head>
<body>
    <p>you are {{$userRule}} and can not access to {{ url()->previous() ?? 'no query parameters' }} </p>
    
</body>
</html>
