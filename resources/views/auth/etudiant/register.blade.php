<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

</head>
<body>


    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('etudiant.register') }}">
        @csrf
        <input type="text" name="code" class="hidden" value="0000">

        <div>
            <x-label for="nom" value="{{ __('Nom') }}" />

            <x-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom" />
        </div>

        <div>
            <x-label for="prenom" value="{{ __('Prenom') }}" />
            <x-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
        </div>
        
        <div>

            <x-label for="homme" value="{{ __('Homme') }}" />
            <input id="homme" type="radio" name="sexe" :value="old('sexe')" required >

            <x-label for="femme" value="{{ __('Femme') }}" />
            <input id="femme" type="radio" name="sexe" required :value="old('sexe')">
        </div>
        
        <div>
            <x-label for="DateNaissance" value="{{ __('Date de naissance') }}" />
            <input id="DateNaissance" type="date" name="dateNaissance" :value="old('dateNaissance')" required >
        </div>

        <div class="mt-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required  />
        </div>

        <div class="mt-4">
            <x-label for="telephone" value="{{ __('Telephone') }}" />
            <x-input id="telephone" class="block mt-1 w-full" type="number" name="telephone" :value="old('telephone')" required  />
        </div>

        <div>
            <x-label for="niveaux" value="{{ __('Niveaux') }}" />
            <input type="text" list="niveaux" name="idNiveau" required autocomplete='on' class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" value="{{ old('niveau') }}">

            <datalist id="niveaux">
                @foreach ($niveaux as $niveau )

                <option value="{{ $niveau->nom }}">{{ $niveau->id }}</option>
                @endforeach
            </datalist>
        </div>

        <div>
            <x-label for="filieres" value="{{ __('Filieres') }}" />
            <input type="text" list="filieres" name="idFiliere" required autocomplete='on' class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" value="{{ old('filiere') }}"">

            <datalist id="filieres">
                @foreach ($filieres as $filiere )

                <option value="{{ $filiere->nom }}">{{ $filiere->id }}</option>
                @endforeach
            </datalist>
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('enseignant.login') }}">
                {{ __('Already registered?') }}
            </a>


            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>
    </form>

</body>
</html>
