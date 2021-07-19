var niceRegex = false;
$(document).ready(function () {
    var emailRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})^");


    $('#inputMdp').keyup(function () {
        console.log($("#inputMdp").val())

        if ($("#inputMdp").val().match(emailRegex)) {
            console.log("good");
            $(".p-email").css("display", "none")
        } else {
            $(".p-email").css("display", "block")
        }
    });

    /*
    $("#confirmReset").click(function () {
    if (!$('#inputMdp').val().match(emailRegex)) {
    $("#messageError").text("Le nouveau mot de passe ne respect pas le bon format");
    } else if ($('#inputMdp').val() != $('#inputConfirmMdp').val()) {


    $("#messageError").text("Les deux mots de passe ne correspondent pas");

    } else {
    $("#messageError").text("");


    console.log("test")
    $("#confirmform").validate();

    }


    });
    */

});