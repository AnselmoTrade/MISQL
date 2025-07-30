document.addEventListener("DOMContentLoaded", () => {
  const btn = document.querySelector("button");
  btn.addEventListener("click", () => {
    btn.textContent = "Guardando...";
    btn.disabled = true;
  });
});
