document.addEventListener("DOMContentLoaded", function () {
  const radios = document.querySelectorAll(
    'input[name="type"], input[name="type_edit"]'
  );
  const specialtySelects = [
    document.getElementById("specialty"),
    document.getElementById("edit_spec"),
  ];
  const specialtyContainer = document.getElementById("specialtyContainer");

  const specialties = {
    doctor: ["Cardiologist", "Neurologist", "Pediatrician", "Dermatologist"],
    paramedical: ["Physiotherapist", "Radiology Technician", "Nurse"],
    pharmacy: ["Clinical Pharmacy", "Industrial Pharmacy"],
  };

  radios.forEach((radio) => {
    radio.addEventListener("change", () => {
      const selected = radio.value;
      const options = specialties[selected] || [];

      // Clear and update all specialty selects
      specialtySelects.forEach((select) => {
        if (select) {
          select.innerHTML = "";
          options.forEach((spec) => {
            const option = document.createElement("option");
            option.value = spec.toLowerCase().replace(/\s+/g, "-");
            option.textContent = spec;
            select.appendChild(option);
          });
        }
      });

      // Show or hide container
      specialtyContainer.style.display = options.length ? "block" : "none";
    });
  });
});

// Generate email based on name + random + @health.ma
function generateEmail() {
  const nameField = document.getElementById("name");
  const emailField = document.getElementById("email");

  if (!nameField || !emailField) return;

  const name = nameField.value.trim().toLowerCase().replace(/\s+/g, "");
  const random = Math.floor(100 + Math.random() * 900); // random 3-digit

  if (name) {
    const email = `${name}${random}@health.ma`;
    emailField.value = email;
  } else {
    alert("Please enter a name first.");
  }
}
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

//password validator
const passwordInput = document.getElementById("password");
const message = document.getElementById("message");

passwordInput.addEventListener("input", () => {
  const password = passwordInput.value;
  const minLength = 8;
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;

  if (password.length < minLength) {
    message.textContent = "❌ At least 8 characters required.";
    message.style.color = "red";
  } else if (!regex.test(password)) {
    message.textContent =
      "❌ Must include uppercase, lowercase, number, and special character.";
    message.style.color = "red";
  } else {
    message.textContent = "✅ Password is strong!";
    message.style.color = "green";
  }
});
//inpe validator
const inpeInput = document.getElementById("inpe");
const msg = document.getElementById("msg");

inpeInput.addEventListener("input", () => {
  const value = inpeInput.value.trim();
  const regex = /^\d{9}$/;

  if (regex.test(value)) {
    msg.textContent = "✅ Valid INPE number.";
    msg.style.color = "green";
  } else {
    msg.textContent = "❌ Must contain exactly 9 digits.";
    msg.style.color = "red";
  }
});
