document.addEventListener("DOMContentLoaded", function () {

    var button = document.querySelector(".menu-btn");
    button.addEventListener('click', function (event) {
        this.classList.toggle("change")
        console.log("WORKS");
        var doc = document.querySelector(".menu");

        if (doc.style.display === 'block') {

            doc.style.display = 'none';
        }
        else {
            doc.style.display = 'block';
            doc.style.animation = 'show 0.6s linear';
        }
        console.log(doc);


    });


});

