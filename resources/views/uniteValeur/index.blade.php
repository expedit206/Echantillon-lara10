{{-- @dump($niveaux) --}}
<x-layout>

    @section('title', 'Unités de Valeur')

    @section('content')
        <x-header />
        <x-menu />
        {{-- @dd($uniteValeurs) --}}

<div class="flex justify-between items-center">

    <h1 class="p-2 mt-2 font-bold text-2xl bg-slate-400 rounded-lg ">Liste de
        @if(@auth()->guard('admin')->check())
            tous les
        @elseif(@auth()->guard('enseignant')->check())
            mes
        @endif
         unités de valeurs
    </h1>

    <div>
                <label for="annee">Année Académique</label>
                <select name="annee" id="anneeModal" class="border-none outline-none focus:border-none cursor-pointer bg-slate-400 rounded-md"  >
                    @foreach ($annees as $annee)
                        <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black"
                            {{ $annee->is_active == true ? 'selected' : '' }}>
                            {{ $annee->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="table mt-3">
            <p class="font-bold text-1xl italic">Total : {{ $totalUnite }}</p>
            <table class="table-custom overflow-scroll">
                <thead class="table-head-custom">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">credit</th>
                        <th scope="col">semestre</th>
                        <th scope="col">Categorie</th>

                        <th scope="col" class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uniteValeurs as $unitevaleur)
                        <tr>
                            <td scope="row">{{ $unitevaleur->id }}</td>
                            <td scope="row">{{ $unitevaleur->nom }}</td>
                            <td scope="row">{{ $unitevaleur->credit }}</td>
                            <td scope="row">{{ $unitevaleur->semestre->nom }}</td>
                            <td scope="row">{{ $unitevaleur->category->nom }}</td>
                            {{-- <td scope="row">{{ $unitevaleur->niveau->nom }}</td>
                            <td scope="row">{{ $unitevaleur->filiere->nom }}</td> --}}
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

            {{-- {{ $uniteValeurs->appends(request()->input())->links() }} --}}
        </div>
    @endsection
</x-layout>
