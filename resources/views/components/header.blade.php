

<header class="header border-b-2  border-black relative px-0 body-pd" id="header">
    <div class="header_toggle"> <i class='bx bx-menu bx-x' id="header-toggle"></i> STUDAMIN</div>

    @if (Route::currentRouteName() == 'students' || Route::currentRouteName() == 'teachers')
    <form method='get' action="{{ route(Route::currentRouteName()) }}"
    class="flex items-center justify-center gap-2 border-black border-2 rounded-[1rem]"
    onsubmit="
    document.querySelector('#specialiteHead').value=document.querySelector('#specialite').value
    document.querySelector('#filiereHead').value=document.querySelector('#filiere').value
    document.querySelector('#anneeHead').value=document.querySelector('#annee').value
    document.querySelector('#niveauHead').value=document.querySelector('#niveau').value
    document.querySelector('#uniteValeurHead').value=document.querySelector('#uniteValeur').value
    ">

    <input name="search" id="searchHead" value="{{request('search')}}" class="focus:outline-none focus:border-transparent border-none   bg-transparent" placeholder="Rechercher"  oninput=" this.value=this.value

        " >

                <input type="text" name="filiere" id="filiereHead" hidden>
                <input type="text" name="specialite" id="specialiteHead" hidden>
                <input type="text" name="uniteValeur" id="uniteValeurHead" hidden>
                <input type="text" name="niveau" id="niveauHead" hidden>
                <input type="text" name="annee" id="anneeHead" hidden>

    <button class="" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path
                d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z">
            </path>
            <path
                d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z">
            </path>
        </svg>
    </button>

    </form>
    @endif

    <div class="relative  border-3 rounded-lg px-2 lg:py-1 bg-blue-300">
        <!-- Bouton du profil -->
        <div class="flex items-center justify-center gap-2 cursor-pointer" id="profileButton">
            <span>Mon profil</span>
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="text" viewBox="0 0 24 24"
                    style="fill: rgba(0, 0, 0, 1);">
                    <path
                        d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Menu déroulant -->
   
    </div>

    {{-- rofile menu --}}
    @php
    $id = null; // Initialiser $id à null

    if (Auth::guard('admin')->check()) {
        $id = Auth::guard('admin')->id(); // Récupère l'ID de l'admin
    } elseif (Auth::guard('enseignant')->check()) {
        $id = Auth::guard('enseignant')->id(); // Récupère l'ID de l'enseignant
    } elseif (Auth::guard('etudiant')->check()) {
        $id = Auth::guard('etudiant')->id(); // Récupère l'ID de l'étudiant
    }
@endphp

    <div id="profileMenu"  class="w-[100%]  absolute right-0 top-[-800%] lg:top-[-600%]  mt-0  bg-white rounded-lg shadow-lg  transition-all duration-250 ease-in-out ">
    <ul class="py-2 font-bold font-serif bg-slate-300 rounded-md">
        <li>
       
            @if (Auth::guard('enseignant')->check())
            <a href="{{ route('teacher.show', $id) }}" class="block px-4 py-2 text-green-800 hover:bg-gray-200 text-center">Informations personnelles</a>
        @elseif (Auth::guard('admin')->check())
            <a href="{{ route('admin.show', $id) }}" class="block px-4 py-2 text-green-800 hover:bg-gray-200 text-center">Informations personnelles</a>
        @elseif (Auth::guard('etudiant')->check())
            <a href="{{ route('student.show', $id) }}" class="block px-4 py-2 text-green-800 hover:bg-gray-200 text-center">Informations personnelles</a>
        @endif
     </li>
  <hr>
        <li>
            <a href="{{route('password.edit')}}" class="block px-4 py-2 text-green-800 hover:bg-gray-200 text-center">Modifier mon mot de passe</a>
        </li>
    </ul>
    </div>
    <!-- Script pour afficher/masquer le menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const profileButton = document.getElementById('profileButton');
        const menu = document.getElementById('profileMenu');

        profileButton.addEventListener('click', function () {
            // Alterner la visibilité du menu
            menu.style.top = menu.style.top === '100%' ? '-800%' : '100%';
        });

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function (event) {
            // Vérifiez si le clic a eu lieu à l'extérieur du bouton et du menu
            if (!profileButton.contains(event.target)) {
                menu.style.top = '-800%'; // Fermer le menu
            }
        });
    });
    </script>

</header>

<div>
    @if (@session('status'))
        {{session('status')}}
    @endif
</div>
