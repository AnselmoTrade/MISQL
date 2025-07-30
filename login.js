document.addEventListener("DOMContentLoaded", () => {
  const btn = document.querySelector("button[type='submit']");
  btn.addEventListener("click", () => {
    btn.textContent = "Ingresando...";
    btn.disabled = true;
  });
});
