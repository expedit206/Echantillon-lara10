<!DOCTYPE html>
<html lang="en" data-bs-theme='light'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    @vite('resources/css/app.css')

</head>
<style>
    #main::after {
        /* content: ""; */
        width: 100%;
        height: 100%;
        position: absolute;
        background: rgba(15, 200, 195, 0.1);
        /* z-index: -1; */
    }
</style>

<body class="max-h-[100vh] light-mode overflow-hidden" data-bs-theme="light" style="
z-index: -5;
">
<div class="haut w-full bg-red-500"></div>
    <main class=""
        style="
  display: grid;
  grid-template-rows: 12% 89%;
  height: 98.7vh;
  width: 100vw;
  /* background: url('/img/bgprof2.webp') no-repeat  center/cover; */

  background: url('/img/bgprof.jpg') no-repeat  center/cover;
  "
        id='main'>

        <nav class=" grid min-w-full px-2 md:px-5  item-center  border-gray-200 lg:px-3 z-10   bg-transparent"
            style="
        /* background: RGB(214, 215, 225); */
        ">
            <div class="flex flex-wrap items-center justify-between gap-2 px-2">
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="/img/logo.webp" class="h-14" alt="logo ESCa">
                    {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap ">StudAdmin</span> --}}
                </a>

                <div class="h-full  hidden md:flex  items-center justify-between w-full md:w-auto md:order-1"
                    id="navbar-sticky">
                    <ul
                        class="flex flex-col items-center justify-center p-2  md:p-0 font-medium border border-gray-100 rounded-lg  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 bg-sky-500  dark:border-gray-700">
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                aria-current="page">Acceuil</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="flex gap-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <div class="flex-col text-black font-bold  border-0 w-full p-2 rounded-lg hidden lg:flex">
                        <div>
                            <marquee behavior="" direction="" class=' bg-opacity-30'>

                                <span>un etudiant -</span>
                                <span>- un projet</span>


                                <span>une entreprise</span>
                                <span>- un suivi</span>
                            </marquee>
                        </div>

                    </div>

                    <button data-bs-toggle="collapse" data-bs-target="#navbar-sticky" id='buttonMenu' type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>



            </div>
            {{-- <hr class="text-white" /> --}}
        </nav>



        {{-- hero section --}}

        <section id="hero" class=" flex items-center  h-full p-5 z-10 lg:mt-0"
                            style="
                /* background: url('/img/bgwelcome6.jpg') no-repeat  center/cover; */
                /* background: url('/img/bgprof.jpg') no-repeat  center/cover; */

                  /* background: url('/img/bgprof2.webp') no-repeat  center/cover; */

         ">


            <div class=" first flex item-center py-0 justify-center flex-col lg:gap-12 gap-8 text-black md:w-[60%] mt-2 lg:h-full"
                style="
                        font-family: Arial, Helvetica, sans-serif;

                ">
                <h1 class="font-bold"
                            style="text-align: start;
                font-size: clamp(60px, 10vw , 90px);

                ">!!StudAdmin!!
                        </h1>

                        <p class="flex font-semibold font-serif flex-wrap"
                            style="
                                text-align: start;
                        font-size: clamp(20px, 2vw , 100px);
                font-family: 'Pacifico', cursive;
                /* font-family: 'Montserrat', sans-serif; */


        ">
                    Bienvenue sur l'appplication qui revolutionne la gestion de vos relevés de notes </p>
                <div class="flex gap-2 text-white justify-start">
                    <a href="{{ route('login') }}" class="btn-welcome rounded-md p-3 px-4 text-3xl bg-sky-600 hover:translate-x-2 hover:py-2 font-bold animate-bounce hover:bg-sky-500 hover:text-blue-800  transition-all duration-100 border-1 border-black "
                    style="
                    font-family:  sans-serif;
                    " >Se  connecter</a>
                </div>
            </div>

            <div class="img hidden lg:flex">
                <img src="./img/cercle.png" alt="" class="animate-spin">
            </div>

        </section>

    </main>


    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}

</body>

</html>
