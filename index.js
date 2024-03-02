let clickedCount = 0;
function coffeeClicked() {
    if (clickedCount === 0) {
        setTimeout(coffeeClickDisable, 300);
    }
    clickedCount++;
}

function coffeeClickDisable() {
    var x = document.getElementById("coffeeButton");
    x.disabled = true;
    x.textContent = clickedCount;
    clickedCount = 0;
    let coffeePNG = document.createElement("img");
    coffeePNG.setAttribute("src", "https://purepng.com/public/uploads/large/purepng.com-cup-mug-coffeecupmugcoffeebean-1411527406463ir9fq.png")
    coffeePNG.setAttribute("height", "30px");
    x.parentNode.appendChild(coffeePNG)
}