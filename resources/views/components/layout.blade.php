<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- @yield('linkCss') --}}

    <link rel="stylesheet" href="/modal/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet" href="/menuVertical/css/style.css">
    <link rel="stylesheet" href="/menuHorizontal/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite('resources/css/app.css')
</head>

<body id="body-pd" class="body-pd">

    @yield('content')
    
    
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="/menuVertical/js/script.js"></script>
    <script src="/menuHorizontal/js/script.js"></script>

    <x-modal-form :annees="$annees" :semestres="$semestres" :niveaux="$niveaux" :specialites="$specialites" :matieres="$uniteValeurs" />

<script src="/modal/modal.js"></script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="/swiper.dash/swiper.js"></script>
</body>

</html>
