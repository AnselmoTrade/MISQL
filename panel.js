document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("btnSubir");
  btn.addEventListener("click", () => {
    btn.textContent = "Subiendo...";
    btn.disabled = true;
  });
});
