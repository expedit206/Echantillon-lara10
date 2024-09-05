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
    {{ $data['message'] }} "{{ $data['code']??$data['password'] }}" 
    ou cliquer simplement sur le lien ci dessous
    <p>NB: Vous urliserez ce code pour vos connexions futurs</p>
@if ($data['route']=='enseignant.login')


    <a href="{{ route($data['route'], [
    'email'=>$data['email'],
     'password'=>$data['password'],
    ]) }}">Copier le code</a>

    @else

    <a href="{{ route($data['route'], [
    'email'=>$data['email'],
    'code'=>$data['code'],
    ]) }}">Copier le code</a>
@endif

</body>
</html>