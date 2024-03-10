// File to house functions that will create popups
// import { PopupContainer } from './PopupContainer.js';

document.getElementById("about-link").onclick = function () {
    popup = new PopupContainer("<p>This is just a test teehee</p>");

    popup.showPopup();
};