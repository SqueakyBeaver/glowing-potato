// File to house functions that will create popups
window.addEventListener("load", () => {
    let popupOrigins = document.getElementsByClassName("popup-origin");

    for(let i of popupOrigins) {
        // First we have to make an array copy of the children in order to filter it
        let children = Array.from(i.children);

        // Should return an array of length 1 unless I mess something up in the HTML
        let content = children.filter((i) => i.classList.contains("popup-content"));

        if (content.length === 0) {
            console.error(`Empty content (${i.textContent})`);
            continue;
        }

        if (content.length > 1)
            console.error(`Wrong popup children (${i.textContent})`);

        let popup = new PopupContainer(content[0]);

        i.onclick = () => { popup.showPopup(); };
    }
});