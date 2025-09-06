// make some scripts for filter
document.addEventListener("DOMContentLoaded", function () {
  const minRange = document.getElementById("price_min_range");
  const maxRange = document.getElementById("price_max_range");
  const minInput = document.getElementById("price_min");
  const maxInput = document.getElementById("price_max");
  const display = document.getElementById("price_display");
  if (!minRange || !maxRange || !minInput || !maxInput || !display) return;

  const parse = (v, fallback) => {
    v = parseInt(v);
    return isNaN(v) ? fallback : v;
  };

  const syncFromRange = () => {
    let minVal = parse(minRange.value, parse(minRange.min, 0));
    let maxVal = parse(maxRange.value, parse(maxRange.max, 0));
    if (minVal > maxVal) [minVal, maxVal] = [maxVal, minVal];
    minRange.value = minVal;
    maxRange.value = maxVal;
    minInput.value = minVal;
    maxInput.value = maxVal;
    display.textContent = `$${minVal} - $${maxVal}`;
  };

  const clamp = (val, min, max) => Math.min(max, Math.max(min, val));

  const syncFromInputs = () => {
    const minLimit = parse(minRange.min, 0);
    const maxLimit = parse(maxRange.max, 0);
    let minVal = clamp(parse(minInput.value, minLimit), minLimit, maxLimit);
    let maxVal = clamp(parse(maxInput.value, maxLimit), minLimit, maxLimit);
    if (minVal > maxVal) [minVal, maxVal] = [maxVal, minVal];
    minRange.value = minVal;
    maxRange.value = maxVal;
    display.textContent = `$${minVal} - $${maxVal}`;
  };

  minRange.addEventListener("input", syncFromRange);
  maxRange.addEventListener("input", syncFromRange);
  minInput.addEventListener("change", syncFromInputs);
  maxInput.addEventListener("change", syncFromInputs);

  syncFromRange();
});

// make some select2 and date piker
$(document).ready(function () {
  $("#city_id").select2({
    placeholder: "Select a city",
  });
});

$(document).ready(function () {
  $("#tags_id").select2({
    placeholder: "Select tags",
  });
});

$(document).ready(function () {
  $("#status_id").select2({
    placeholder: "Select status",
  });
});

$("#start_at").flatpickr({
  enableTime: true,
  minDate: "today",
});

$("#end_at").flatpickr({
  enableTime: true,
  minDate: "today",
});

// live preview
$(document).ready(function () {
  // live image preview
  $("#event_image").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#previewImage").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // live title preview
  $("#title").on("input", function () {
    $("#title_preview").text($(this).val() || "");
  });

  // live description preview
  $("#description").on("input", function () {
    $("#description_preview").text($(this).val() || "");
  });

  // live start_at preview
  $("#start_at").on("input", function () {
    $("#start_at_preview").text($(this).val() || "");
  });

  // live end_at preview
  $("#end_at").on("input", function () {
    $("#end_at_preview").text($(this).val() || "");
  });

  // live city preview
  $("#city_id").on("change", function () {
    $("#city_preview").text($(this).find("option:selected").text() || "");
  });

  // live venue preview
  $("#venue").on("input", function () {
    $("#venue_preview").text($(this).val() || "");
  });

  // live price preview
  $("#price").on("input", function () {
    $("#price_preview").text("$" + $(this).val() || "");
  });

  // live organizer preview
  $("#organizer").on("input", function () {
    $("#organizer_preview").text($(this).val() || "");
  });

  // live tags preview, append tags when select in multi tag
  $("#tags_id").on("change", function () {
    $("#tags_preview").empty();
    $(this)
      .find("option:selected")
      .each(function () {
        $("#tags_preview").append(
          `<span class="tag-badge">${$(this).text()}</span>`
        );
      });
  });

  // Status checkbox
  $('input[name="status"]').on("change", function () {
    // Toggle the checkbox value
    $(this).data("value", $(this).is(":checked") ? "1" : "0");

    // Update the preview status class to set or remove bg-success or bg-danger
    if ($(this).data("value") == "1") {
      $("#status_preview").text("Active");
      $("#status_preview")
        .removeClass("status-badge-danger")
        .addClass("status-badge-success");
    } else {
      $("#status_preview").text("Cancelled");
      $("#status_preview")
        .removeClass("status-badge-success")
        .addClass("status-badge-danger");
    }
  });
});
