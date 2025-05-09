document.addEventListener('DOMContentLoaded', function () {
    // ====== Element References ======
    const addAdminButton     = document.getElementById('addAdminButton');
    const uniqueIdInput      = document.getElementById('uniqueIdInput');
    const generateIdButton   = document.getElementById('generateIdButton');
    const chronicCheck       = document.getElementById('chronicCheck');
    const chronicSelectGroup = document.getElementById('chronicSelectGroup');
    const birthInput         = document.getElementById('birth');
    const cinInput           = document.getElementById('cin');

    // ====== Add Admin ID to Hidden Input ======
    if (addAdminButton) {
        addAdminButton.addEventListener('click', function () {
            const adminId = this.value;
            const adminIdInput = document.getElementById('admin_id');
            if (adminIdInput) {
                adminIdInput.value = adminId;
            }
        });
    }

    // ====== Show/Hide Chronic Disease Field ======
    if (chronicCheck && chronicSelectGroup) {
        chronicCheck.addEventListener('change', function () {
            chronicSelectGroup.style.display = this.checked ? 'block' : 'none';
        });
    }

    // ====== Conditionally Require CIN Based on Age ======
    if (birthInput && cinInput) {
        birthInput.addEventListener('change', function () {
            const birthDate = new Date(this.value);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age >= 18) {
                cinInput.setAttribute('required', 'required');
            } else {
                cinInput.removeAttribute('required');
            }
        });
    }

    // ====== Generate and Set Unique ID ======
    if (generateIdButton && uniqueIdInput) {
        generateIdButton.addEventListener('click', function () {
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
        return Date.now().toString() + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    }
});
function generateEmail() {
  const nameField = document.getElementById('name');
  const emailField = document.getElementById('email');

  if (!nameField || !emailField) return;

  const name = nameField.value.trim().toLowerCase().replace(/\s+/g, '');
  const random = Math.floor(100 + Math.random() * 900); // random 3-digit

  if (name) {
    const email = `${name}${random}@health.ma`;
    emailField.value = email;
  } else {
    alert('Please enter a name first.');
  }
}
