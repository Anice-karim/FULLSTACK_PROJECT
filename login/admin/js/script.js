document.addEventListener("DOMContentLoaded", function () {
  // --- Specialty Dropdown Logic ---
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
      const selectedType = radio.value;
      const options = specialties[selectedType] || [];

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

      if (specialtyContainer) {
        specialtyContainer.style.display =
          options.length > 0 ? "block" : "none";
      }
    });
  });

  // --- Password Visibility Toggle ---
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

  toggleVisibility("eye-icon", "password");
  toggleVisibility("eye-icon-confirm", "confirmpassword");
  toggleVisibility("eye-icon-1", "current_password");
  toggleVisibility("eye-icon-2", "new_password");

  // --- Password Strength Validation ---
  const passwordInput = document.getElementById("password");
  const passwordMessage = document.getElementById("message");
  // Assuming the form containing the password might have a specific ID, e.g., "passwordForm"
  // If it's always the same form as INPE, we can reuse that reference.
  // For now, let's assume a potentially different form or handle it generically.

  function validatePassword(password) {
    const minLength = 8;
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;
    let isValid = true;
    let messageText = "";
    let messageColor = "";

    if (!password || password.length < minLength) {
      // Check if password exists
      messageText = "❌ At least 8 characters required.";
      messageColor = "red";
      isValid = false;
    } else if (!regex.test(password)) {
      messageText =
        "❌ Must include uppercase, lowercase, number, and special character.";
      messageColor = "red";
      isValid = false;
    } else {
      messageText = "✅ Password is strong!";
      messageColor = "green";
      isValid = true;
    }

    if (passwordMessage) {
      passwordMessage.textContent = messageText;
      passwordMessage.style.color = messageColor;
    }
    return isValid;
  }

  // Add input listener only if password input exists
  if (passwordInput) {
    passwordInput.addEventListener("input", () => {
      validatePassword(passwordInput.value);
    });
  }

  // --- INPE Number Validation ---
  const inpeInput = document.getElementById("inpe");
  const inpeMessage = document.getElementById("msg");

  function validateInpe(value) {
    // Ensure value is treated as a string
    const valueStr = String(value || "");
    let digitsOnly = valueStr.replace(/\D/g, "");
    let isValid = false;
    let messageText = "";
    let messageColor = "";

    if (digitsOnly.length > 9) {
      digitsOnly = digitsOnly.slice(0, 9);
    }

    // Update input value visually only if it exists and changed
    if (inpeInput && inpeInput.value !== digitsOnly) {
      inpeInput.value = digitsOnly;
    }

    const regex = /^\d{9}$/;
    if (regex.test(digitsOnly)) {
      messageText = "✅ Valid INPE number.";
      messageColor = "green";
      isValid = true;
    } else {
      messageText = "❌ Must contain exactly 9 digits.";
      messageColor = "red";
      isValid = false;
    }

    if (inpeMessage) {
      inpeMessage.textContent = messageText;
      inpeMessage.style.color = messageColor;
    }
    return isValid;
  }

  // Add input listener only if INPE input exists
  if (inpeInput) {
    inpeInput.addEventListener("input", (e) => {
      validateInpe(e.target.value);
    });
  }

  // --- Form Submission Validation ---
  const mainForm = document.getElementById("form"); // Get the form by its actual ID

  if (mainForm) {
    mainForm.addEventListener("submit", function (event) {
      let isFormValid = true;
      let focusTarget = null;

      // 1. Validate INPE if the input exists within this form
      const currentInpeInput = mainForm.querySelector("#inpe");
      if (currentInpeInput) {
        if (!validateInpe(currentInpeInput.value)) {
          isFormValid = false;
          focusTarget = currentInpeInput;
          // Optionally show an alert or rely on the inline message
          // alert("Please enter a valid 9-digit INPE number.");
        }
      }

      // 2. Validate Password if the input exists within this form
      const currentPasswordInput = mainForm.querySelector("#password");
      if (currentPasswordInput) {
        if (!validatePassword(currentPasswordInput.value)) {
          isFormValid = false;
          // Set focus to password only if INPE was valid or doesn't exist
          if (!focusTarget) {
            focusTarget = currentPasswordInput;
          }
        }
      }

      // 3. Add other validations here if needed

      // Prevent submission if any validation failed
      if (!isFormValid) {
        event.preventDefault();
        if (focusTarget) {
          focusTarget.focus(); // Focus the first invalid field
        }
      }
    });
  }

  // --- Phone Number Input Formatting (+212 prefix) ---
  const phoneInput = document.getElementById("phone");
  const prefix = "+212";

  if (phoneInput) {
    phoneInput.addEventListener("input", () => {
      let val = phoneInput.value;
      if (!val.startsWith(prefix)) {
        val = prefix;
      }
      val = prefix + val.slice(prefix.length).replace(/\D/g, "");
      val = val.slice(0, prefix.length + 9);
      phoneInput.value = val;
    });
  }
});
