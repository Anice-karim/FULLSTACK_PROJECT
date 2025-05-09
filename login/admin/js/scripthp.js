
document.addEventListener('DOMContentLoaded', function () {
  const radios = document.querySelectorAll('input[name="type"], input[name="type_edit"]');
  const specialtySelects = [document.getElementById('specialty'), document.getElementById('edit_spec')];
  const specialtyContainer = document.getElementById('specialtyContainer');

  const specialties = {
    doctor: ['Cardiologist', 'Neurologist', 'Pediatrician', 'Dermatologist'],
    paramedical: ['Physiotherapist', 'Radiology Technician', 'Nurse'],
    pharmacy: ['Clinical Pharmacy', 'Industrial Pharmacy']
  };

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      const selected = radio.value;
      const options = specialties[selected] || [];

      // Clear and update all specialty selects
      specialtySelects.forEach(select => {
        if (select) {
          select.innerHTML = '';
          options.forEach(spec => {
            const option = document.createElement('option');
            option.value = spec.toLowerCase().replace(/\s+/g, '-');
            option.textContent = spec;
            select.appendChild(option);
          });
        }
      });

      // Show or hide container
      specialtyContainer.style.display = options.length ? 'block' : 'none';
    });
  });
});

// Generate email based on name + random + @health.ma
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
const eyeIcon = document.getElementById('eye-icon');
const passwordField = document.getElementById('password');

  eyeIcon.addEventListener('click', function() {
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      passwordField.type = 'password';
      eyeIcon.innerHTML = '<i class="fas fa-eye"></i>';
    }
  });

  // Toggle Confirm Password visibility
  const eyeIconConfirm = document.getElementById('eye-icon-confirm');
  const confirmPasswordField = document.getElementById('confirmpassword');

  eyeIconConfirm.addEventListener('click', function() {
    if (confirmPasswordField.type === 'password') {
      confirmPasswordField.type = 'text';
      eyeIconConfirm.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      confirmPasswordField.type = 'password';
      eyeIconConfirm.innerHTML = '<i class="fas fa-eye"></i>';
    }
  });

