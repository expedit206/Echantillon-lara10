document.addEventListener("DOMContentLoaded", function(event) {
   
    const showNavbar = (toggleId, navId, bodyId, headerId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId)
    
    // Validate that all variables exist
    if(toggle && nav && bodypd && headerpd){
    toggle.addEventListener('click', ()=>{
    // show navbar
    nav.classList.toggle('show')
    // change icon
    toggle.classList.toggle('bx-x')
    // add padding to body
    bodypd.classList.toggle('body-pd')
    // add padding to header
    headerpd.classList.toggle('body-pd')
    })
    }
    }
    
    showNavbar('header-toggle','nav-bar','body-pd','header')
    
    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')
    
    // function colorLink(){
    // if(linkColor){
    // linkColor.forEach(l=> l.classList.remove('active'))
    // this.classList.add('active')
    // }
    // }
    // linkColor.forEach(l=> l.addEventListener('click', colorLink))
    document.getElementById('etudiants').classList.add('active');
    
    function colorLink(){
        if(linkColor){
            linkColor.forEach(l=> l.classList.remove('active'));
            this.classList.add('active');
            localStorage.setItem('activeLink', this.id);
        }
    }   
    
    linkColor.forEach(l=> l.addEventListener('click', colorLink));
    
    // Récupérer le lien actif après le rechargement
    const activeLinkId = localStorage.getItem('activeLink');
    if (activeLinkId) {
            linkColor.forEach(l=> l.classList.remove('active'));

        document.getElementById(activeLinkId).classList.add('active');
    }
    
     // Your code to run since DOM is loaded and ready
    });
    