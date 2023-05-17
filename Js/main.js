const cancel = document.querySelector("#cancel")
// const bars = document.querySelector(".bar")
const side_bar = document.querySelector(".left-side");
let bars = document.getElementById("barsContent")
console.log(bars);
bars.addEventListener("click", function () {
    side_bar.style.left= "0";
})
cancel.addEventListener("click", function () {
    side_bar.style.left = "-100%";
})

/* buttoun up */
let up = document.getElementById("up");
window.onscroll = function scr() {
    if (window.scrollY > 200) {
        up.style = "display:block";
    }
    else {
        up.style = "display:none";
    }
}
up.onclick = function () {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth",
    });
}