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
    doctor: [
      "Cardiologist",
      "Neurologist",
      "Pediatrician",
      "Dermatologist",
      "Dentist",
      "Oncologist",
      "Orthopedic Surgeon",
      "Psychiatrist",
      "Gynecologist",
      "Endocrinologist",
      "Gastroenterologist",
      "Ophthalmologist",
      "Pulmonologist",
      "Urologist",
      "Rheumatologist",
    ],
    BRI: ["Radiology", "Biology", "Imaging"],
    paramedical: [
      "Physiotherapist",
      "Radiology Technician",
      "Nurse",
      "Lab Technician",
      "Medical Assistant",
      "Anesthesiology Technician",
      "Occupational Therapist",
      "Respiratory Therapist",
      "Dental Hygienist",
      "Speech Therapist",
    ],
    pharmacy: [
      "Clinical Pharmacy",
      "Industrial Pharmacy",
      "Community Pharmacy",
      "Hospital Pharmacy",
      "Pharmaceutical Research",
      "Pharmacovigilance",
      "Pharmacology",
      "Pharmacy Management",
      "Compounding Pharmacy",
      "Regulatory Affairs",
    ],
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
const form = document.getElementById("form");

function validatePassword(password) {
  const minLength = 8;
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;

  if (password.length < minLength) {
    message.textContent = "❌ At least 8 characters required.";
    message.style.color = "red";
    return false;
  } else if (!regex.test(password)) {
    message.textContent =
      "❌ Must include uppercase, lowercase, number, and special character.";
    message.style.color = "red";
    return false;
  } else {
    message.textContent = "✅ Password is strong!";
    message.style.color = "green";
    return true;
  }
}

passwordInput.addEventListener("input", () => {
  validatePassword(passwordInput.value);
});

form.addEventListener("submit", (event) => {
  if (!validatePassword(passwordInput.value)) {
    event.preventDefault(); // Prevent form submission if invalid
    passwordInput.focus();
  }
});
//inpe validator
const inpeInput = document.getElementById("inpe");
const msg = document.getElementById("msg");

function validateInpe(value) {
  // Remove non-digit characters
  let digitsOnly = value.replace(/\D/g, "");
  // Limit max 9 digits
  if (digitsOnly.length > 9) {
    digitsOnly = digitsOnly.slice(0, 9);
  }
  // Update the input value with filtered digits
  inpeInput.value = digitsOnly;

  // Check exact 9 digits
  const regex = /^\d{9}$/;
  if (regex.test(digitsOnly)) {
    msg.textContent = "✅ Valid Input number.";
    msg.style.color = "green";
    return true;
  } else {
    msg.textContent = "❌ Must contain exactly 9 digits.";
    msg.style.color = "red";
    return false;
  }
}

inpeInput.addEventListener("input", () => {
  validateInpe(inpeInput.value);
});

form.addEventListener("submit", (event) => {
  if (!validateInpe(inpeInput.value)) {
    event.preventDefault(); // Stop form submit
    inpeInput.focus();
  }
});
//phone input
const phoneInput = document.getElementById("phone");
const prefix = "+212";

phoneInput.addEventListener("input", () => {
  let val = phoneInput.value;

  // If it doesn't start with +212, force prefix
  if (!val.startsWith(prefix)) {
    val = prefix;
  }

  // Remove all non-digit characters except the + at start
  val = prefix + val.slice(prefix.length).replace(/\D/g, "");

  // Limit to 9 digits after +212
  val = val.slice(0, prefix.length + 9);

  phoneInput.value = val;
});
