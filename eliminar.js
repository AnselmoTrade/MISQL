document.addEventListener("DOMContentLoaded", () => {
  const button = document.querySelector("button[type='submit']");
  button.addEventListener("click", () => {
    button.textContent = "Eliminando...";
    button.disabled = true;
  });
});
