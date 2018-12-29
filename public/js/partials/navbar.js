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

// search handler

$("#searchAuthorsField").on("input", function(){
    
    // set list to display none if there's nothing in search field
    document.getElementById('nav__search').style.display = "none";
    
    // values
    var authorList = document.getElementById('nav__search--authors');
    var query = $("#searchAuthorsField").val();

    // more than or 0 letters
    if(query.length > 0) {

        // if length is more than 0, we want to show the search field
        document.getElementById('nav__search').style.display = "block";

        // get request to search for authors
        $.get(baseUrl + 'search/authors/' + query, function(data) {
            // clear list before we add new authors so we don't get multiple same inserts
            authorList.innerHTML = "";
            
            console.log(data.data);

            if(data.data !== undefined && data.data.length > 0) {
                data.data.forEach(function(user) {  
                    // append user with html
                    authorList.innerHTML = authorList.innerHTML + '<a href="' + appURL + 'author/' + user.username + '"\> <div class="nav__search--entry"\><div class="nav__search--image" style="background-image: url(' + appURL + '/img/avatars/' + user.avatar + ')"></div\><div class="nav__search--name">' + user.first_name + ' ' + user.last_name + '</div\></div\></a>';
                });
                document.getElementById('nav__search--results').innerHTML = data.data.length;
            } else {
                authorList.innerHTML = authorList.innerHTML + '<p style="word-break: break-word; padding: .5rem;">' + data.messages + '</p>';
                document.getElementById('nav__search--results').innerHTML = 0;
            }
        });

    }
});