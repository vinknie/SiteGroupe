// FUNCTION CLICK ON MENU  (REPONSIVE)

$(document).ready(function () {
    $(".menu-icon").on("click", function () {
        $("nav ul").toggleClass("showing");
    });
});

// SCROLLING EFFECT WHEN SCROLL DOWN 

$(window).on("scroll", function () {
    if ($(window).scrollTop() > 150) {
        $('nav').addClass('black');
    }

    else {
        $('nav').removeClass('black');
    }
})


// ROTATION DES CARTES ARTICLES 
var card = document.querySelector('.card');
card.addEventListener('click', function () {
    card.classList.toggle('is-flipped');
});

var card1 = document.querySelector('.card1');
card1.addEventListener('click', function () {
    card1.classList.toggle('is-flipped');
});

var card2 = document.querySelector('.card2');
card2.addEventListener('click', function () {
    card2.classList.toggle('is-flipped');
});
