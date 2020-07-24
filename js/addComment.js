$(document).ready(function() {
    $("#commentForm").on("submit", function(event) {
        event.preventDefault();
        // var formData = stringify($(this));
        let comment = $("#commentContent").val();
        let pseudo = $("#pseudo").val();
        let imageId = $("#imageId").val();
        console.log(comment, pseudo);
        $.ajax({
            url: "postComment.php",
            method: "POST",
            data: { pseudo, comment, imageId },
            dataType: "JSON",
            success: function(data) {
                if (data.error != "") {
                    $("#commentForm")[0].reset();
                    $("#errorMessage").html(data.error);
                    $("#commentId").val("0");
                    loadComment();
                }
                // console.log(formData);
            }
        });
    });

    // function $_GET(param) {
    //     var vars = {};
    //     window.location.href.replace( location.hash, '' ).replace(
    //         /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
    //         function( m, key, value ) { // callback
    //             vars[key] = value !== undefined ? value : '';
    //         }
    //     );

    //     if ( param ) {
    //         return vars[param] ? vars[param] : null;
    //     }
    //     return vars;
    // }

    function loadComment() {
        let imageId = $("#imageId").val();
        $.ajax({
            url: "fetchComment.php",
            method: "POST",
            data: { imageId },
            dataType: "JSON",
            success: function(data) {
                $(".artComment").html(data.id);
                console.log(data);
            }
        });
    }
});
