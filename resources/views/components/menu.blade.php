<div class="l-navbar show " id="nav-bar">
    <nav class="nav">
        <div>
            <a href="
            @if(Auth::guard('admin')->check())
            {{ route('dashboard') }}
            @elseif (Auth::guard('enseignant')->check())
            {{ route('enseignant.dashboard') }}
            @endif
            " class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">Tableau de bord</span> </a>
            <div class="nav_list">
                <a href="{{ route('students') }}" class="nav_link " id='etudiants'>
                    <i class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">
                       Liste des Etudiants
                    </span>
                </a>
            @if(Auth::guard('admin')->check())

                <a href="{{ route('teachers') }}" class="nav_link" id='enseignants'> <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">
                        Enseignants</span>
                </a>
                @endif


                <a href="{{ route('uniteValeur.index') }}" class="nav_link"> <i
                        class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">
            @if(Auth::guard('admin')->check())
            Unités de Valeur
            @elseif(Auth::guard('enseignant')->check())
            Mes Unités de Valeur
                @endif
                        </span>
                </a>
                <a href="{{ route('teachers') }}" class="open-modal nav_link" id='etudiants'> <i
                        class='bx bx-bookmark nav_icon open-modal'></i> <span class="nav_name open-modal">consulter les evaluations</span>
                </a>
                @if(Auth::guard('enseignant')->check())
                <a href="{{ route('notes.create') }}" class="nav_link"> <i class='bx bx-folder nav_icon'></i> <span
                    class="nav_name">Attribuer des note</span>
                </a>
                    @endif
                    @php
    $anneeActive = \App\Models\Annee::where('is_active', true)->first();
@endphp

                <a href="{{ route('NoteGraphique', $anneeActive) }}" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span
                        class="nav_name">Stats</span>
                </a>
            </div>
        </div>
        <div>
            <a href="{{ route('etudiant.register') }}" class="nav_link">
                <i class='bx bx-plus nav_icon'></i>
                <span class="nav_name">Ajouter un etudiant</span>
            </a>
            <a href="{{ route('enseignants.create') }}" class="nav_link">
                <i class='bx bx-plus nav_icon'></i>
                <span class="nav_name">Ajouter un enseignant</span>
            </a>
            {{-- @dd() --}}
            {{-- @dd(Auth::guard('enseignant')->user()->id) --}}
            @if(Auth::guard('enseignant')->check())
            <form action="{{ route('enseignants.destroy', Auth::guard('enseignant')->user()->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="nav_link">
                    <i class='bx bx-log-out nav_icon'></i>
                    <span class="nav_name">SignOut</span>
                </button>
            </form>
        @endif
    </div>
    </nav>
</div>

{{-- @dd($teachers) --}}
