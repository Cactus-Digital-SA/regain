// import './bootstrap';
import.meta.glob([
    '../images/**',
    '../assets/img/**',
    // '../assets/json/**',
    '../assets/vendor/fonts/**'
]);

import {createApp} from 'vue';
import VuePatientRegistration from './components/VuePatientRegistration.vue';

// Function to mount Vue only if the modal exists
document.addEventListener('DOMContentLoaded', () => {
    const modalContainer = document.getElementById('vue-register-app');
    if (modalContainer) {
        const app =
            createApp(VuePatientRegistration);
        app.mount('#vue-register-app');
    }
});