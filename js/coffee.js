// Functions for when the "click for coffee" button is clicked

let clickedCount = 0;
let currentCoffeeCounter = 0;

// Show all the coffee popups after 3 seconds
document.getElementById("coffee-button").onclick = function coffeeClicked() {
    if (clickedCount === 0) {
        setTimeout(afterCoffeeClick, 3000);
    }
    clickedCount++;
};

function afterCoffeeClick() {
    const x = document.getElementById("coffee-button");
    x.disabled = true;
    x.textContent = `Enjoy your ${clickedCount} cofees`;

    for (let i = 0; i < clickedCount; ++i) {
        let popupContent = document.createElement("div");
        popupContent.classList.add("popup-content");

        let coffeeImg = document.createElement("img");
        coffeeImg.src = "images/coffee.png";
        coffeeImg.alt = "coffe cup";
        coffeeImg.style.position = "absolute";
        coffeeImg.style.top = "50%";
        coffeeImg.style.left = "50%";
        coffeeImg.style.transform = "translate(-50%, -50%)";

        let coffeeDescription = document.createElement("h1");
        coffeeDescription.textContent = `Enjoy coffee number ${clickedCount - currentCoffeeCounter++}!`;

        popupContent.append(coffeeDescription, coffeeImg);
        let coffeePopup = new PopupContainer(popupContent);

        coffeePopup.showPopup();
    }

    clickedCount = 0;
    // Reenable the coffee button after 3 seconds
    setTimeout((element) => {
        element.textContent = "Click for coffee";
        element.disabled = false;
        currentCoffeeCounter = 0;
    }, 3000, x);
}
