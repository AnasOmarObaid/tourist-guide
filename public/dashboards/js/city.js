
$(document).ready(function () {
    // live image preview
    $('#city_image').on('change', function (e) {
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
    $("#name").on('input', function () {
        $('#name_preview').text($(this).val() || "");
    });

    // live country preview
    $("#country").on('input', function () {
        $('#country_preview').text($(this).val() || "");
    });

    // live description preview
    $("#description").on('input', function () {
        $('#description_preview').text($(this).val() || "");
    });

    // live Latitude preview
    $("#latitude").on('input', function () {
        $('#latitude_preview').text($(this).val() || "");
    });

    // live Longitude preview
    $("#longitude").on('input', function () {
        $('#longitude_preview').text($(this).val() || "");
    });

    // Status checkbox
    $('input[name="status"]').on('change', function () {

        // Toggle the checkbox value
        $(this).data('value', $(this).is(':checked') ? '1' : '0');

        // Update the preview status class to set or remove bg-success or bg-danger
        if ($(this).data('value') == '1') {
            $('#previewStatus').text("Available City");
            $('#previewStatus').removeClass('bg-danger').addClass('bg-success');
        } else {
            $('#previewStatus').text("Unavailable City");
            $('#previewStatus').removeClass('bg-success').addClass('bg-danger');
        }

    });
});

