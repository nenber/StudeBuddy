$(document).ready(function () {
    $('.multiselect-select2').select2({
        maximumSelectionLength: 3,
        language: {
// You can find all of the options in the language files provided in the
// build. They all must be functions that return the string that should be
// displayed.
            maximumSelected: function (e) {
                var t = "You can only select " + e.maximum + " item";
                e.maximum != 1 && (t += "s");
                return "Vous ne pouvez selectionner que 3 langues";
            }
        }
    });
    $("#uploadImageButton").change(function () {
        $("#message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $("#file").css("color", "red");
            $('#previewimg').attr('src', "{{ asset('build / images / profil.png') }}");
            $("#message").html("<p class='error'>Please select a valid image file, Only jpeg, jpg and png Images type allowed</p>");
            return false;
        } else {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            console.log(reader);
// for validate image size
            var limit = 2097152; // 2MB ==> 1048576 bytes = 1MB;
            if (this.files[0].size > limit) {
                $("#message").html('<p class="warning">Image size is large, max size 2MB!</p>');
                $("#uploadImageButton").css("color", "red");
            }
        }
    });

    function imageIsLoaded(e) {
        $("#uploadImageButton").css("color", "green");
        $('#image_preview').css("display", "block");
        $('#previewimg').attr('src', e.target.result);
        $('#pi').attr('src', e.target.result);
        let userEmail = '{{ app.user.email }}'
        $.ajax({
            type: "POST",
            url: "{{ path('user_upload-profile-image') }}",
            data: {
                image: e.target.result,
                email: userEmail
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            }
        });
    };
});