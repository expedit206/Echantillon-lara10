<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>
        {{ $data['title'] }}
    </h1>
    <p>
    </p>
    {{ $data['message'] }} {{ $data['code'] }}
    ou cliquer simplement sur le lien ci dessous

    <p>NB: Vous urliserez ce code pour vos connexions futurs</p>
    <a href="{{ route('etudiant.login', [
    'email'=>$data['email'],
    'code'=>$data['code'],
    ]) }}">Copier le code</a>
</body>
</html>