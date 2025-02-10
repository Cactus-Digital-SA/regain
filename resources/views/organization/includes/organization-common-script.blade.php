<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    var storePatientData = {};
    document.addEventListener('DOMContentLoaded', function () {
        const modalContainer = document.getElementById('patient-modal-content');
        const loadModalButton = document.getElementById('register');
        const modal = new bootstrap.Modal(document.getElementById('newPatientRegistration'), {
            backdrop: 'static'
        });

        // Function to fetch medical history data
        function fetchPatientForm() {
            // Send POST request to fetch medical history data
            fetch(`{{route("organization.patients.create-page", ["page" => 1])}}`, {
                method: 'POST',  // Change the method to POST
                headers: {
                    'Content-Type': 'application/json',  // Set content type to JSON
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
                .then(response => response.text())
                .then(data => {
                    // Replace modal content with the fetched data
                    modalContainer.innerHTML = data;
                    // Show the modal after the content is fetched and set
                    modal.show();
                    bootModal();
                })
                .catch(error => {
                    console.error('Error fetching medical history content:', error);
                });
        }

        // Listen for the modal show event and fetch data when the modal is shown
        loadModalButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Before fetching, make sure the modal is hidden
            // modalContainer.innerHTML = ''; // Clear previous content
            // modal.hide(); // Hide modal initially

            // Fetch the medical history and show the modal after content is updated
            // fetchPatientForm();
            
            modal.show();
        });
    });

    function bootModal() {

        // Flatpickr date picker for birthday
        flatpickr('#date-of-birthday', {
            dateFormat: "d/m/Y",
            defaultDate: "today",
            maxDate: new Date(),
            allowInput: false,
            locale: {
                firstDayOfWeek: 1,
                dateFormat: "d-m-Y",
            },
        });

        let nextButton = document.getElementById('btn-next');
        formFields = document.querySelectorAll('.new-patient-input');

        if (nextButton) {
            function validateForm() {
                let allFilled = Array.from(document.querySelectorAll('input.required')).every(function (field) {
                    return field.value.trim() !== '';
                });
                nextButton.disabled = !allFilled;
            }

            formFields.forEach(function (field) {
                field.addEventListener('input', function () {
                    validateForm();
                });
            });

            validateForm();

            nextButton.addEventListener('click', function (event) {
                event.preventDefault();

                storePatientData.name = document.getElementById('name').value;
                storePatientData.birthday = document.getElementById('date-of-birthday').value;
                storePatientData.region = document.getElementById('region').value;
                storePatientData.postCode = document.getElementById('post-code').value;
                storePatientData.primaryPhone = document.getElementById('primary-phone').value;
                storePatientData.email = document.getElementById('email').value;
                storePatientData.secondaryPhone = document.getElementById('secondary-phone').value;

                fetch(`{{route("organization.patients.create-page", ["page" => 2])}}`, {
                    method: 'POST',  // Change the method to POST
                    headers: {
                        'Content-Type': 'application/json',  // Set content type to JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                    .then(response => response.text())
                    .then(data => {
                        // Replace modal content with the fetched data
                        const modalContainer = document.getElementById('patient-modal-content');
                        modalContainer.innerHTML = data;

                        const isMilitary = document.getElementById('is_military');
                        isMilitary.addEventListener('change', function (e) {
                            if (isMilitary.value === "1") {
                                document.getElementById('military_status_container').style.display = 'block';
                            }
                        });

                        bootModal();
                    })
                    .catch(error => {
                        console.error('Error fetching second page content:', error);
                    });
            });
        }

        let submitButton = document.getElementById('create-patient');
        if (submitButton) {
            submitButton.addEventListener('click', function (event) {
                event.preventDefault();
                storePatientData.isMilitary = document.getElementById('is_military').value;
                storePatientData.militaryStatus = document.getElementById('military_status').value;
                storePatientData.mobility = document.querySelector('input[name="mobility"]:checked').value;
                storePatientData.notes = document.getElementById('notes').value;

                fetch('{{ route('organization.patients.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(storePatientData)
                })
                    .then(response => response.text())
                    .then(data => {
                        // Handle the response from the server (e.g., show a success message, redirect)
                        const modalContainer = document.getElementById('patient-modal-content');
                        modalContainer.innerHTML = data;
                        initializeDT();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }
    }
</script>
