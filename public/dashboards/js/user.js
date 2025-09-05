
$(document).ready(function () {
    // live image preview
    $('#user_image').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // live name preview
    $("#full_name").on('input', function () {
        $('#name_preview').text($(this).val() || "");
    });

    // live email preview
    $("#email").on('input', function () {
        $('#email_preview').text($(this).val() || "");
    });

    // live password preview
    $("#password").on('input', function () {
        $('#password_preview').text($(this).val() || "");
    });

    // phone number preview
    $("#phone").on('input', function () {
        $('#phone_preview').text($(this).val() || "");
    });

    // phone number preview
    $("#address").on('input', function () {
        $('#address_preview').text($(this).val() || "");
    });

    // Status checkbox
    $('input[name="email_verified_at"]').on('change', function () {

        // Toggle the checkbox value
        $(this).data('value', $(this).is(':checked') ? '1' : '0');

        // Update the preview status class to set or remove bg-success or bg-danger
        if ($(this).data('value') == '1') {
            $('#previewStatus').text("Verify Email");
            $('#previewStatus').removeClass('bg-danger').addClass('bg-success');
        } else {
            $('#previewStatus').text("Not verify email");
            $('#previewStatus').removeClass('bg-success').addClass('bg-danger');
        }

    });
});

