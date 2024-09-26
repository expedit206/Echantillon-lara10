<x-layout>

    @section('title', 'Unités de Valeur')

    @section('content')
        <x-header />
        <x-menu />
        {{-- @dd($uniteValeurs) --}}

        <div class="filter">
            <div class="flex justify-between ">
                <a href="{{ route('uniteValeur.create') }}" class="btn text-violet-800 font-bold flex w-1/3">Ajouter une unité
                    de valeur
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px"
                        height="24px">
                        <path
                            d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z" />
                    </svg>
                </a>
                <div class="font-bold"> 
                    <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
                        @csrf
                        <label for="annee">Année Académique</label>
                        <select name="annee" id="annee"
                            class="border-none outline-none focus:border-none cursor-pointer" onchange="submit()">
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->id }}"
                                    class="cursor-pointer border-b-4 border-double border-black"
                                    {{ $annee->is_active == true ? 'selected' : '' }}>{{ $annee->nom }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <form method="get" action="{{ route('uniteValeur.index') }}" id="form"
                class="px-3 text-white grid-cols-5 content flex gap-3 items-center justify-around bg-orange-400 py-2">
                @csrf


                <h3>Filtrer par:</h3>

                <article class="flex flex-col w-full">
                    <label for="niveau">Niveau</label>
                    <select type="text" id="niveau" name="niveau" class="text-black rounded-md w-full"
                        onchange="submit()">
                        <option value=""></option>
                        @foreach ($niveaux as $niveau)
                            <option value="{{ $niveau->nom }}" {{ request('niveau') === $niveau->nom ? 'selected' : '' }}>
                                {{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </article>

             

                <article class="flex flex-col w-full">
                    <label for="filiere">spécialité</label>
                    <select type="text" id="specialite" name="specialite" class="text-black rounded-md w-full"
                        onchange="submit()">
                        <option value=""></option>
                        @foreach ($specialites as $specialite)
                            <option value="{{ $specialite->nom }}"
                                {{ request('specialite') === $specialite->nom ? 'selected' : '' }}>
                                {{ $specialite->nom }}</option>
                        @endforeach
                    </select>
                </article>
                <article class="flex flex-col w-full">
                    <label for="semestre">semestres</label>
                    <select type="text" id="semestre" name="semestre" class="text-black rounded-md w-full"
                        onchange="submit()">
                        <option value=""></option>
                        @foreach ($semestres as $semestre)
                            <option value="{{ $semestre->nom }}"
                                {{ request('semestre') === $semestre->nom ? 'selected' : '' }}>{{ $semestre->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>

                <article class="flex flex-col w-full">
                    <label for="unitevaleur">Unité de Valeur</label>
                    <select type="text" id="unitevaleur" name="unitevaleur" class="text-black rounded-md w-full"
                        onchange="submit()">
                        <option value=""></option>
                        @foreach ($uniteValeurs as $unitevaleur)
                            <option value="{{ $unitevaleur->nom }}"
                                {{ request('unitevaleur') === $unitevaleur->nom ? 'selected' : '' }}>
                                {{ $unitevaleur->nom }}</option>
                        @endforeach
                    </select>
                </article>
            </form>
        </div>

        <div class="table mt-3">
            {{-- <p class="font-bold text-1xl italic">Total : {{ $total }}</p> --}}
            {{-- <table class="table-custom overflow-scroll">
                <thead class="table-head-custom">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Code</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Niveau</th>
                        <th scope="col">spécialité</th>
                        <th scope="col">Spécialité</th>
                        <th scope="col">Enseignant</th>
                        <th scope="col" class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uniteValeurs as $unitevaleur)
                        <tr>
                            <td scope="row">{{ $unitevaleur->id }}</td>
                            <td scope="row">{{ $unitevaleur->code }}</td>
                            <td scope="row">{{ $unitevaleur->nom }}</td>
                            <td scope="row">{{ $unitevaleur->niveau->nom }}</td>
                            <td scope="row">{{ $unitevaleur->filiere->nom }}</td>
                            <td scope="row">{{ $unitevaleur->specialite->nom }}</td>
                            <td scope="row">{{ $unitevaleur->enseignant?->nom }}</td>
                            <td scope="row"> <a href="{{ route('uniteValeur.show', $unitevaleur->id) }}"
                                    class="text-blue-600 hover:text-blue-900">Voir</a> </td>
                            <td scope="row"> <a href="{{ route('uniteValeur.edit', $unitevaleur->id) }}"
                                    class="text-green-600 hover:text-green-900">Editer</a> </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                @if (request('search') || request('niveau') || request('filiere'))
                                    Aucune unité de valeur ne correspond à ces critères.
                                @else
                                    Aucune unité de valeur enregistrée.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $uniteValeurs->appends(request()->input())->links() }} --}}
        </div>
    @endsection
</x-layout>
