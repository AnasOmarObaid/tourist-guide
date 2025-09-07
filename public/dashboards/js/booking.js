// bookings grid filters
$(document).ready(function () {
  function updateActiveChips(query, status) {
    var $chips = $("#bookingActiveFilters");
    $chips.empty();

    if (query) {
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="search" title="Clear search">${$('<div>').text(query).html()} <i class="bi bi-x ms-1"></i></button>`);
    }
    if (status && status !== "all") {
      var text = status.charAt(0).toUpperCase() + status.slice(1);
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="status" title="Clear status">${text} <i class="bi bi-x ms-1"></i></button>`);
    }
  }

  function filterBookings() {
    var query = ($.trim($("#bookingSearch").val() || "")).toLowerCase();
    var status = ($('input[name="bookingStatusFilter"]:checked').val() || "all");

    var $cards = $(".bookings .tr");

    $cards.each(function () {
      var hotelName = (($(this).data("hotel-name")) || "").toString().toLowerCase();
      var userName = (($(this).data("user-name")) || "").toString().toLowerCase();
      var orderNumber = (($(this).data("order-number")) || "").toString().toLowerCase();
      var bStatus = (($(this).data("booking-status")) || "").toString().toLowerCase();

      var nameMatch = !query || hotelName.indexOf(query) !== -1 || userName.indexOf(query) !== -1 || orderNumber.indexOf(query) !== -1;
      var statusMatch = status === "all" || bStatus === status;

      $(this).toggle(nameMatch && statusMatch);
    });

    var total = $cards.length;
    var visible = $cards.filter(":visible").length;
    $("#bookingResultsCount").text(`Showing ${visible} of ${total}`);

    // No results toggle
    if (visible === 0) {
      $("#bookingNoResults").removeClass("d-none");
    } else {
      $("#bookingNoResults").addClass("d-none");
    }

    // Update chips
    updateActiveChips($("#bookingSearch").val(), status);
  }

  // Events
  $("#bookingSearch").on("input", filterBookings);
  $(document).on("change", 'input[name="bookingStatusFilter"]', filterBookings);
  $("#resetBookingFilters").on("click", function () {
    $("#bookingSearch").val("");
    $("#statusAllBooking").prop("checked", true).trigger("change");
    filterBookings();
  });
  $(document).on("click", "#clearBookingFiltersBtn", function () {
    $("#bookingSearch").val("");
    $("#statusAllBooking").prop("checked", true).trigger("change");
    filterBookings();
  });
  $(document).on("click", "#bookingActiveFilters .chip-clear", function () {
    var type = $(this).data("chip");
    if (type === "search") {
      $("#bookingSearch").val("");
    }
    if (type === "status") {
      $("#statusAllBooking").prop("checked", true).trigger("change");
    }
    filterBookings();
  });

  // Initialize on load
  filterBookings();
});
