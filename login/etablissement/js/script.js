function toggleVisibility(buttonId, inputId) {
  const button = document.getElementById(buttonId);
  const input = document.getElementById(inputId);

  if (button && input) {
    button.addEventListener("click", () => {
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      button.innerHTML = `<i class="fas fa-eye${
        isPassword ? "-slash" : ""
      }"></i>`;
    });
  }
}

// Utilisation
toggleVisibility("eye-icon", "password");
toggleVisibility("eye-icon-confirm", "confirmpassword");
toggleVisibility("eye-icon-1", "current_password");
toggleVisibility("eye-icon-2", "new_password");
