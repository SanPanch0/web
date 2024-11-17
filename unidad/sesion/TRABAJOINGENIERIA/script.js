function loadContent(page, cssFile, jsFile) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            document.getElementById("content-area").innerHTML = data;

            document.querySelectorAll(".dynamic-css, .dynamic-js").forEach(el => el.remove());

            const link = document.createElement("link");
            link.rel = "stylesheet";
            link.href = cssFile;
            link.classList.add("dynamic-css");
            document.head.appendChild(link);

            const script = document.createElement("script");
            script.src = jsFile;
            script.classList.add("dynamic-js");
            document.body.appendChild(script);
        })
        .catch(error => console.log('Error:', error));
}

document.querySelectorAll(".sidebar ul li").forEach((item) => {
    item.addEventListener("click", function (e) {
        const submenu = this.querySelector(".submenu");
        
        if (submenu) {
            e.stopPropagation();
            this.classList.toggle("active");
        }
    });
});
