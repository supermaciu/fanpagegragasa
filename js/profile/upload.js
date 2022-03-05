var reset_picture = false;
setCookie("reset_picture", reset_picture, 1);

$(document).ready(() => {
    $("#reset_picture").click(() => {
        $(".profile-picture").attr("src", "images/avatar/placeholder.jpg");
        reset_picture = true;
        setCookie("reset_picture", reset_picture, 1);
    });
});

function previewImage(input){
    let uploadedImage = $("input[type=file]").get(0).files[0];

    if (uploadedImage) {
        let reader = new FileReader();

        reader.onload = function(){
            $(".profile-picture").attr("src", reader.result);

            reset_picture = false;
            setCookie("reset_picture", reset_picture, 1);
        }

        reader.readAsDataURL(uploadedImage);
    }
}

function setCookie(name, value, days) {
    var expires;
      
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
      
    document.cookie = escape(name) + "=" + 
        escape(value) + expires + "; path=/";
}