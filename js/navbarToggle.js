$("#navbar-toggle").click(function(){

    var div = document.getElementById("navbar-conn");
    if (div.className === "navbar-conn") {
      div.className += "-responsive";
    } else {
      div.className = "navbar-conn";
    }
});

