    // When the button is clicked
    document.getElementById('addAdminButton').addEventListener('click', function() {
        // Get the value of the button (the admin ID)
        var adminId = this.value;

        // Set the value of the hidden input field in the second form
        document.getElementById('admin_id').value = adminId;
    });