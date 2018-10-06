var button = document.getElementById("modalbutton");
var modal = document.getElementById("modal");
var modalbackground = document.getElementById("modalbackground");
var modalcontent = document.getElementById("modalcontent");
var modalclose = document.getElementById("modalclose");
var modalfullscreen = document.getElementById("modalfullscreen");

function openModal() {
    if(modal.classList.contains("show")) {
        modal.classList.remove("show");
    } else {
        modal.classList.add("show");
    }

    // add style width so fullscreen button works
    modalcontent.style.width = "75%";
    modalcontent.style.height = "75%";
    document.body.style.overflow = "hidden";
}

function closeModal() {
    modal.classList.remove("show");
    document.body.style.overflow = "auto";
}

function fullscreen() {
    if(modalcontent.style.width == "75%") {
        modalcontent.style.width = "100%";
        modalcontent.style.height = "100%";
        modalcontent.style.padding = "4rem";
    } else if (modalcontent.style.width == "100%") {
        modalcontent.style.width = "75%";
        modalcontent.style.height = "75%";
    }

}

modalfullscreen.addEventListener("click", fullscreen);
modalclose.addEventListener("click", closeModal);
modalbackground.addEventListener("click", closeModal);
button.addEventListener("click", openModal);