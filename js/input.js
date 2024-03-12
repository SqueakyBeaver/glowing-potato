const submitButton = document.getElementById("submit-main-input");
const mainInput = document.getElementById("main-input");

function handleInput() {
    const input = mainInput.value;

    // If the input is null or is an empty string, do nothing
    if (!input || input.length === 0) return;

    const inputBubble = document.createElement("p");
    inputBubble.classList.add("user-sent", "in-out-bubble", "dynamic-input");
    inputBubble.textContent = input;

    let inOutContainer = document.getElementById("inputs-outputs-container");
    inOutContainer.appendChild(inputBubble).scrollIntoView();

    mainInput.value = "";

    if (input.toLowerCase().includes("giraffe")) {
        const resultBubble = document.createElement("div");
        resultBubble.classList.add("in-out-bubble", "server-sent", "dynamic-input");

        const congratsText = document.createElement("p");
        congratsText.textContent = "Congratulations! You guessed correctly! (The answer was giraffe)";

        const resultImg = document.createElement("img");
        resultImg.src = "images/giraffe-dancing.gif";
        resultImg.alt = "A giraffe dancing";

        resultBubble.append(congratsText, resultImg);
        inOutContainer.appendChild(resultBubble).scrollIntoView();
    }

    if (input.toLowerCase() === "clear") {
        // Unless we copy this to an array, removing elements will mess everything up
        let toClear = Array.from(inOutContainer.getElementsByClassName("dynamic-input"));
        for (let i of toClear) {
            i.remove();
            console.log(i);
        }
    }
}

// Should only happen when the enter button is pressed while typing
document.getElementById("main-input").onkeydown = function (key) {
    // If the key pressed was the enter key
    if (key.code == "Enter") {
        handleInput();
    }
}

