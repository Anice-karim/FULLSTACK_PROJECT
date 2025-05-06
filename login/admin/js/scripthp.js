document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="type"], input[name="type_edit"]');
    const specialtySelect = document.querySelector('#specialty, #edit_spec');
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
  
        // Clear existing options
        specialtySelect.innerHTML = '';
  
        // Add new options
        options.forEach(spec => {
          const option = document.createElement('option');
          option.value = spec.toLowerCase().replace(/\s+/g, '-');
          option.textContent = spec;
          specialtySelect.appendChild(option);
        });
  
        // Show the select container
        specialtyContainer.style.display = options.length ? 'block' : 'none';
      });
    });
  });