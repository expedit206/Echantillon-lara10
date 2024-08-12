<!DOCTYPE html>
<html lang="en" data-bs-theme='light'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/css/accueil.css')
</head>
<body class="max-h-[100vh] light-mode " data-bs-theme="light" >
<main class="" style="
  display: grid;
  grid-template-rows: 12% 89%;
  height: 100vh;
  
  width: 100vw;
  background: url('build/assets/img/bghero.jpeg') no-repeat  center/cover;
  /* background-color: rgb(41, 38, 38); */
  ">

  <nav class=" bg-slate-200 grid min-w-full  border-b border-gray-200   dark:border-gray-600 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-center justify-between gap-2 ">
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="build/assets/img/logo.jpeg" class="h-14" alt="Flowbite Logo">
          <span class="self-center text-2xl font-semibold whitespace-nowrap ">StudAdmin</span>
      </a>

    <div class="h-full  hidden md:flex  items-center justify-between w-full md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col items-center justify-center p-2  md:p-0 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Acceuil</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
          </li>
        </ul>
      </div>

    <div class=" flex md:order-2 gap-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

        <a  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center  dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <details>

            <summary>
                Inscription
            </summary>
            <div class="btn-inscription">
                <form method="get"
                action="{{ route('enseignant.register') }}"
                >
                    <button class="btn btn-info" >Enseignant</button>
                </form>
                <form method="get"
                 action="{{ 'register.etudiant' }}"
                 >
                    <button class="btn btn-info min-w-full">Etudiant</button>
                </form>
            </div>
        </details>

    </a>

        <button data-bs-toggle="collapse" data-bs-target="#navbar-sticky" id='buttonMenux' type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
    </div>

    <div class="collapse flex  items-center justify-between  w-full md:hidden md:w-auto md:order-1"               id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Dashboard</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
        </li>
      </ul>
    </div>
    </div>
  </nav>



  {{-- hero section --}}

  <section id="hero" class="flex-col lg:flex-row gap-3 flex items-center h-full"
   {{-- style="background-image: url('build/assets/img/bdhero.jpeg');" --}}
   >

    <div class="first justify-center flex flex-col lg:gap-4 gap-3 text-white w-full lg:w-1/2 mt-2 pl-5 pr-3 h-1/2 lg:h-full lg:pl-10 ">
        <h1 class="font-bold"
        style="
         font-size: clamp(10px, 9vw , 90px);
         "
        >!!StudAdmin!!</h1>

        <p class="flex font-semibold font-serif flex-wrap"
        style="
        font-size: clamp(10px, 3vw , 100px);
        ">Bienvenu sur l'appplication qui revolutionne la gestion de vos relevés de notes </p>
        <h3 class="italic font-semibold text-xl">Se connecter en tant que</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.login') }}" class="btn btn-primary">Administrateur</a>
            <a href="{{ route('enseignant.login') }}" class="btn btn-info">Enseignant</a>
            <a href="{{ route('etudiant.login') }}" class="btn btn-danger">Etudiant</a>
        </div>
    </div>

    <div class="second   w-full flex justify-center h-1/2  lg:h-full lg:w-1/2 items-center">
        <img src="build/assets/img/bdhero.jpeg" alt="" class="lg:w-[90%] lg:h-[80%]  w-[90%] h-[90%] rounded-[1rem] lg:rounded-s-[2rem] lg:rounded-e-[8rem]">
    </div>
  </section>

</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</body>
</html>
