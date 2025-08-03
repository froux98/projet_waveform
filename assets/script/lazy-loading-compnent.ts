import {ILazyLoadingElement} from "./i-lazy-loading-element";

// Classe gérant le chargement progressif de contenu
class LazyLoadingComponent {

    private readonly containerElements: HTMLElement = null;
    private readonly url: string = null;
    private readonly button: HTMLButtonElement = null;
    private currentPage: number;

    // Constructeur reçoit l'élément principal caractérisé par l'attribut data-lazyloading-container
    constructor(private mainElement: HTMLElement = null) {
        if (this.mainElement) {
            this.containerElements = mainElement.querySelector('[data-container-items]');
            this.url = mainElement.getAttribute('data-lazyloading-container');
            this.button = mainElement.querySelector('button');
            if (this.containerElements && this.url && this.button) {
                this.currentPage = 1;
                this.addActionButton();
            }
        }
    }

    private addActionButton(): void {
        this.button.addEventListener('click', () => {
            this.currentPage++;
            fetch(this.url + '?page=' + this.currentPage)
                .then((response) => {
                    if (response.status === 200) {
                        return response.json() as Promise<ILazyLoadingElement>;
                    }
                })
                .then((data) => {
                    if (data.hideButton) {
                        this.button.remove();
                    }
                    this.containerElements.innerHTML += data.html;
                });
        });
    }
}

window.addEventListener('load', () => {
    const lazyLoaderComponents: NodeListOf<HTMLElement> = document.querySelectorAll('[data-lazyloading-container]');
    lazyLoaderComponents.forEach((element) => {
        // element.getAttribute('data-lazyloading-container') => URL de la route du controller à appeler
        new LazyLoadingComponent(element);
    });
});
