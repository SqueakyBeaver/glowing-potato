/** class defining a popup container */
// Note: I could be wrong, but I am 90% sure that the import/export for es modules
// is very similar to the way typescript does it
class PopupContainer {
    static topZIndex = 100;
    /**
     * @param {string} id the id of the element that was clicked to create this popup
     * @param {string} content The inner HTML of the popup 
     */
    constructor(content) {
        this.container = document.createElement("div");
        this.container.classList.add("popup-container");

        this.popupDimmer = document.createElement("div");
        this.popupDimmer.classList.add("background-dimmer");

        this.popupElement = document.createElement("div");
        this.popupElement.classList.add("popup");
        this.popupElement.innerHTML = content;
    }

    /** 
     * @param {PopupContainer} popup The popup that needs to be closed
     */
    static closePopup() {
        console.log(1);
        let popups = document.getElementsByClassName("popup-container");
        let toClose = popups[popups.length - 1];
        toClose.remove();
    }

    showPopup() {
        this.container.style.zIndex = this.topZIndex++;
        this.popupDimmer.style.zIndex = this.topZIndex++;
        this.popupElement.style.zIndex = this.topZIndex++;

        this.container.style.display = "inline";

        this.container.appendChild(this.popupDimmer);
        this.container.appendChild(this.popupElement);
        console.log(this.container);

        this.container = document.body.appendChild(this.container);

        let dimmers = document.getElementsByClassName("background-dimmer");
        dimmers[dimmers.length - 1].onclick = PopupContainer.closePopup;
    }
}


