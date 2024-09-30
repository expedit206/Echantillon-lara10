<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>

    <p>{{ $data['message'] }} : "<strong>{{ $data['code'] ?? $data['password'] }}</strong>"</p>
    
    <p>
        Vous pouvez également cliquer sur le lien ci-dessous pour vous connecter directement :
    </p>

    <p>
        <a href="{{ route('login', ['email' => $data['email'], 'password' => $data['password']]) }}">
            Cliquer ici pour vous connecter
        </a>
    </p>

    <p>NB : Vous utiliserez ce code pour vos futures connexions.</p>
</body>
</html>
