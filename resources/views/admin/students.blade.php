<x-layout>
    @section('title', 'Students')

    @section('content')
        <x-header />
        <x-menu />


        <div class="filter">
            <div class="flex justify-between">
                <a href="{{ route('etudiant.register') }}" class="btn text-violet-800 font-bold flex w-1/3">Ajouter un
                    etudiant<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px"
                        height="24px">
                        <path
                            d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z" />
                    </svg>
                </a>
                <div class="  font-bold">
                       <div>
                           <label for="annee">Année Académique</label>
                           <select name="annee" id="anneeModal" class="border-none outline-none focus:border-none cursor-pointer">
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->id }}"
                                    class="cursor-pointer border-b-4 border-double border-black"
                                    {{ $annee->is_active == true ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>
            <form method="get" action="{{ route('teachers') }}" id="form"
                class="px-3 text-white grid-cols-4 content flex gap-4 items-center justify-around bg-orange-400 py-2">
                @csrf

                <input type="text" id="search" name="search" class="hidden">

                <h3>Filtrer par :</h3>
                <article class="flex flex-col  w-full">
                    <label for="niveau">Niveau</label>

                    <select type="text" id="niveauModal" list="listNiveau" name="niveau"
                        class="text-black rounded-md w-full"
                     
                ">

                        <option value=""></option>
                        @foreach ($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ request('niveau') === $niveau->nom ? 'selected' : '' }}>
                                {{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </article>


                <article class="flex flex-col w-full">
                    <label for="filiere">Filieres</label>
                    <select name="filiere" id="filiereModal" class="text-black rounded-md w-full" 
              
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
                    <select name="specialite" id="specialiteModal" class="text-black rounded-md w-full"
              
                >
                        <option value=""></option>
                        @foreach ($specialites as $specialite)
                            <option id={{ $specialite->id }} value="{{ $specialite->id }}"
                                {{ request('specialite') == $specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>


                <article class="flex flex-col w-full">
                    <label for="anciennete">Trie par</label>


                    <select type="text" id="anciennete" name="anciennete" class="text-black ounded-md" list="listdate"
                        placeholder="----------------------------"
                        
                "
                        oninput=" this.value=this.value">

                        <option value="Plus recent" {{ request('anciennete') == 'Plus recent' ? 'selected' : '' }}>Plus recent
                        </option>
                        <option value="Moins recent" {{ request('anciennete') == 'Moins recent' ? 'selected' : '' }}>moins
                            recent</option>
                        <option value="A à Z" {{ request('anciennete') == 'A à Z' ? 'selected' : '' }}>A à Z(nom)</option>
                        <option value="Z à A" {{ request('anciennete') == 'Z à A' ? 'selected' : '' }}>Z à A(nom)</option>

                    </select>
                </article>

            </form>
        </div>

        <div class="table mt-3 ">
            <p class="font-bold text-1xl italic">Total : {{ $total }}</p>
            <table class="overflow-scroll table-custom">
                <thead class="table-head-custom">
                    <tr class="bg-transparent">
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Niveau</th>
                        <th scope="col">Filiere</th>
                        <th scope="col">Spécialité</th>
                        <th scope="col" class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td scope="row" class="text-[.9rem]">{{ $student['matricule'] }}</td>
                            <td scope="row">{{ $student['nom'] }}</td>
                            <td scope="row">{{ $student['prenom'] }}</td>
                            <td scope="row">
                                {{-- @dd($student->niveau) --}}
                                <a href="{{ route('studentsByNiveau', ['niveau' => $student->niveau]) }}">
                                    {{ $student->niveau->nom }}
                                </a>
                            </td>
                            <td scope="row">
                                <a href="{{ route('studentsByFiliere', ['filiere' => $student->filiere]) }}">
                                    {{ $student->filiere->nom }}
                                </a>
                            </td>
                            <td scope="row">{{ $student['specialite']->nom }}</td>

                            <td scope="row"> <a href="{{ route('student.show', ['student' => $student]) }}"
                                    class="text-blue-600 hover:text-blue-900">Voir</a> </td>
                            <td scope="row"> <a href="{{ route('student.edit', ['student' => $student]) }}"
                                    class="text-green-600 hover:text-green-900">Editer</a> </td>


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
        {{-- <x-modal-form :annees="$annees" :semestres="$semestres" :niveaux="$niveaux" :specialites="$specialites" :matieres="$uniteValeurs" /> --}}
    @endsection

</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fonction pour mettre à jour la table des enseignants
        
        function updateTeachers() {
            const formData = new FormData(document.getElementById('form'));
            console.log([...formData.entries()]);
            fetch('studentsP', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = ''; // Efface les anciennes lignes
                
                console.log(data.students)
                // Ajoute les nouvelles lignes
                data.students.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                         <td scope="row" class="text-[.9rem]">${student.matricule}</td>
            <td scope="row">${student.nom}</td>
            <td scope="row">${student.prenom}</td>
            <td scope="row">
                <a href="/students/niveau/${student.niveau.nom}">${student.niveau.nom}</a>
            </td>
            <td scope="row">
                <a href="students/filiere/${student.filiere.id}">${student.filiere.nom}</a>
            </td>
            <td scope="row">${student.specialite.nom}</td>
            <td scope="row"><a href="students/${student.id}" class="text-blue-600 hover:text-blue-900">Voir</a></td>
            <td scope="row"><a href="students/edit/${student.id}" class="text-green-600 hover:text-green-900">Editer</a></td>
        `;
                    tbody.appendChild(row);
                });

                // Met à jour le total
                document.querySelector('.font-bold.text-1xl.italic').innerText = `Total : ${data.total}`;
            })
            .catch(error => console.error('Erreur:', error));
        }

        // Ajoute des écouteurs d'événements pour les sélecteurs
        document.querySelectorAll('#form select').forEach(select => {
            
            select.addEventListener('input', updateTeachers);
        });
    });
</script>