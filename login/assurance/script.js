document.addEventListener("DOMContentLoaded", function () {
  // ====== Element References ======

  const uniqueIdInput = document.getElementById("uniqueIdInput");
  const generateIdButton = document.getElementById("generateIdButton");
  const chronicCheck = document.getElementById("chronicCheck");
  const chronicSelectGroup = document.getElementById("chronicSelectGroup");
  const birthInput = document.getElementById("birth");
  const cinInput = document.getElementById("cin");

  // ====== Show/Hide Chronic Disease Field ======
  if (chronicCheck && chronicSelectGroup) {
    chronicCheck.addEventListener("change", function () {
      chronicSelectGroup.style.display = this.checked ? "block" : "none";
    });
  }

  // ====== Conditionally Require CIN Based on Age ======
  if (birthInput && cinInput) {
    birthInput.addEventListener("change", function () {
      const birthDate = new Date(this.value);
      const today = new Date();

      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();

      if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < birthDate.getDate())
      ) {
        age--;
      }

      if (age >= 18) {
        cinInput.setAttribute("required", "required");
      } else {
        cinInput.removeAttribute("required");
      }
    });
  }

  // ====== Generate and Set Unique ID ======
  if (generateIdButton && uniqueIdInput) {
    generateIdButton.addEventListener("click", function () {
      console.log("Generate ID button clicked!");
      const uniqueNum = generateUniqueId();
      uniqueIdInput.value = uniqueNum;
      console.log("Generated immatr: " + uniqueNum);
    });
  } else {
    console.log("Generate ID button or input not found.");
  }

  // ====== Helper: Generate Unique ID ======
  function generateUniqueId() {
    return (
      Date.now().toString() +
      Math.floor(Math.random() * 1000)
        .toString()
        .padStart(3, "0")
    );
  }

  // ====== Handle Modal Opening and Closing ======
  $("#addfamily").on("show.bs.modal", function () {
    // Retirer aria-hidden quand la modal s'ouvre
    $(this).removeAttr("aria-hidden");

    // Mettre le focus sur l'élément à l'intérieur de la modal (par exemple, un champ de saisie)
    $("#admin_id").focus();
  });

  $("#addfamily").on("hide.bs.modal", function () {
    // Réappliquer aria-hidden quand la modal est fermée
    $(this).attr("aria-hidden", "true");
  });

  // ====== Toggle Confirm Password visibility ======
  const eyeIcon = document.getElementById("eye-icon");
  const passwordField = document.getElementById("password");

  if (eyeIcon && passwordField) {
    eyeIcon.addEventListener("click", function () {
      if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        passwordField.type = "password";
        eyeIcon.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  }

  // Toggle Confirm Password visibility
  const eyeIconConfirm = document.getElementById("eye-icon-confirm");
  const confirmPasswordField = document.getElementById("confirmpassword");

  if (eyeIconConfirm && confirmPasswordField) {
    eyeIconConfirm.addEventListener("click", function () {
      if (confirmPasswordField.type === "password") {
        confirmPasswordField.type = "text";
        eyeIconConfirm.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        confirmPasswordField.type = "password";
        eyeIconConfirm.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  }

  // ====== Generate Email Address ======
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

  const btn = document.getElementById("generateEmailBtn");
  if (btn) {
    btn.addEventListener("click", generateEmail);
  }
});
//=====mode de passe condition ===============
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
