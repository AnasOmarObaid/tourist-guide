// live preview
$(document).ready(function () {
  // live image preview
  $("#city_image").on("change", function (e) {
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
  $("#name").on("input", function () {
    $("#name_preview").text($(this).val() || "");
  });

  // live country preview
  $("#country").on("input", function () {
    $("#country_preview").text($(this).val() || "");
  });

  // live description preview
  $("#description").on("input", function () {
    $("#description_preview").text($(this).val() || "");
  });

  // live Latitude preview
  $("#latitude").on("input", function () {
    $("#latitude_preview").text($(this).val() || "");
  });

  // live Longitude preview
  $("#longitude").on("input", function () {
    $("#longitude_preview").text($(this).val() || "");
  });

  // Status checkbox
  $('input[name="status"]').on("change", function () {
    // Toggle the checkbox value
    $(this).data("value", $(this).is(":checked") ? "1" : "0");

    // Update the preview status class to set or remove bg-success or bg-danger
    if ($(this).data("value") == "1") {
      $("#previewStatus").text("Available City");
      $("#previewStatus").removeClass("bg-danger").addClass("bg-success");
    } else {
      $("#previewStatus").text("Unavailable City");
      $("#previewStatus").removeClass("bg-success").addClass("bg-danger");
    }
  });
});

// city grid filters
$(document).ready(function () {
  function updateActiveChips(query, status) {
    var $chips = $("#cityActiveFilters");
    $chips.empty();

    if (query) {
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="search" title="Clear search">${query} <i class="bi bi-x ms-1"></i></button>`);
    }
    if (status && status !== "all") {
      var text = status.charAt(0).toUpperCase() + status.slice(1);
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="status" title="Clear status">${text} <i class="bi bi-x ms-1"></i></button>`);
    }
  }

  function filterCities() {
    var query = ($.trim($("#citySearch").val() || "")).toLowerCase();
    var status = ($('input[name="cityStatusFilter"]:checked').val() || "all");

    var $cards = $(".cities .tr");

    $cards.each(function () {
      var name = (($(this).data("city-name")) || "").toString().toLowerCase();
      var cityStatus = (($(this).data("city-status")) || "").toString();

      var nameMatch = !query || name.indexOf(query) !== -1;
      var statusMatch = status === "all" || cityStatus === status;

      $(this).toggle(nameMatch && statusMatch);
    });

    var total = $cards.length;
    var visible = $cards.filter(":visible").length;
    $("#cityResultsCount").text(`Showing ${visible} of ${total}`);

    // No results toggle
    if (visible === 0) {
      $("#cityNoResults").removeClass("d-none");
    } else {
      $("#cityNoResults").addClass("d-none");
    }

    // Update chips
    updateActiveChips($("#citySearch").val(), status);
  }

  // Events
  $("#citySearch").on("input", filterCities);
  $(document).on("change", 'input[name="cityStatusFilter"]', filterCities);
  $("#resetCityFilters").on("click", function () {
    $("#citySearch").val("");
    $("#statusAll").prop("checked", true).trigger("change");
    filterCities();
  });
  $(document).on("click", "#clearFiltersBtn", function () {
    $("#citySearch").val("");
    $("#statusAll").prop("checked", true).trigger("change");
    filterCities();
  });
  $(document).on("click", "#cityActiveFilters .chip-clear", function () {
    var type = $(this).data("chip");
    if (type === "search") {
      $("#citySearch").val("");
    }
    if (type === "status") {
      $("#statusAll").prop("checked", true).trigger("change");
    }
    filterCities();
  });

  // Initialize on load
  filterCities();
});

// show hotels and events
$(document).ready(function () {
  $(".view-city-btn").on("click", function (e) {
    e.preventDefault();
    var cityId = $(this).data("city-id");
    $("#cityPreviewContent").html(
      '<div class="text-center my-5"><div class="spinner-border"></div></div>'
    );
    $("#cityPreviewModal").modal("show");
    $.ajax({
      url: $(this).data("url"),

      method: "GET",

      success: function (data) {
        var html =
          '<h4>Hotels</h4><div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">';

        $.each(data.hotels, function (i, hotel) {
          // Rating stars
          var stars = "";
          for (var s = 1; s <= 5; s++) {
            stars += `<i class="bi ${
              s <= hotel.rate ? "bi-star-fill" : "bi-star"
            }"></i>`;
          }

          // Tags
          var tags = "";
          if (hotel.tags && hotel.tags.length) {
            hotel.tags.forEach(function (tag) {
              tags += `<span class="badge bg-primary rounded-pill me-1">${tag.name}</span>`;
            });
          }

          // Services
          var services = "";
          if (hotel.services && hotel.services.length) {
            hotel.services.forEach(function (service) {
              services += `<span class="badge bg-light text-dark border me-1 cu-rounded">
                                        <i class="bi bi-check-circle-fill text-success cu-rounded"></i>
                                        ${service.name}
                                        </span>`;
            });
          }

          html += `
                                    <div class="col-md-4 tr">
                                                      <div class="card shadow-lg border-0 cu-rounded overflow-hidden h-100">

                                                            <img src="${
                                                              hotel.cover_url
                                                            }" class="card-img-top"
                                                                  style="height:200px; object-fit:cover;"
                                                                  alt="${
                                                                    hotel.name
                                                                  }">

                                                            <div class="card-body d-flex flex-column">

                                                                  <div
                                                                        class="d-flex justify-content-between align-items-baseline">
                                                                        <h5 class="card-title mb-1">${
                                                                          hotel.name
                                                                        }
                                                                        </h5>
                                                                        <small style="font-size: .65rem; padding: 0.35rem 0.55rem;"
                                                                              class="status-badge ${
                                                                                hotel.status
                                                                                  ? `status-badge-success`
                                                                                  : `status-badge-danger`
                                                                              }">
                                                                              ${
                                                                                hotel.status
                                                                                  ? `Active`
                                                                                  : `Cancelled`
                                                                              }
                                                                        </small>
                                                                  </div>
                                                                  <small class="text-muted">Owned by
                                                                         ${
                                                                           hotel.owner
                                                                         } </small>

                                                                  <p class="mt-2 mb-1"><i
                                                                              class="bi bi-geo-alt-fill text-danger"></i>
                                                                        ${
                                                                          (hotel.city &&
                                                                          hotel
                                                                            .city
                                                                            .name
                                                                            ? hotel
                                                                                .city
                                                                                .name +
                                                                              ", "
                                                                            : "") +
                                                                          hotel.venue
                                                                        }
                                                                  </p>

                                                                  <div
                                                                        class="d-flex justify-content-between align-items-center mb-3">
                                                                        <span class="fw-bold text-success">${
                                                                          hotel.price_per_night
                                                                        }
                                                                              <small>/night</small></span>
                                                                        <span class="text-warning">
                                                                            ${stars}
                                                                        </span>
                                                                  </div>

                                                                  <div class="mb-2">
                                                                        ${tags}
                                                                  </div>

                                                                  <div class="mb-3">
                                                                        ${services}
                                                                  </div>

                                                                  <div class="mb-2">
                                                                        <small class="text-muted">
                                                                               ${
                                                                                 hotel.description
                                                                               }
                                                                        </small>
                                                                  </div>

                                                                  <div
                                                                        class="d-flex justify-content-between align-items-center mt-auto">
                                                                        <span class="text-muted"><i
                                                                                    class="bi bi-people-fill"></i>
                                                                              ${
                                                                                typeof hotel.bookings_count !==
                                                                                "undefined"
                                                                                  ? hotel.bookings_count
                                                                                  : 0
                                                                              } Guests
                                                                              Booked</span>
                                                                  </div>
                                                            </div>

                                                      </div>
                                    </div>
                            `;
        });

        html +=
          '</div><hr><h4>Events</h4><div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 g-4">';

        $.each(data.events, function (i, event) {
          // Build attendees images stack
          var attendees = "";
          if (event.attendees_images && event.attendees_images.length) {
            event.attendees_images.forEach(function (imgPath) {
              attendees += `<img src="${
                imgPath.startsWith("http")
                  ? imgPath
                  : "${location.origin}/" + imgPath
              }" alt="User">`;
            });
          }

          // Tags
          var eventTags = "";
          if (event.tags && event.tags.length) {
            event.tags.forEach(function (tag) {
              eventTags += `<span class="tag-badge">${tag.name}</span>`;
            });
          }

          // Date status class mapping
          var dateStatusClass = "status-badge-secondary";
          switch (String(event.event_date_status).toUpperCase()) {
            case "UPCOMING":
              dateStatusClass = "status-badge-success-e";
              break;
            case "ONGOING":
              dateStatusClass = "status-badge-primary";
              break;
            case "EXPIRED":
              dateStatusClass = "status-badge-danger";
              break;
            default:
              dateStatusClass = "status-badge-secondary";
          }

          html += `
                                <div class="col-lg-4 col-md-12 tr">
                                    <div class="card event-card h-100">

                                        <div class="event-image">
                                            <img src="${
                                              event.image_url
                                            }" alt="Event">
                                            <div class="attendees users-stack">
                                                ${attendees}
                                            </div>
                                        </div>

                                        <div class="event-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="price-tag">$${
                                                  event.price ?? 0
                                                }</div>
                                                <p class="status-badge ${
                                                  event.status
                                                    ? "status-badge-success"
                                                    : "status-badge-danger"
                                                }">
                                                    ${
                                                      event.status
                                                        ? "Active"
                                                        : "Cancelled"
                                                    }
                                                </p>
                                            </div>
                                            <h5 class="card-title">${
                                              event.title
                                            }</h5>
                                            <div class="d-flex align-items-center">
                                                <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-danger"></i>
                                                    ${
                                                      (event.city &&
                                                      event.city.name
                                                        ? event.city.name + ", "
                                                        : "") +
                                                      (event.venue ?? "")
                                                    }
                                                </p>
                                                <span class="text-success mb-1" style="margin-left: .5rem; cursor:pointer"> +${
                                                  typeof event.tickets_count !==
                                                  "undefined"
                                                    ? event.tickets_count
                                                    : 0
                                                } ticket</span>
                                            </div>
                                            <p class="text-secondary mt-1">${
                                              event.description ?? ""
                                            }</p>
                                            <div>
                                                ${eventTags}
                                                <div class="details mt-3"><span>👤</span> ${
                                                  event.organizer ?? ""
                                                }</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="date">
                                                        <div class="details text-success mt-3"><span>📅</span> Start: ${
                                                          event.formatted_created_at ??
                                                          ""
                                                        }</div>
                                                        <div class="details text-danger"><span>📅</span> End: ${
                                                          event.formatted_end_at ??
                                                          ""
                                                        }</div>
                                                    </div>
                                                    <div class="dateStatus">
                                                        <p class="px-2 status-badge d-inline ${dateStatusClass}"> ${
            event.event_date_status
          } Event</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                `;
        });

        html += "</div>";
        $("#cityPreviewContent").html(html);
      },
      error: function () {
        $("#cityPreviewContent").html(
          '<div class="alert alert-danger">Failed to load data.</div>'
        );
      },
    });
  });
});
