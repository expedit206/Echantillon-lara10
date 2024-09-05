<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription Enseignant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-300 text-gray-900">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="max-w-3xl mx-auto p-6 bg-slate-500 rounded-lg shadow-md mt-10">

        <div class="flex font-bold justify-between">
            <h1 class="text-2xl font-bold mb-6">Inscription Enseignant</h1>
                <form method='post' action="{{route('annee.setActive')}}" id="formAnnee">
                    @csrf
                            <label for="annee">Année Académique</label>
                            <select name="annee" id="annee" class="bg-slate-400 rounded-full  border-none outline-none focus:border-none cursor-pointer" onchange="submit()"
                            >
                                @foreach($annees as $annee)
                                <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black"
                                    {{ $annee->is_active==true? 'selected':''}}
                                    >{{ $annee->nom }}</option>
                                @endforeach
                            </select>
                        </form>
        </div>

        <form method="POST" action="{{ route('enseignants.store') }}" enctype="multipart/form-data" class="">
            @csrf

            <div class="mb-4">
                <x-label for="nom" value="{{ __('Nom') }}" />
                <x-input id="nom" name='nom' class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text"  :value="old('nom')"  autofocus autocomplete="nom" />


            </div>

            <div class="mb-4">
                <x-label for="prenom" value="{{ __('Prénom') }}" />
                <x-input id="prenom" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" name="prenom" :value="old('prenom')"  autocomplete="prenom" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="email" name="email" :value="old('email')"  autocomplete="username" />
            </div>
            <div class="mb-4">
                <x-label for="sexe" value="{{ __('Sexe') }}" />
                <select id="sexe" name="sexe" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                    <option value="Masculin">Masculin</option>
                    <option value="Femme">Féminin</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="mb-4">
                <x-label for="dateNaiss" value="{{ __('Date de naissance') }}" />
                <x-input id="dateNaiss" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="date" name="dateNaiss" :value="old('dateNaiss')"  autocomplete="bday" />
            </div>

            <div class="mb-4">
                <x-label for="lieuNaiss" value="{{ __('Lieu de naissance') }}" />
                <x-input id="lieuNaiss" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" name="lieuNaiss" :value="old('lieuNaiss')"  />
            </div>

            <div class="mb-4">
                <x-label for="nationalite" value="{{ __('Nationalité') }}" />
                <x-input id="nationalite" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" name="nationalite" :value="old('nationalite')"  />
            </div>

            <div class="mb-4">
                <x-label for="mobile" value="{{ __('Mobile') }}" />
                <x-input id="mobile" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="tel" name="mobile" :value="old('mobile')"  />
            </div>

            <div class="mb-4">
                <x-label for="photo" value="{{ __('Photo') }}" />
                <input id="photo" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="file" name="photo" accept="image/*" />
            </div>

            <div class="mb-4">
                <x-label for="profession" value="{{ __('Profession') }}" />
                <x-input id="profession" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" name="profession" :value="old('profession')"  />
            </div>

            <div class="mb-4">
                <x-label for="diplome" value="{{ __('Diplôme') }}" />
                <x-input id="diplome" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" name="diplome" :value="old('diplome')"  />
            </div>

            <div class="mb-4">
                <x-label for="salaire" value="{{ __('Salaire') }}" />
                <x-input id="salaire" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="number" name="salaire" step="0.01" :value="old('salaire')"  />
            </div>

            <div class="mb-4">
                <x-label for="typeContrat" value="{{ __('Type de contrat') }}" />
                <select id="typeContrat" name="typeContrat" class="block mt-1 w-full border border-gray-300 rounded-md p-2" >
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Intérim">Intérim</option>
                    <option value="Stage">Stage</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div class="mb-4">
                <x-label for="debutContrat" value="{{ __('Début du contrat') }}" />
                <x-input id="debutContrat" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="date" name="debutContrat" :value="old('debutContrat')"  />
            </div>

            <div class="mb-4">
                <x-label for="finContrat" value="{{ __('Fin du contrat (optionnel)') }}" />
                <x-input id="finContrat" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="date" name="finContrat" :value="old('finContrat')" />
            </div>

                <input type="text" hidden>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="password" name="password"  autocomplete="new-password" />
            </div>

            <div class="mb-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="password" name="password_confirmation"  autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-800 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('enseignant.login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
