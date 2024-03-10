const submitButton = document.getElementById("submit-main-input");
const mainInput = document.getElementById("main-input");

function handleInput() {
    const input = mainInput.value;

    // If the input is null or is an empty string, do nothing
    if (!input || input.length === 0) return;

    const inputBubble = document.createElement("p");
    inputBubble.className = "user-sent in-out-bubble";
    inputBubble.textContent = input;

    document.getElementById("inputs-outputs-container").appendChild(inputBubble);

    mainInput.value = "";
}

// Should only happen when the enter button is pressed while typing
document.getElementById("main-input").onkeydown = function(key) {
    // If the key pressed was the enter key
    if (key.code == "Enter") {
        handleInput();
    }
}

