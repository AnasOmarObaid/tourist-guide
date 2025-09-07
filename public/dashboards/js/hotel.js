// filtering the hotels based on the selected criteria
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
    let minVal = parse(minRange.value, parseInt(minRange.min) || 0);
    let maxVal = parse(maxRange.value, parseInt(maxRange.max) || 0);
    if (minVal > maxVal) [minVal, maxVal] = [maxVal, minVal];
    minRange.value = minVal;
    maxRange.value = maxVal;
    minInput.value = minVal;
    maxInput.value = maxVal;
    display.textContent = `$${minVal} - $${maxVal}`;
  };

  const clamp = (val, min, max) => Math.min(max, Math.max(min, val));

  const syncFromInputs = () => {
    const minLimit = parseInt(minRange.min) || 0;
    const maxLimit = parseInt(maxRange.max) || 0;
    let minVal = clamp(
      parseInt(minInput.value) || minLimit,
      minLimit,
      maxLimit
    );
    let maxVal = clamp(
      parseInt(maxInput.value) || maxLimit,
      minLimit,
      maxLimit
    );
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

// live preview
$(document).ready(function () {
  $("#city_id").select2({
    placeholder: "Select a city",
  });

  $("#tags_id").select2({
    placeholder: "Select tags",
  });

  $("#status_id").select2({
    placeholder: "Select status",
  });

  $("#service_id").select2({
    placeholder: "Select Service",
  });

  $("#date_from").flatpickr({
    enableTime: true
  });

  $("#date_to").flatpickr({
    enableTime: true,
  });

  // live image preview (cover)
  $("#cover_image").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#previewImage").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // live room images preview (multiple)
  $("#room_images").on("change", function (e) {
    const files = e.target.files;
    const preview = $("#roomImagesPreview");
    preview.empty();
    if (files && files.length > 0) {
      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>").attr("src", e.target.result).css({
            width: "80px",
            height: "80px",
            objectFit: "cover",
            borderRadius: "0.5rem",
            border: "1px solid #ddd",
            marginRight: "8px",
            marginBottom: "8px",
          });
          preview.append(img);
        };
        reader.readAsDataURL(file);
      });
    }
  });

  // live price per night preview
  $("#price_per_night").on("input", function () {
    $("#price_per_night_preview").text("$" + $(this).val() + "/night" || "");
  });

  // live title preview
  $("#name").on("input", function () {
    $("#name_preview").text($(this).val() || "");
  });

  // live description preview
  $("#description").on("input", function () {
    $("#description_preview").text($(this).val() || "");
  });

  // live city preview
  $("#city_id").on("change", function () {
    $("#city_preview").text($(this).find("option:selected").text() || "");
  });

  // live venue preview
  $("#venue").on("input", function () {
    $("#venue_preview").text($(this).val() || "");
  });

  // live organizer preview
  $("#owner").on("input", function () {
    $("#owner_preview").text("Owned by " + $(this).val() || "Owned by");
  });

  // live rating preview
  $("#rate").on("input", function () {
    $("#rate_preview").empty();
    if ($(this).val() <= 5)
      for (let i = 0; i < $(this).val(); ++i)
        $("#rate_preview").append(
          $("#rate_preview").append(`<i class="bi bi-star-fill"></i>` || "")
        );
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

  // live service preview, append tags when select in multi tag
  $("#service_id").on("change", function () {
    $("#services_preview").empty();
    $(this)
      .find("option:selected")
      .each(function () {
        $("#services_preview").append(
          `<span class="badge bg-light text-dark border me-1 cu-rounded"><i class="bi bi-check-circle-fill text-success cu-rounded""></i>
            ${$(this).text()}</span>`
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
