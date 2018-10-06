var usernavbutton = document.getElementById("nav__user");
var usernavmenu = document.getElementById("user__nav");

function showmenu() {
    if(usernavmenu.classList.contains("show")) {
        usernavmenu.classList.remove("show");
    } else {
        usernavmenu.classList.add("show");
    }
}

usernavbutton.addEventListener("click", showmenu);