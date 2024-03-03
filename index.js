let clickedCount = 0;
function coffeeClicked() {
    if (clickedCount === 0) {
        setTimeout(coffeeClickDisable, 3000);
    }
    clickedCount++;
}
// TODO: Polish the positioning bit, cleanup
function coffeeClickDisable() {
    const x = document.getElementById("coffeeButton");
    x.disabled = true;
    x.textContent = `Enjoy your ${clickedCount} cofees`;

    for (let i = 0; i < clickedCount; ++i) {
        let coffeePNG = document.createElement("div");
        coffeePNG.innerHTML =
            "<img src=\"https://purepng.com/public/uploads/large/purepng.com-cup-mug-coffeecupmugcoffeebean-1411527406463ir9fq.png\"" +
            "alt=\"coffe cup\" height=\"150px\" />";
        coffeePNG.className = "coffee-png";
        coffeePNG.style.position = "absolute";
        coffeePNG.style.transition = "all ease-in-out 1s";
        // Random positions
        coffeePNG.style.left = `${Math.floor(Math.random() * (document.body.clientWidth - 250))}px`;
        coffeePNG.style.top = `${Math.floor(Math.random() * (document.body.clientHeight - 300))}px`;
        console.log(`Top:${coffeePNG.style.top}\nLeft:${coffeePNG.style.left}`);
        document.body.appendChild(coffeePNG);

        // Fade out the images after 3s then delete the elements after 1s
        setTimeout((element) => {
            element.style.opacity = "0";
            setTimeout((i) => i.remove(), 1200, element);
        }, 3000, coffeePNG);
    }

    clickedCount = 0;
    setTimeout((element) => {
        element.textContent = "Click for coffee";
        element.disabled = false;
    }, 3000, x);

}

function coffeeClickReenable() {

}