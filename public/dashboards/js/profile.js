// Image preview
document.getElementById("image")?.addEventListener("change", function (e) {
  const file = e.target.files?.[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function (ev) {
    const img = document.getElementById("profilePreview");
    if (img) img.src = ev.target.result;
  };
  reader.readAsDataURL(file);
});


// Password confirmation
(function () {
  const pw = document.getElementById("new_password");
  const pwc = document.getElementById("new_password_confirmation");
  const submit = document.getElementById("passwordSubmit");
  const mismatch = document.getElementById("pwMismatch");
  if (!pw || !pwc || !submit || !mismatch) return;
  const check = () => {
    const ok = pw.value.length >= 8 && pw.value === pwc.value;
    submit.disabled = !ok;
    mismatch.classList.toggle("d-none", pw.value === pwc.value);
    if (pw.value !== pwc.value) {
      pwc.classList.add("is-invalid");
    } else {
      pwc.classList.remove("is-invalid");
    }
  };
  pw.addEventListener("input", check);
  pwc.addEventListener("input", check);
  check();
})();
