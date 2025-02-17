<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    var storePatientData = {};
    document.addEventListener('DOMContentLoaded', function () {
        const loadModalButton = document.getElementById('register');
        const modal = new bootstrap.Modal(document.getElementById('newPatientRegistration'), {
            backdrop: 'static'
        });

        // Listen for the modal show event and fetch data when the modal is shown
        loadModalButton.addEventListener('click', function (e) {
            e.preventDefault();
            modal.show();
        });
    });
</script>
