$(document).ready(function () {
    // live image preview
    $("#user_image").on("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#previewImage").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // live name preview
    $("#full_name").on("input", function () {
        $("#name_preview").text($(this).val() || "");
    });

    // live email preview
    $("#email").on("input", function () {
        $("#email_preview").text($(this).val() || "");
    });

    // live password preview
    $("#password").on("input", function () {
        $("#password_preview").text($(this).val() || "");
    });

    // phone number preview
    $("#phone").on("input", function () {
        $("#phone_preview").text($(this).val() || "");
    });

    // phone number preview
    $("#address").on("input", function () {
        $("#address_preview").text($(this).val() || "");
    });

    // Status checkbox
    $('input[name="email_verified_at"]').on("change", function () {
        // Toggle the checkbox value
        $(this).data("value", $(this).is(":checked") ? "1" : "0");

        // Update the preview status class to set or remove bg-success or bg-danger
        if ($(this).data("value") == "1") {
            $("#previewStatus").text("Verify Email");
            $("#previewStatus").removeClass("bg-danger").addClass("bg-success");
        } else {
            $("#previewStatus").text("Not verify email");
            $("#previewStatus").removeClass("bg-success").addClass("bg-danger");
        }
    });

    // user table
    $("#userTable")
        .DataTable({
            responsive: true,
            autoWidth: true,
            columnDefs: [
                {
                    targets: "no-sort",
                    orderable: false,
                    order: [],
                },
            ],
            buttons: ["copy", "excel", "pdf", "csv", "colvis"],
        })
        .buttons()
        .container()
        .appendTo("#userTable_wrapperButton");

    // View user tickets and bookings (enhanced UI)
    $(document).on('click', '.view-user-btn', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('#userPreviewContent').html('<div class="text-center my-5"><div class="spinner-border"></div></div>');
        $('#userPreviewModal').modal('show');

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                let html = '';

                // Tickets Section (enhanced like ticket/index)
                html += '<h4>Tickets</h4><div class="row row-cols-1 row-cols-md-2 g-3">';
                if (data.tickets && data.tickets.length) {
                    data.tickets.forEach(function (t) {
                        const ev = t.event || {};
                        const title = ev.title || '';
                        const city = ev.city || '';
                        const image = ev.image_url || '';
                        const status = t.status || '';
                        const statusClass = status === 'valid' ? 'bg-success' : (status === 'used' ? 'bg-warning' : 'bg-danger');
                        const price = (parseFloat(t.total_price || 0)).toFixed(2);
                        html += `
                          <div class="col">
                            <div class="card ticket-card shadow-lg border-0 cu-rounded overflow-hidden h-100">
                              <div class="ticket-header position-relative">
                                <img src="${image}" class="img-fluid w-100" style="height:200px; object-fit:cover;" alt="Event">
                                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
                                <div class="ticket-title position-absolute bottom-0 start-0 p-3 text-white">
                                  <small class="mb-0 d-block">${title}</small>
                                  <small><i class="bi bi-geo-alt-fill text-danger"></i> ${city}</small>
                                </div>
                              </div>
                              <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                  <div><small class="text-muted">Order: <code>${t.order_number || ''}</code></small></div>
                                  <span class="badge ${statusClass}">${status ? (status.charAt(0).toUpperCase() + status.slice(1)) : ''}</span>
                                </div>
                                <div class="row text-muted mb-2">
                                  <div class="col-6"><small>Date</small><div class="fw-semibold">${t.formatted_created_at || ''}</div></div>
                                  <div class="col-6 text-end"><small>Barcode</small><div class="fw-semibold">${t.barcode || ''}</div></div>
                                </div>
                                <div class="text-end fw-bold">$${price}</div>
                              </div>
                            </div>
                          </div>`;
                    });
                } else {
                    html += '<div class="col"><div class="alert alert-danger border">No tickets found.</div></div>';
                }
                html += '</div><hr/>';

                // Bookings Section (hotel image cu-rounded)
                html += '<h4>Bookings</h4><div class="row row-cols-1 row-cols-md-2 g-3">';
                if (data.bookings && data.bookings.length) {
                    data.bookings.forEach(function (b) {
                        const hotel = b.hotel || {};
                        const name = hotel.name || '';
                        const cover = hotel.cover_url || '';
                        const city = hotel.city || '';
                        const status = b.status || '';
                        const statusClass = status === 'confirmed' ? 'bg-success' : (status === 'pending' ? 'bg-warning' : 'bg-danger');
                        const price = (parseFloat(b.total_price || 0)).toFixed(2);
                        html += `
                          <div class="col">
                            <div class="card h-100 cu-rounded overflow-hidden shadow-sm">
                              <img src="${cover}" class="img-fluid w-100" style="height:160px; object-fit:cover;" />
                              <div class="card-body">
                                <div class="fw-semibold">${name}</div>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> ${city}</small>
                                <div class="d-flex justify-content-between mt-2">
                                  <small class="text-success"><i class="bi bi-calendar-check"></i> ${b.formatted_check_in || ''}</small>
                                  <small class="text-danger"><i class="bi bi-calendar-x"></i> ${b.formatted_check_out || ''}</small>
                                </div>
                                <div class="mt-2"><small class="text-muted">Order: <code>${b.order_number || ''}</code></small></div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                  <span class="badge ${statusClass}">${status ? (status.charAt(0).toUpperCase() + status.slice(1)) : ''}</span>
                                  <span class="fw-bold">$${price}</span>
                                </div>
                              </div>
                            </div>
                          </div>`;
                    });
                } else {
                    html += '<div class="col-12"><div class="alert alert-danger border">No bookings found.</div></div>';
                }
                html += '</div>';

                $('#userPreviewContent').html(html);
            },
            error: function () {
                $('#userPreviewContent').html('<div class="alert alert-danger">Failed to load user data.</div>');
            }
        });
    });

});

