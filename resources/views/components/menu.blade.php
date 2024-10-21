<div class="l-navbar show " id="nav-bar">
    <nav class="nav">
        <div>
            <a href="
            @if(Auth::guard('admin')->check())
            {{ route('dashboard') }}
            @elseif (Auth::guard('enseignant')->check())
            {{ route('enseignant.dashboard') }}
            @elseif (Auth::guard('etudiant')->check())
            {{ route('etudiant.dashboard') }}
            @endif
            " class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">Tableau de bord</span> </a>
            <div class="nav_list">
            @if(Auth::guard('admin')->check() || Auth::guard('enseignant')->check() )

                <a href="{{ route('students') }}" class="nav_link " id='etudiants'>
                    <i class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">
                       Liste des Etudiants
                    </span>
                </a>
                @endif
                
            @if(Auth::guard('admin')->check())

                <a href="{{ route('teachers') }}" class="nav_link" id='enseignants'> <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">
                      Liste des  Enseignants</span>
                </a>
                @endif
            @if(Auth::guard('etudiant')->check())

                <a href="{{ route('teachers') }}" class="nav_link" id='enseignants'> <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">
                      Mes Enseignants</span>
                </a>
                @endif


                <a href="{{ route('uniteValeur.index') }}" class="nav_link" id='unites'> <i
                        class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">
            @if(Auth::guard('admin')->check())
            liste des Unités de Valeur
            @elseif(Auth::guard('enseignant')->check() || Auth::guard('etudiant')->check() )
            Mes Unités de Valeur
                @endif
                        </span>
                </a>

                @if(Auth::guard('admin')->check())
                <a href="{{ route('assigner-matiere.create') }}" class="nav_link" id='unite_enseignant'> <i
                        class='bx bx-message-square-detail nav_icon' ></i> <span class="nav_name">
            Associer  Unité de Valeur-enseignant
        </span>
    </a>
    @endif

                @if(Auth::guard('admin')->check())
                <a href="#" class="nav_link" id="showFormLink" id='show'> <i
                        class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">
            Associer matieres-specialite
        </span>
    </a>
    @endif

    
                <a href="#" class="open-modal nav_link" id='consulter'> <i
                        class='bx bx-bookmark nav_icon open-modal'></i> <span class="nav_name open-modal">consulter les evaluations</span>
                </a>
                @if(Auth::guard('enseignant')->check())
                <a href="#" class="nav_link open-modal" id="attribuer"> <i class='bx bx-folder nav_icon'></i> <span
                    class="nav_name open-modal">Attribuer des notes</span>
                </a>
                    @endif
                    @php
              $anneeActive = \App\Models\Annee::where('is_active', true)->first();
              @endphp

                <a href="{{ route('NoteGraphique', $anneeActive) }}" class="nav_link" id='stats'> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span
                        class="nav_name">Stats</span>
                </a>
            </div>
        </div>

        <div>
            @if(Auth::guard('admin')->check())

            <a href="{{ route('etudiant.register') }}" class="nav_link" id='add_student'>
                <i class='bx bx-plus nav_icon'></i>
                <span class="nav_name">Ajouter un etudiant</span>
            </a>
            <a href="{{ route('enseignants.create') }}" class="nav_link" id='add_teacher'>
                <i class='bx bx-plus nav_icon'></i>
                <span class="nav_name">Ajouter un enseignant</span>
            </a>
            <a href="{{ route('uniteValeur.create') }}" class="nav_link" id='add_unites'>
                <i class='bx bx-plus nav_icon'></i>
                <span class="nav_name">Ajouter une unité de valeur</span>
            </a>
            @endif

                <a href="
            @if(Auth::guard('enseignant')->check())
                {{ route('enseignant.logout') }}
            @endif
            @if(Auth::guard('admin')->check())
                {{ route('admin.logout') }}
            @endif
            @if(Auth::guard('etudiant')->check())
                {{ route('etudiant.logout') }}
            @endif

                " class="nav_link">
                    <i class='bx bx-log-out nav_icon'></i>
                    <span class="nav_name">SignOut</span>
                </a>
    </div>
    </nav>

    @if(session('success'))
    {{ session('success') }}
@endif

@if(session('error'))
    {{ session('error') }}
@endif

</div>
