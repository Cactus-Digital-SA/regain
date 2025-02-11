// import './bootstrap';
import.meta.glob([
    '../images/**',
    '../assets/img/**',
    // '../assets/json/**',
    '../assets/vendor/fonts/**'
]);

import {createApp} from 'vue';
import VuePatientRegistration from './components/VuePatientRegistration.vue';
import VuePatientDetails from './components/VuePatientDetails.vue';

// Function to mount Vue only if the modal exists
document.addEventListener('DOMContentLoaded', () => {
    const patientRegistration = document.getElementById('vue-register-app');
    if (patientRegistration) {
        const app =
            createApp(VuePatientRegistration);
        app.mount('#vue-register-app');
    }

    const patientDetails = document.getElementById('vue-patient-details');
    if (patientRegistration) {
        const app =
            createApp(VuePatientDetails);
        app.mount('#vue-patient-details');
    }
});
