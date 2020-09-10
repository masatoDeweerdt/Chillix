

const myNav = document.getElementById("navigation");


window.onscroll = function () {
    const top = window.scrollY;

    if (top > 100) {
        myNav.classList.add("active");
    }
    else {
        myNav.classList.remove("active");
    }
};
// minimize the jumbotron panel
setTimeout(function () {
    const titleDiminuer = document.getElementById('title');
    titleDiminuer.classList.add("title-scale");
}, 4500)

// remove the jumbotron panel

setTimeout(() => {
    const titleDiminuer = document.getElementById('title');
    titleDiminuer.classList.add("d-none");
    titleDiminuer.classList.remove("d-flex");
}, 10000);

// open the comment section

const comment = document.getElementById('open-comment');

comment.addEventListener('click', () => {
    document.getElementById('comment').classList.toggle('d-none');
    window.scrollTo(0, 400);
})

// drop the movie genre list on click
document.getElementById('drop').addEventListener('click', function () {
    document.getElementById('drop-list').classList.toggle('d-none');
})

// suggest movie match from search bar
function getMovie(str) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            document.getElementById("movie-hint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "assets/includes/suggestmovie.php?request=" + str, true);
    xmlhttp.send();
}


function filterMovie(str) {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            document.getElementById("filter-test").innerHTML = this.responseText;
        }
    };
    xml.open("GET", "assets/includes/filtermovie.php?request=" + str, true);
    xml.send();
}