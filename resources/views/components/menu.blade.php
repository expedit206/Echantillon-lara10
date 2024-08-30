<div class="l-navbar show " id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">Dashboard</span> </a>
                <div class="nav_list">
                    <a href="{{ route('students') }}" class="nav_link " id='etudiants'>
                        <i class='bx bx-grid-alt nav_icon'></i>
                        <span class="nav_name">
                            Etudiants
                        </span>
                    </a>
                    <a href="{{ route('teachers') }}" class="nav_link" id='enseignants'> <i class='bx bx-user nav_icon'></i> <span
                            class="nav_name">
                        Enseignants</span>
                    </a>
                    <a href="{{ route('uniteValeur.index') }}" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span
                            class="nav_name">Unités de valeur</span>
                    </a>
                    <a href="{{ route('teachers') }}" class="open-modal nav_link" id='etudiants'> <i class='bx bx-bookmark nav_icon open-modal'  ></i> <span
                            class="nav_name open-modal">Notes</span>
                    </a>
                    <a href="#" class="nav_link"> <i class='bx bx-folder nav_icon'></i> <span
                            class="nav_name">Files</span>
                    </a>
                    <a href="#" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span
                            class="nav_name">Stats</span>
                    </a>
                </div>
            </div>
            <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">SignOut</span>
            </a>
        </nav>
    </div>

{{-- @dd($teachers) --}}


