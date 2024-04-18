window.addEventListener('load', () => {
    // Code to display the modal if needed
    <?php if (isset($_GET['show_modal']) && $_GET['show_modal'] == 1 && isset($employee)): ?>
        document.getElementById('modalName').textContent = '<?= htmlspecialchars($employee['staff_name']) ?>';
        document.getElementById('modalRole').textContent = '<?= htmlspecialchars($employee['emp_role']) ?>';
        document.getElementById('modalAddress').textContent = '<?= htmlspecialchars($employee['staff_address']) ?>';
        document.getElementById('modalMobile').textContent = '<?= htmlspecialchars($employee['mobile_no']) ?>';
        document.getElementById('dob').textContent = '<?= htmlspecialchars($employee['date_of_birth']) ?>';
        // Populate new fields
        document.getElementById('modalNIC').textContent += '<?= htmlspecialchars($employee['nic']) ?>';
        document.getElementById('modalStaffID').textContent += '<?= $employee['staff_id'] ?>';

        // Assuming 'profile_picture' is base64-encoded string
        <?php if (!empty($employee['profile_picture'])): ?>
            document.getElementById('modalProfilePicture').src = 'data:image/jpeg;base64,<?= base64_encode($employee['profile_picture']) ?>';
            document.getElementById('modalProfilePicture').style.display = 'inline';
        <?php endif; ?>

        document.getElementById('employeeProfileModal').style.display = 'inline';
    <?php endif; ?>

    // Close modal script
    document.querySelector('.close').addEventListener('click', function () {
        document.getElementById('employeeProfileModal').style.display = 'none';
    });
});