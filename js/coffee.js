// import { PopupContainer } from './PopupContainer.js';

// Functions for when the "click for coffee" button is clicked

let clickedCount = 0;

// Show all the coffee PNGs after 3 seconds
document.getElementById("coffee-button").onclick = function coffeeClicked() {
    if (clickedCount === 0) {
        setTimeout(afterCoffeeClick, 3000);
    }
    clickedCount++;
};

// TODO: Polish the positioning bit, cleanup
function afterCoffeeClick() {
    const x = document.getElementById("coffeeButton");
    x.disabled = true;
    x.textContent = `Enjoy your ${clickedCount} cofees`;

    for (let i = 0; i < clickedCount; ++i) {
        let coffeePopup = new PopupContainer("<img src=\"images/coffee.png\"" + "alt=\"coffe cup\" height=\"150px\" />");

        setTimeout(() => coffeePopup.showPopup(), 3000);
    }

    clickedCount = 0;
    // Reenable the coffee button after 3 seconds
    setTimeout((element) => {
        element.textContent = "Click for coffee";
        element.disabled = false;
    }, 3000, x);

}