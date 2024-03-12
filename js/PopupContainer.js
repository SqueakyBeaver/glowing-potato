/** class defining a popup container */
class PopupContainer {
    static topZIndex = 100;
    static numPopups = 1;
    /**
     * @param {HTMLElement} content The element that will be the content of the popup 
     */
    constructor(content) {
        this.container = document.createElement("div");
        this.container.classList.add("popup-container");

        this.popupDimmer = document.createElement("div");
        this.popupDimmer.classList.add("background-dimmer");

        let closeButton = document.createElement("button");
        closeButton.classList.add("popup-close-button");
        closeButton.textContent = "Click to close popup";
        content.append(closeButton);

        this.popupElement = content;
    }

    /** 
     * @param {PopupContainer} popup The popup that needs to be closed
     */
    static closePopup() {
        let popups = document.getElementsByClassName("popup-container");
        let toClose = popups[popups.length - 1];

        toClose.remove();

        PopupContainer.numPopups--;
        // I don't think I should decrease the top z-index counter
        // because I can see it causing issues if I do
    }

    showPopup() {
        this.container.style.zIndex = PopupContainer.topZIndex++;
        this.popupDimmer.style.zIndex = PopupContainer.topZIndex++;
        this.popupElement.style.zIndex = PopupContainer.topZIndex++;

        this.container.style.display = "inline";
        this.popupElement.style.display = "inline";
        this.popupDimmer.style.display = "inline";


        // This is so the background doesn't become just black if there are multiple popups
        if (PopupContainer.numPopups > 1) {
            this.popupDimmer.style.backgroundColor = "transparent";
        }

        this.container.appendChild(this.popupDimmer);
        this.container.appendChild(this.popupElement);

        this.container = document.body.appendChild(this.container);

        PopupContainer.numPopups++;

        // So that way people clicking buttons really fast don't close popups immediately
        setTimeout(() => {
            let dimmers = document.getElementsByClassName("background-dimmer");
            dimmers[dimmers.length - 1].onclick = PopupContainer.closePopup;

            let closeButtons = document.getElementsByClassName("popup-close-button");
            closeButtons[closeButtons.length - 1].onclick = PopupContainer.closePopup;
        }, 500);
    }
}


