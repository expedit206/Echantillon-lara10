<x-layout>
    @section('title','Students')

    @section('content')
    <x-header />
    <x-menu />


    <div class="filter ">

      <div class="flex justify-between">
          <a href="{{ route('etudiant.register') }}" class="btn text-violet-800 font-bold flex w-1/3">Ajouter un etudiant<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
            <path d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z"/>
        </svg>
        </a>
        <div class="  font-bold">
<form method='post' action="{{route('annee.setActive')}}" id="formAnnee">
    @csrf
            <label for="annee">Année Académique</label>
            <select name="annee" id="annee" class="border-none outline-none focus:border-none cursor-pointer" onchange="submit()"
            >
                @foreach($annees as $annee)
                <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black"
                    {{ $annee->is_active==true? 'selected':''}}
                    >{{ $annee->nom }}</option>
                @endforeach
            </select>
        </form>
        </div>
        </div>
        <form method="get" action="{{ route('students') }}" id="form" class="px-3 text-white  grid-cols-5 content flex gap-3 items-center justify-around bg-orange-400 py-2">
            @csrf
            <h3>Filtrer par:</h3>
            {{-- <input type="text" name="annee" id="anneeForm"> --}}
            <article class="flex flex-col  w-full">
                <label for="niveau">Niveau</label>

                <select type="text" id="niveau" list="listNiveau"  name="niveau" class="text-black rounded-md w-full"  onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                this.value=this.value
                submit()"                >

                <option value=""></option>
                @foreach ($niveaux as  $niveau)

                <option value="{{ $niveau->nom }}" {{ request('niveau')===$niveau->nom? 'selected':"" }}>{{ $niveau->nom }}</option>
                @endforeach
        </select>
            </article>

            <article class="flex flex-col w-full">
                <label for="filiere">Filiere</label>
                <input type="text" id="search" name="search" class="hidden">
                <select type="text" id="filiere" name="filiere" class="w-full text-black rounded-md" placeholder="----------------------------" onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                console.log(document.querySelector('#search').value)
            this.value=this.value

                submit()
                ">

                <option value=""></option>
                @foreach ($filieres as  $filiere)

                <option value="{{ $filiere->nom }}" {{ request('filiere')===$filiere->nom ? 'selected':"" }}>{{ $filiere->nom }}</option>
                @endforeach
                  </select>
            </article>

            <article class="flex flex-col w-full">
                <label for="specialite">specialite</label>
                <input type="text" id="search" name="search" class="hidden">
                <select type="text" id="specialite" name="specialite" class="w-full text-black rounded-md" placeholder="----------------------------" onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                submit();
                ">

                <option value=""></option>
                @foreach ($specialites as  $specialite)

                <option value="{{ $specialite->id }}" {{ request('specialite')==$specialite->id ? 'selected':"" }}>{{ $specialite->nom }}</option>
                @endforeach
                  </select>
            </article>

           <article class="flex flex-col w-full">
                <label for="anciennete">Trie par</label>


              <select type="text" id="anciennete" name="anciennete" class="text-black ounded-md" list="listdate" placeholder="----------------------------"  onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                submit()
                "
                oninput=" this.value=this.value">

                    <option value="Plus recent" {{ request('anciennete')=="Plus recent" ? 'selected':"" }}>Plus recent</option>
                    <option value="Moins recent" {{ request('anciennete')=="Moins recent" ? 'selected':"" }}>moins recent</option>
                    <option value="A à Z" {{ request('anciennete')=="A à Z" ? 'selected':"" }}>A à Z(nom)</option>
                    <option value="Z à A" {{ request('anciennete')=="Z à A" ? 'selected':"" }}>Z à A(nom)</option>

                        </select>
            </article>
        </form>
        </div>

        <div class="table mt-3 ">
        <p class="font-bold text-1xl italic">Total : {{$total}}</p>
        <table class="table table-striped overflow-scroll"
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
                    <th scope="col">Spécialité</th>
                    <th scope="col" class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td scope="row">{{ $student['code'] }}</td>
                        <td scope="row">{{ $student['nom'] }}</td>
                        <td scope="row">{{ $student['prenom'] }}</td>
                        <td scope="row">{{ $student['sexe'] }}</td>
                        <td scope="row">
                            {{-- @dd($student->niveau) --}}
                            <a href="{{ route('studentsByNiveau',['niveau'=>$student->niveau]) }}">
                            {{ $student->niveau->nom }}
                            </a>
                        </td>
                        <td scope="row">
                            <a href="{{ route('studentsByFiliere',['filiere'=>$student->filiere]) }}">
                                {{ $student->filiere->nom }}
                            </a>
                        </td>
                        <td scope="row">{{ $student['specialite']->nom }}</td>

                        <td scope="row"> <a href="{{ route('student.show', ['student'=>$student]) }}" class="text-blue-600 hover:text-blue-900">Voir</a> </td>
                        <td scope="row"> <a href="{{ route('student.edit', ['student'=>$student]) }}" class="text-green-600 hover:text-green-900">Editer</a> </td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            @if (request('search') || request('niveau') || request('filiere'))
                                Aucun etudiant ne correspond à ces critères.
                            @else
                                Aucun etudiant enregistré.
                            @endif
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        {{ $students->appends(request()->input())->links() }}
    </div>
@endsection

</x-layout>

<script>
    function change(){

        document.querySelector('#search').value=document.querySelector('#searchHead').value
        anneeForm.value=annee.value;
        console.log(anneeForm)

    }


    </script>
