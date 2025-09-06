// tickets grid filters
$(document).ready(function () {
  function updateActiveChips(query, status) {
    var $chips = $("#ticketActiveFilters");
    $chips.empty();

    if (query) {
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="search" title="Clear search">${$('<div>').text(query).html()} <i class="bi bi-x ms-1"></i></button>`);
    }
    if (status && status !== "all") {
      var text = status.charAt(0).toUpperCase() + status.slice(1);
      $chips.append(`<button type="button" class="btn btn-sm btn-light border cu-rounded me-2 chip-clear" data-chip="status" title="Clear status">${text} <i class="bi bi-x ms-1"></i></button>`);
    }
  }

  function filterTickets() {
    var query = ($.trim($("#ticketSearch").val() || "")).toLowerCase();
    var status = ($('input[name="ticketStatusFilter"]:checked').val() || "all");

    var $cards = $(".tickets .tr");

    $cards.each(function () {
      var eventName = (($(this).data("event-name")) || "").toString().toLowerCase();
      var userName = (($(this).data("user-name")) || "").toString().toLowerCase();
      var tStatus = (($(this).data("ticket-status")) || "").toString().toLowerCase();

      var nameMatch = !query || eventName.indexOf(query) !== -1 || userName.indexOf(query) !== -1;
      var statusMatch = status === "all" || tStatus === status;

      $(this).toggle(nameMatch && statusMatch);
    });

    var total = $cards.length;
    var visible = $cards.filter(":visible").length;
    $("#ticketResultsCount").text(`Showing ${visible} of ${total}`);

    // No results toggle
    if (visible === 0) {
      $("#ticketNoResults").removeClass("d-none");
    } else {
      $("#ticketNoResults").addClass("d-none");
    }

    // Update chips
    updateActiveChips($("#ticketSearch").val(), status);
  }

  // Events
  $("#ticketSearch").on("input", filterTickets);
  $(document).on("change", 'input[name="ticketStatusFilter"]', filterTickets);
  $("#resetTicketFilters").on("click", function () {
    $("#ticketSearch").val("");
    $("#statusAllTicket").prop("checked", true).trigger("change");
    filterTickets();
  });
  $(document).on("click", "#clearTicketFiltersBtn", function () {
    $("#ticketSearch").val("");
    $("#statusAllTicket").prop("checked", true).trigger("change");
    filterTickets();
  });
  $(document).on("click", "#ticketActiveFilters .chip-clear", function () {
    var type = $(this).data("chip");
    if (type === "search") {
      $("#ticketSearch").val("");
    }
    if (type === "status") {
      $("#statusAllTicket").prop("checked", true).trigger("change");
    }
    filterTickets();
  });

  // Initialize on load
  filterTickets();
});

