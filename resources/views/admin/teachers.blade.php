<x-layout>
    @section('title', 'Teachers')

    @section('content')
    <x-header />
    <x-menu />

    <div class="filter">
        <form method="get" action="{{ route('teachers') }}" id="form" class="px-3 text-white grid-cols-4 content flex gap-5 items-center justify-around bg-orange-400 py-2">
            @csrf
            <h3>Filtrer par :</h3>

            <!-- Niveau Filter -->
            <article class="flex flex-col w-full">
                <label for="niveau">Niveau</label>
                <select id="niveau" name="niveau" class="text-black rounded-md w-full" onchange="submit()">
                    <option value=""></option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->nom }}" {{ request('niveau') === $niveau->nom ? 'selected' : '' }}>{{ $niveau->nom }}</option>
                    @endforeach
                </select>
            </article>

            <!-- Filiere Filter -->
            <article class="flex flex-col w-full">
                <label for="filiere">Filière</label>
                <select id="filiere" name="filiere" class="w-full text-black rounded-md" onchange="submit()">
                    <option value=""></option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->nom }}" {{ request('filiere') === $filiere->nom ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </article>

            <!-- Tri par Ancienneté -->
            <article class="flex flex-col w-full">
                <label for="anciennete">Unite de valeur</label>
                <select id="anciennete" name="anciennete" class="text-black rounded-md w-full" onchange="submit()">
                    <option value=""></option>
                    @foreach ($uniteValeurs as $uniteValeur)
                    <option value="{{ $uniteValeur->nom }}" {{ request('uniteValeur') === $uniteValeur->nom ? 'selected' : '' }}>{{ $uniteValeur->nom }}</option>
                @endforeach
                </select>
            </article>
        </form>
    </div>

    <div class="table mt-3">
        <table class="table table-striped" style="
                border:1px black solid !important;
                --bs-table-color: #161313;
                --bs-table-bg: white;
                --bs-table-border-color: #4d5154;
                --bs-table-striped-bg: #2c303426;
                --bs-table-striped-color: #0f0e0e;
            ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Sexe</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Type de contrat</th>
                    <th scope="col">Diplome</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Filière</th>
                    <th scope="col" class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->nom }}</td>
                        <td>{{ $teacher->prenom }}</td>
                        <td>{{ $teacher->sexe }}</td>
                        {{-- <td>{{ $teacher->niveau->nom }}</td> --}}
                        {{-- <td>{{ $teacher->filiere->nom }}</td> --}}
                
                        
                        <td>{{ $teacher->mobile }}</td>
                        <td>{{ $teacher->typeContrat }}</td>
                        <td>{{ $teacher->diplome }}</td>
                        <td class="text-center">
                            <a href="{{ route('teacher.show', $teacher) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                        </td>
                        <td class="text-center">
                            <a href="
                            {{-- {{ route('teacher.edit', $teacher->id) }} --}}
                             " class="text-green-600 hover:text-green-900">Éditer</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            @if (request('search') || request('niveau') || request('filiere'))
                                Aucun enseignant ne correspond à ces critères.
                            @else
                                Aucun enseignant enregistré.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $teachers->appends(request()->input())->links() }}
    </div>
    @endsection
</x-layout>
