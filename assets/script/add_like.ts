    function initButtonLike() : void {
        // Sélectionne tous les éléments <p> ayant un attribut [data-like]
    const buttons: NodeListOf<HTMLParagraphElement> = document.querySelectorAll('[data-like]');
    buttons.forEach((button) =>{
        // Récupère l'URL contenue dans l'attribut data-like (ex: pour l'appel AJAX)
        const url: string = button.dataset.like;
        // Envoie une requête HTTP POST à l'URL extraite
        button.addEventListener('click', () =>{
            fetch(url, {method: 'POST'})
                .then((response) => {
                    if (response.status === 200) {
                        return response.json();
                    }
                })
                .then((jsonContent) => {
                    let increment = 1;
                    if (jsonContent === 200) {
                        button.innerHTML = '<i class="fa-solid fa-heart text-danger"></i>';
                        button.title = 'j adore ce commentaire !';
                    } else if (jsonContent === 100) {
                        button.innerHTML = '<i class="fa-regular fa-heart"></i>';
                        button.title = 'Je n aime plus ce commentaire!';
                        increment = -1;
                        // Sinon : la réponse est une URL, redirige vers cette URL
                    } else {
                        window.location.href = jsonContent;
                    }
                    // Récupère l'élément parent du bouton (doit contenir un <p><span> compteur de likes)
                    const elementParent: HTMLElement = button.parentElement;
                    if (elementParent) {
                        const span: HTMLSpanElement = elementParent.querySelector('p > span');
                        span.innerText = (parseInt(span.innerText) + increment) + '';
                    }
                });
        });
        button.removeAttribute('data-like')
    });
}

window.addEventListener('load', () => {
    initButtonLike();
});
