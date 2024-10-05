<x-layout>
    @section('title', 'Ajouter un Etudiant')

    @section('content')
        <x-header />
        <x-menu />

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-5 bg-slate-500 px-5 rounded-md py-6">
            <h1 class="text-3xl font-bold text-center mb-6">Ajouter un Etudiant</h1>

            {{-- Form for Student Registration --}}
            <form method="POST" action="{{ route('enseignants.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Informations Personnelles --}}
                <h2 class="text-lg font-semibold mb-4">Informations Personnelles</h2>

                <div class="grid md:md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="nom" value="Nom" />
                        <x-input id="nom" name="nom" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('nom')" autofocus />
                    </div>
                    <div>
                        <x-label for="prenom" value="Prénom" />
                        <x-input id="prenom" name="prenom" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('prenom')" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="email" value="Email" />
                        <x-input id="email" name="email" class="w-full border border-gray-300 rounded-md p-2" type="email" :value="old('email')" />
                    </div>
                    <div>
                        <x-label for="sexe" value="Sexe" />
                        <select id="sexe" name="sexe" class="w-full border-gray-300 rounded-md p-2">
                            <option value="Masculin">Masculin</option>
                            <option value="Féminin">Féminin</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="dateNaiss" value="Date de naissance" />
                        <x-input id="dateNaiss" name="dateNaiss" class="w-full border border-gray-300 rounded-md p-2" type="date" :value="old('dateNaiss')" />
                    </div>
                    <div>
                        <x-label for="lieuNaiss" value="Lieu de naissance" />
                        <x-input id="lieuNaiss" name="lieuNaiss" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('lieuNaiss')" />
                    </div>
                </div>

                {{-- Contact Information --}}
                <h2 class="text-lg font-semibold mb-4">Informations de Contact</h2>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="nationalite" value="Nationalité" />
                        <x-input id="nationalite" name="nationalite" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('nationalite')" />
                    </div>
                    <div>
                        <x-label for="mobile" value="Mobile" />
                        <x-input id="mobile" name="mobile" class="w-full border border-gray-300 rounded-md p-2" type="tel" :value="old('mobile')" />
                    </div>
                </div>

                <div class="mb-4">
                    <x-label for="photo" value="Photo" />
                    <input id="photo" name="photo" class="w-full border border-gray-300 rounded-md p-2" type="file" accept="image/*" />
                </div>

                {{-- Professional Information --}}
                <h2 class="text-lg font-semibold mb-4">Informations Professionnelles</h2>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="profession" value="Profession" />
                        <x-input id="profession" name="profession" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('profession')" />
                    </div>
                    <div>
                        <x-label for="diplome" value="Diplôme" />
                        <x-input id="diplome" name="diplome" class="w-full border border-gray-300 rounded-md p-2" type="text" :value="old('diplome')" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="salaire" value="Salaire" />
                        <x-input id="salaire" name="salaire" class="w-full border border-gray-300 rounded-md p-2" type="number" step="0.01" :value="old('salaire')" />
                    </div>
                    <div>
                        <x-label for="typeContrat" value="Type de contrat" />
                        <select id="typeContrat" name="typeContrat" class="w-full border border-gray-300 rounded-md p-2">
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Intérim">Intérim</option>
                            <option value="Stage">Stage</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="debutContrat" value="Début du contrat" />
                        <x-input id="debutContrat" name="debutContrat" class="w-full border border-gray-300 rounded-md p-2" type="date" :value="old('debutContrat')" />
                    </div>
                    <div>
                        <x-label for="finContrat" value="Fin du contrat (optionnel)" />
                        <x-input id="finContrat" name="finContrat" class="w-full border border-gray-300 rounded-md p-2" type="date" :value="old('finContrat')" />
                    </div>
                </div>

                {{-- Password --}}
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-label for="password" value="Password" />
                        <x-input id="password" name="password" class="w-full border border-gray-300 rounded-md p-2" type="password" />
                    </div>
                    <div>
                        <x-label for="password_confirmation" value="Confirm Password" />
                        <x-input id="password_confirmation" name="password_confirmation" class="w-full border border-gray-300 rounded-md p-2" type="password" />
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none transition duration-150 ease-in-out">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

    @endsection
</x-layout>
