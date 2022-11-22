document.addEventListener("DOMContentLoaded", function () {
    /**
     * Show and style the title.
     */
    const consoleTitle = [
        "font-weight: bold;",
        "font-size: 50px;",
        "color: rgb(255, 0, 0);",
        "text-shadow: 3px 3px 0 rgb(0, 0, 0)",
    ].join(";");
    console.log("%cHey ‼", consoleTitle);

    /**
     * Show and style the text.
     */
    const consoleText = [
        "font-weight: bold;",
        "font-size: 18px;",
        "color: rgb(255, 255, 255);",
    ].join(";");
    console.log("%cI'm watching you...", consoleText);
});
