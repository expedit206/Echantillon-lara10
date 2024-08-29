document.addEventListener('DOMContentLoaded', function() {
    // const openModalBtn = document.getElementById('open-modal');
    const openModalBtn = document.querySelectorAll('.open-modal');

    const closeModalBtn = document.getElementById('close-modal');
    const modal = document.getElementById('notes-modal');
    const body = document.body;
    openModalBtn.forEach(modalBtn => {

        modalBtn.addEventListener('click', function(event) {
// alert('vvf')
            event.preventDefault();
    modal.classList.add('showModal');
    body.classList.add('modal-open');
    // Désactive le défilement de la page
});
    });

    closeModalBtn.addEventListener('click', function() {
        modal.classList.remove('showModal');
        body.classList.remove('modal-open'); // Réactive le défilement de la page
    });

    // Optionnel : Fermer le modal en cliquant à l'extérieur de celui-ci
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.remove('showModal');
            body.classList.remove('modal-open');
        }
    });
});
