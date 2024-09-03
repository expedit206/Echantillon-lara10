document.addEventListener("DOMContentLoaded", function () {

    // const openModalBtn = document.getElementById('open-modal');
    const openModalBtn = document.querySelectorAll(".open-modal");

    const closeModalBtn = document.getElementById("close-modal");
    const modal = document.getElementById("notes-modal");
    const body = document.body;
    openModalBtn.forEach((modalBtn) => {
        modalBtn.addEventListener("click", function (event) {
            // alert('vvf')
            event.preventDefault();
            modal.classList.add("showModal");
            body.classList.add("modal-open");
            // Désactive le défilement de la page
        });
    });

    closeModalBtn.addEventListener("click", function () {
        modal.classList.remove("showModal");
        body.classList.remove("modal-open"); // Réactive le défilement de la page
    });

    // Optionnel : Fermer le modal en cliquant à l'extérieur de celui-ci
    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("showModal");
            body.classList.remove("modal-open");
        }
    });

    /****************************************************** */
    // console.log(anneeSelect);
    const anneeSelect = document.getElementById("anneeModal");
        const semestreSelect = document.getElementById("semestreModal");
        const niveauSelect = document.getElementById("niveauModal");
        const specialiteSelect = document.getElementById("specialiteModal");
        const matiereSelect = document.getElementById("matiereModal");

        // Fonction pour mettre à jour les semestres
        function updateSemestres(anneeId) {
            fetch(`/semestres/${anneeId}`)
                .then(response => response.json())
                .then(data => {
                    semestreSelect.innerHTML = ""; // Clear previous options
                    data.forEach(semestre => {
                        let option = document.createElement("option");
                        option.value = semestre.id;
                        option.textContent = semestre.nom;
                        semestreSelect.appendChild(option);
                    });
                    // Déclencher l'événement input pour mettre à jour les niveaux
                    const event = new Event('input', { bubbles: true });
                    semestreSelect.dispatchEvent(event);
                });
        }

        // Fonction pour mettre à jour les spécialités
        function updateSpecialites(niveauId) {

            fetch(`/specialites/${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    specialiteSelect.innerHTML = ""; // Clear previous options
                    data.forEach(specialite => {
                        let option = document.createElement("option");
                        option.value = specialite.id;
                        option.textContent = specialite.nom;
                        specialiteSelect.appendChild(option);
                    });
                    // Déclencher l'événement input pour mettre à jour les matières
                    const event = new Event('input', { bubbles: true });
                    specialiteSelect.dispatchEvent(event);
                });
        }

        // Fonction pour mettre à jour les matières
        function updateMatieresBySpecialite(semestreId,specialiteId) {
            fetch(`/matieresBySpecialite/${semestreId}/${specialiteId}`)
                .then(
                    response => response.json()
                )
                .then(data => {
                    console.log(data);

                    matiereSelect.innerHTML = ""; // Clear previous options
                    data.forEach(matiere => {
                        let option = document.createElement("option");
                        option.value = matiere.id;
                        option.textContent = matiere.nom;
                        matiereSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching matières:", error));
        }
        // Fonction pour mettre à jour les matières
        function updateMatieresBySemestre(specialiteId, semestreId) {

            fetch(`/matieresBySemestre/${specialiteId}/${semestreId}`)
                .then(response => response.json())
                .then(data => {

                    console.log( specialiteId);
                    console.log( semestreId);
                    console.log(data);
                    matiereSelect.innerHTML = ""; // Clear previous options
                    data.forEach(matiere => {
                        let option = document.createElement("option");
                        option.value = matiere.id;
                        option.textContent = matiere.nom;
                        matiereSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching matières:", error));
                // console.log(specialiteId);
        }

        // Mise à jour des sélecteurs lors du chargement de la page
        if (anneeSelect.value) {
            updateSemestres(anneeSelect.value);
        }
        if (niveauSelect.value) {
            updateSpecialites(niveauSelect.value);
        }
        if (specialiteSelect.value) {
            updateMatieresBySpecialite(semestreSelect.value,specialiteSelect.value);
        }
        if (semestreSelect.value) {
            updateMatieresBySemestre(specialiteSelect.value,specialiteSelect.value);
        }

        // Ajouter les event listeners pour les changements dynamiques après sélection
        anneeSelect.addEventListener("input", function () {
            updateSemestres(this.value);
        });

        niveauSelect.addEventListener("input", function () {

            updateSpecialites(this.value);
        });

        specialiteSelect.addEventListener("input", function () {
            updateMatieresBySpecialite(semestreSelect.value,this.value);
        });

        semestreSelect.addEventListener("input", function () {
            updateMatieresBySemestre(specialiteSelect.value, this.value);
        });
});
console.log(specialiteSelect);
