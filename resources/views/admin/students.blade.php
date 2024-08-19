<x-layout>
    @section('title','Students')

    @section('content')
    <x-header />
    <x-menu />

    <div class="filter ">
        <a href="{{ route('etudiant.register') }}" class="btn text-violet-800 font-bold flex w-1/3">Ajouter un etudiant<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
            <path d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z"/>
        </svg>
        </a>
        <form method="get" action="{{ route('students') }}" id="form" class="px-3 text-white  grid-cols-4 content flex gap-5 items-center justify-around bg-orange-400 py-2">
            @csrf
            <h3>Filtrer par:</h3>

            <article class="flex flex-col  w-full">
                <label for="niveau">Niveau</label>

                <select type="text" id="niveau" list="listNiveau"  name="niveau" class="text-black rounded-md w-full"  onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                submit()
                " placeholder="----------------------------"
                oninput=" this.value=this.value"
                >

                <option value=""></option>
                @foreach ($niveaux as  $niveau)

                <option value="{{ $niveau->nom }}" {{ request('niveau')===$niveau->nom? 'selected':"" }}>{{ $niveau->nom }}</option>
                @endforeach
        </select>
            </article>

            <article class="flex flex-col w-full">
                <label for="filiere">Filiere</label>
                <input type="text" id="search" name="search" class="hidden" oninput=" this.value=this.value">
                <select type="text" id="filiere" name="filiere" class="w-full text-black rounded-md" placeholder="----------------------------" onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                submit();
                ">

<option value=""></option>
                @foreach ($filieres as  $filiere)

                <option value="{{ $filiere->nom }}" {{ request('filiere')===$filiere->nom ? 'selected':"" }}>{{ $filiere->nom }}</option>
                @endforeach
        </select>
            </article>

            <article class="flex flex-col w-full">

                <label for="anciennete">Unité de valeur</label>


              <select type="text" id="anciennete" name="anciennete" class="text-black ounded-md" list="listdate" placeholder="----------------------------"  onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                submit()
                "
                oninput=" this.value=this.value">
                <option value=""></option>

                @foreach ($filieres as  $filiere)

                <option value="{{ $filiere->nom }}" {{ request('filiere')===$filiere->nom ? 'selected':"" }}>{{ $filiere->nom }}</option>
                @endforeach
                        </select>
            </article>
        </form>
        </div>

        <div class="table mt-3">
        <table class="table table-striped"
            style="

                border:1px black solid !important;
                --bs-table-color: #161313;
                --bs-table-bg: white;
                --bs-table-border-color: #4d5154;
                --bs-table-striped-bg: #2c303426;
                --bs-table-striped-color: #0f0e0e ;
            "
            >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Sexe</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Filiere</th>
                    <th scope="col" class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <th scope="row">{{ $student['code'] }}</th>
                        <th scope="row">{{ $student['nom'] }}</th>
                        <th scope="row">{{ $student['prenom'] }}</th>
                        <th scope="row">{{ $student['sexe'] }}</th>
                        <th scope="row">
                            <a href="{{ route('studentsByNiveau',['niveau'=>$student->niveau]) }}">
                            {{ $student->niveau->nom }}
                            </a>
                        </th>
                        <th scope="row">
                            <a href="{{ route('studentsByFiliere',['filiere'=>$student->filiere]) }}">
                                {{ $student->filiere->nom }}
                            </a>
                        </th>
                        <th scope="row"> <a href="{{ route('student.show', ['student'=>$student]) }}">Voir</a> </th>
                        <th scope="row"> <a href="{{ route('student.edit', ['student'=>$student]) }}">Editer</a> </th>

                    </tr>
                @empty
                @if (isset($search))

                <p class="alert alert-info">Aucun eleve ne correspond a ces criteres</p>
                    @else
                    <p class="alert alert-info">Aucun eleve enregistré</p>
                @endif

                @endforelse
            </tbody>
        </table>

        {{ $students->appends(request()->input())->links() }}
    </div>
@endsection

</x-layout>

