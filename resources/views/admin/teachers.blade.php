<x-layout>
    @section('title', 'Teachers')

    @section('content')
        <x-header />
        <x-menu />

        <div class="filter">
            <div class="flex justify-between">
                <a href="{{ route('etudiant.register') }}" class="btn text-violet-800 font-bold flex w-1/3">Ajouter un
                    enseignant<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px"
                        height="24px">
                        <path
                            d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z" />
                    </svg>
                </a>
                <div class="  font-bold">
                    <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
                        @csrf
                        <label for="annee">Année Académique</label>
                        <select name="annee" id="annee" class="border-none outline-none focus:border-none cursor-pointer"
                            onchange="submit()">
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->id }}"
                                    class="cursor-pointer border-b-4 border-double border-black"
                                    {{ $annee->is_active == true ? 'selected' : '' }}>{{ $annee->nom }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <form method="get" action="{{ route('teachers') }}" id="form"
                class="px-3 text-white grid-cols-4 content flex gap-5 items-center justify-around bg-orange-400 py-2">
                @csrf

                <input type="text" id="search" name="search" class="hidden">

                <h3>Filtrer par :</h3>


                <article class="flex flex-col w-full">
                    <label for="filiere">Filieres</label>
                    <select name="filiere" id="filiere" class="text-black rounded-md w-full"  onchange="
                document.querySelector('#search').value=document.querySelector('#searchHead').value
                this.value=this.value
                console.log(document.querySelector('#filiereHead').value)
                submit()
                "
                oninput="

                "
                >
                        <option value=""></option>
                        @foreach ($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ request('filiere') == $filiere->id ? 'selected' : '' }}
                                id={{ $filiere->id }}>{{ $filiere->nom }}</option>
                        @endforeach
                    </select>
                </article>

                <!-- specialite Filter -->
                <article class="flex flex-col w-full">
                    <label for="specialite">specialite</label>
                    <select name="specialite" id="specialite" class="text-black rounded-md w-full"  onchange="
                    document.querySelector('#search').value=document.querySelector('#searchHead').value
                this.value=this.value

                    submit()"
                oninput=" this.value=this.value"
                >
                        <option value=""></option>
                        @foreach ($specialites as $specialite)
                            <option id={{ $specialite->id }} value="{{ $specialite->id }}"
                                {{ request('specialite') == $specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>


                <!-- Tri par Ancienneté -->
                <article class="flex flex-col w-full">
                    <label for="uniteValeur">Unite de valeur</label>
                    <select id="uniteValeur" name="uniteValeur" class="text-black rounded-md w-full"  onchange="
                    document.querySelector('#search').value=document.querySelector('#searchHead').value
                this.value=this.value

                    submit()"
                >
                        <option value=""></option>
                        @foreach ($uniteValeurs as $uniteValeur)
                            <option value="{{ $uniteValeur->nom }}"
                                {{ request('uniteValeur') == $uniteValeur->nom ? 'selected' : '' }}
                                >{{ $uniteValeur->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>
            </form>
        </div>

        <div class="table mt-3">
        <p class="font-bold text-1xl italic">Total : {{$total}}</p>

            <table class="table-custom">
                <thead class="table-head-custom">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Sexe</th>
                        <th scope="col">Type de contrat</th>
                        <th scope="col">Diplome</th>
                        <th scope="col">mobile</th>
                        <th scope="col">Profession</th>
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
                            <td>{{ $teacher->typeContrat }}</td>
                            <td>{{ $teacher->diplome }}</td>
                            <td>{{ $teacher->mobile }}</td>
                            <td>{{ $teacher->profession }}</td>
                            {{-- <td>
                                @if ($teacher->specialites->count() > 1)
                            <select name="" id="specialite" data-teacher-id="{{ $teacher->id }}">
                                @endif
                                @foreach ($teacher->specialites as $specialite)
                                <option value="{{$specialite->id}}" {{ request('specialite') == $specialite->id ? 'selected':'' }}>{{ $specialite->nom }} </option>
                                @endforeach
                             @if ($teacher->specialites->count() > 1)
                            </select>
                            @endif
                        </td>
                        <td> --}}
                            {{-- @if ($teacher->filieres->count() > 1)
                            <select name="" id="filiere"  data-teacher-id="{{ $teacher->id }}">
                                @endif
                                @foreach ($teacher->filieres as $filiere)
                                <option value="{{ $filiere->id  }}" {{ request('filiere') == $filiere->id ? 'selected':'' }}>{{ $filiere->nom }} </option>
                                @endforeach

                                @if ($teacher->filieres->count() > 1)
                                </select>
                                    @endif
                            </td> --}}
                            {{-- <td>
                            @if ($teacher->uniteValeurs->count() > 1)
                            <select name="" id="">
                                @endif
                                @foreach ($teacher->uniteValeurs as $uniteValeur)

                                <option value="$uniteValeur->id" {{ request('uniteValeur') == $uniteValeur->id ? 'selected' : ''  }}>{{ $uniteValeur->nom }} </option>
                                @endforeach

                                @if ($teacher->uniteValeurs->count() > 1)
                            </select>
                                @endif
                        </td> --}}


                            <td class="text-center">
                                <a href="{{ route('teacher.show', $teacher) }}"
                                    class="text-blue-600 hover:text-blue-900">Voir</a>
                            </td>
                            <td class="text-center">
                                <a href="
                            {{-- {{ route('teacher.edit', $teacher->id) }} --}}
                             "
                                    class="text-green-600 hover:text-green-900">Éditer</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                @if (request('search') || request('specialite') || request('filiere'))
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
        {{-- @dd($filieres) --}}
        <script>
            //         document.addEventListener('DOMContentLoaded', function() {
            //        const specialites = @json($specialites);
            //        function updateFilieres(selectElement) {
            //     const specialiteId = selectElement.value;

            //     const teacherId = selectElement.getAttribute('data-teacher-id');
            //     // console.log(selectElement)
            //     let filiereSelect = document.querySelector(`#filiere[data-teacher-id="${teacherId}"]`);
            //     filiereValues = [];
            //     filiereSelect.querySelectorAll('option').forEach(option => {
            //         filiereValues.push(option.value);
            //     });
            //     filiere_idstore=`filiere_${teacherId}_${filiereValues.length}`

            //     if (!localStorage.getItem(filiere_idstore)) {
            //     localStorage.setItem(filiere_idstore, JSON.stringify(filiereValues));
            //     }
            //     filiereValues = JSON.parse(localStorage.getItem(filiere_idstore))
            //     console.log(filiereValues)
            //     filiereSelect.innerHTML=''
            //     if (specialiteId) {
            //         const specialite = specialites.find(n => n.id == specialiteId);
            //         if (specialite) {
            //             specialite.filieres.forEach(filiere => {
            //                 let option = document.createElement('option');
            //                 filiereValues.forEach(filiere_id => {
            //                     if(filiere_id == filiere.id){

            //                         option.value = filiere.id;
            //                         option.textContent = filiere.nom;
            //                         filiereSelect.appendChild(option);
            //                     }
            //                 })
            //             });
            //         }
            //     }
            // }
            // Vous pouvez également pré-remplir les filières pour chaque enseignant au chargement de la page
            // allspecialite=document.querySelectorAll('#specialite')
            // allspecialite.forEach(specialite => {
            //     specialite.addEventListener('change', function() {
            //         updateFilieres(this);
            //     });
            // console.log('k,l')
            // updateFilieres(specialite);
            // });

            // })
        </script>

    @endsection
</x-layout>
