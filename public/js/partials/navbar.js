

var navbar__button = document.getElementById('navbar__button');
var navbar = document.getElementById('navbar');

navbar__button.onclick = function() {
    navbar.className = 'navbar';
}

window.onclick = function(event) {
    if(event.target == navbar) {
        navbar.className = 'navbar hidden';
    }
}
/*

Removed due to bad user experience. Would open menu while writing an articool.
Needs improvement before bringing back this feature.

$(window).keydown(function(event) {
    
    // if user presses anything close to an input, dismiss it
    if ($(event.target).closest("input")[0]) {
        return;
    }

    // if user press "m", show navbar
    if(event.keyCode == 77) {
        navbar.className = 'navbar';
    }
    
    // if user press "escape", remove navbar
	if(event.keyCode == 27) {
        navbar.className = 'navbar hidden';
    }
});
*/