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

const tableBody = document.querySelector("#dataTable tbody");

function addNewRow() {
  const rows = tableBody.querySelectorAll("tr");
  if (rows.length > 0) {
    const lastRowInputs = rows[rows.length - 1].querySelectorAll("input");
    const isLastRowEmpty = Array.from(lastRowInputs).every(
      (input) => input.value.trim() === ""
    );
    if (isLastRowEmpty) return; // Ne pas ajouter si la dernière ligne est vide
  }

  const newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td><input class="form-control" type="text" name="item[]"></td>
<td><input class="form-control price-input" type="number" name="price[]" placeholder="Enter price" oninput="updateTotal()"></td>  `;
  tableBody.appendChild(newRow);
  addInputListeners(newRow);
}

function addInputListeners(row) {
  const inputs = row.querySelectorAll("input");

  inputs.forEach((input) => {
    input.addEventListener("input", () => {
      const allRows = tableBody.querySelectorAll("tr");
      if (row === allRows[allRows.length - 1]) {
        const hasValue = Array.from(inputs).some(
          (input) => input.value.trim() !== ""
        );
        if (hasValue) {
          addNewRow();
        }
      }
      updateTotal(row);
    });
  });
}

function updateTotal() {
  let total = 0;
  // Get all price inputs
  const prices = document.querySelectorAll(".price-input");
  prices.forEach((input) => {
    const val = parseFloat(input.value);
    if (!isNaN(val)) {
      total += val;
    }
  });
  // Set the total in the footer span
  document.getElementById("finalTotal").textContent = total.toFixed(2);
}

// Initialise l'écoute sur la première ligne au chargement
addInputListeners(tableBody.querySelector("tr"));
///inpe
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
