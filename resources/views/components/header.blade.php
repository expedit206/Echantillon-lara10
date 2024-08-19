

<header class="header border-b-2  border-black relative px-0 body-pd" id="header">
    <div class="header_toggle"> <i class='bx bx-menu bx-x' id="header-toggle"></i> STUDAMIN</div>

    <form method='get' action="{{ route('students') }}"
    class="flex items-center justify-center gap-2 border-black border-2 rounded-[1rem]">

    <input name="search" id="searchHead" value="{{request('search')}}" class="focus:outline-none focus:border-transparent border-none bg-transparent" placeholder="Rechercher"  oninput=" this.value=this.value

    document.querySelector('#niveauHead').value=document.querySelector('#niveau').value
    document.querySelector('#filiereHead').value=document.querySelector('#filiere').value
    document.querySelector('#ancienneteHead').value=document.querySelector('#anciennete').value

    console.log(document.querySelector('#niveau').value)
    // submit()
    " >

                <input type="text" name="filiere" id="filiereHead" hidden>
                <input type="text" name="niveau" id="niveauHead" hidden>
                <input type="text" name="anciennete" id="ancienneteHead" hidden>

    <button class="" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path
                d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z">
            </path>
            <path
                d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z">
            </path>
        </svg>
    </button>
</form>

    <div class="flex items-center justify-center gap-2">
        <span>Mon compte</span>
        <div class="flex">

            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class=" text" viewBox="0 0 24 24"
                style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                <path
                    d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z">
                </path>
            </svg>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    onfghjklm
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>


        </div>

    </div>
</header>

<div>
    @if (@session('status'))
        {{session('status')}}
    @endif
</div>
