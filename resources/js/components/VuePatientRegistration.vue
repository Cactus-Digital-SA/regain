<template>
  <div>
    <div class="d-flex justify-content-between align-items-center border-0 text-center mb-3">
      <h3 v-if="!success" class="text-center flex-grow-1" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size:1.4rem; margin-bottom: 0 !important">
        New Patient Registration
      </h3>
      <button aria-label="Close" class="btn-close btn-pinned btn-right me-3" data-bs-dismiss="modal" type="button"></button>
    </div>

    <div id="modal-container" class="modal-body">
      <!-- Success Message -->
      <div v-if="success" class="text-center">
        <img src="/resources/images/logo/success-logo.svg" alt="Success Icon" class="mb-3" style="width: 51px; height: 51px;"/>
        <h5 class="mb-2 mt-4">Registration Complete</h5>
        <button type="button" class="custom-next-btn mt-3" data-bs-dismiss="modal">Done</button>
      </div>

      <!-- Registration Form -->
      <form v-else @submit.prevent="currentPage === 1 ? nextStep() : submitForm()">
        <!-- Step 1 -->
        <div v-if="currentPage === 1" class="row g-4">
          <div class="col-md-6">
            <label class="form-label" for="name">Name and Surname</label>
            <input v-model="formData.name" @blur="clearError('name')" :class="{'is-invalid': errors.name}" class="form-control new-patient-input" placeholder="ex. Olha Maximova" required type="text">
            <div class="invalid-feedback">{{ errors.name }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="date-of-birthday">Date of Birth</label>
            <input id="date-of-birthday" v-model="formData.birthday" @blur="clearError('birthday')" :class="{'is-invalid': errors.birthday}" class="form-control new-patient-input" placeholder="DD/MM/YYYY" required type="text">
            <div class="invalid-feedback">{{ errors.birthday }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="region">Region</label>

            <div class="dropdown w-100">
              <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                {{ selectedRegionName || "Select region" }}
              </button>

              <ul class="dropdown-menu scrollable-dropdown w-100">
                <li v-for="region in regions" :key="region.id">
                  <a class="dropdown-item" href="#" @click.prevent="selectRegion(region)">
                    {{ region.name }}
                  </a>
                </li>
              </ul>
            </div>

            <div class="invalid-feedback d-block" v-if="errors.region">
              {{ errors.region }}
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="post-code">Post Code</label>
            <input v-model="formData.postCode" @blur="clearError('postCode')" :class="{'is-invalid': errors.postCode}" class="form-control new-patient-input" placeholder="ex. 54624" required type="text">
            <div class="invalid-feedback">{{ errors.postCode }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="primary-phone">Primary Phone Number</label>
            <input v-model="formData.primaryPhone" @blur="clearError('primaryPhone')" :class="{'is-invalid': errors.primaryPhone}" class="form-control new-patient-input" placeholder="ex. +123 456 789" required type="text">
            <div class="invalid-feedback">{{ errors.primaryPhone }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="email">Email</label>
            <input v-model="formData.email" @blur="clearError('email')" :class="{'is-invalid': errors.email}" class="form-control new-patient-input" placeholder="ex. maximova@gmail.com" required type="text">
            <div class="invalid-feedback">{{ errors.email }}</div>
          </div>
          <div class="col-md-6">
            <label for="secondary-phone" class="form-label">Secondary Phone Number (Optional)</label>
            <input v-model="formData.secondaryPhone" type="text" class="form-control new-patient-input" placeholder="ex. +123 456 789">
          </div>
          <div class="col-md-6 mt-5 d-flex justify-content-end align-items-end">
            <button class="custom-next-btn" type="button" @click="nextStep">Next</button>
          </div>
        </div>

        <!-- Step 2 -->
        <div v-if="currentPage === 2" class="row g-4">
          <div class="col-md-12">
            <label class="form-label" for="is_military">Military Personnel</label>
            <select v-model="formData.isMilitary" @blur="clearError('isMilitary')" :class="{'is-invalid': errors.isMilitary}" class="form-control mobility-button">
              <option disabled value="">Select</option>
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
            <div class="invalid-feedback">{{ errors.isMilitary }}</div>
          </div>
          <div v-show="formData.isMilitary === '1'" class="col-md-12">
            <label class="form-label" for="military_status">Military Status</label>
            <select v-model="formData.militaryStatus" class="form-control mobility-button">
              <option value="1">Active</option>
              <option value="2">Reserve</option>
              <option value="3">Veteran</option>
              <option value="4">Personnel</option>
            </select>
          </div>
          <div class="col-md-12">
            <label class="form-label" for="mobility">Accessible Mobility</label>
            <div class="row">
              <div class="col-6">
                <input id="mobility-yes" v-model="formData.mobility" class="btn-check" name="mobility" type="radio" value="1">
                <label class="new-patient-input btn w-100 d-flex align-items-center justify-content-center mobility-button" for="mobility-yes">Yes</label>
              </div>
              <div class="col-6">
                <input id="mobility-no" v-model="formData.mobility" class="btn-check" name="mobility" type="radio" value="0">
                <label class="new-patient-input btn w-100 d-flex align-items-center justify-content-center mobility-button" for="mobility-no">No</label>
              </div>
            </div>
            <div class="invalid-feedback d-block text-danger" v-if="errors.mobility">{{ errors.mobility }}</div>
          </div>
          <div class="col-md-12">
            <label for="notes" class="form-label">Notes (Optional)</label>
            <textarea v-model="formData.notes" class="form-control new-patient-input" style="min-height: 200px"></textarea>
          </div>
          <div class="col-md-12 mt-5 d-flex justify-content-center">
            <button class="custom-next-btn d-flex align-items-center justify-content-center" type="submit" :disabled="isSubmitting">
              <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status"></span>
              {{ isSubmitting ? "Registering..." : "Register" }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div v-if="errors.general" class="alert alert-danger text-center">
    {{ errors.general }}
  </div>
</template>

<script>
import {onMounted, ref, watch, computed} from 'vue';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import debounce from 'lodash/debounce';

export default {
  setup() {
    const currentPage = ref(1);

    const initialFormData = {
      name: '',
      birthday: '',
      region: '',
      postCode: '',
      primaryPhone: '',
      email: '',
      secondaryPhone: '',
      isMilitary: '0',
      militaryStatus: '',
      mobility: '',
      notes: ''
    };

    const formData = ref({...initialFormData});


    const success = ref(false); // Track successful registration
    const errors = ref({});
    const regions = ref([]); // Fetch from backend
    const emailIsValid = ref(false);
    const isSubmitting = ref(false);

    const validateForm = () => {
      // Reset errors object
      errors.value = {};

      if (!formData.value.name.trim()) errors.value.name = "Name is required.";
      if (!formData.value.birthday.trim()) errors.value.birthday = "Date of Birth is required.";
      if (!formData.value.region) errors.value.region = "Region is required."; // No .trim() for select
      if (!formData.value.postCode.trim()) errors.value.postCode = "Post Code is required.";
      if (!formData.value.primaryPhone.trim()) errors.value.primaryPhone = "Primary Phone Number is required.";
      if (!formData.value.email.trim()) {
        errors.value.email = "Email is required.";
      } else if (!emailIsValid.value) {
        errors.value.email = "This email is already registered.";
      }

      // Trigger reactivity by explicitly updating the object reference
      errors.value = {...errors.value};

      return Object.keys(errors.value).length === 0 && emailIsValid.value;
    };

    const validateSubmitForm = () => {
      errors.value = {};

      if (!formData.value.isMilitary) errors.value.isMilitary = "Military status is required.";
      if (formData.value.mobility === '') errors.value.mobility = "Mobility selection is required.";

      return Object.keys(errors.value).length === 0;
    };

    const checkEmailExists = async () => {
      const email = formData.value.email.trim();

      // Regular expression to check email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      // Check if email is empty
      if (!email) {
        errors.value.email = "Email is required.";
        return;
      }

      // Check if email format is invalid
      if (!emailRegex.test(email)) {
        errors.value.email = "Invalid email format.";
        emailIsValid.value = false;
        return;
      }

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const response = await fetch('/organisation/patients/email-exists', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({email})
        });

        const data = await response.json();

        if (data.exists) {
          emailIsValid.value = false;
          errors.value.email = "This email is already registered.";
        } else {
          emailIsValid.value = true;
          delete errors.value.email; // Remove error if email is available
        }
      } catch (error) {
        console.error("Error checking email:", error);
        errors.value.email = "Error verifying email. Please try again.";
      }
    };


    const clearError = (field) => {
      if (field === "email") {
        if (!emailIsValid.value) {
          return;
        }
      }

      const value = formData.value[field];

      if (
          (typeof value === 'string' && value.trim() !== '') || // Handles text inputs
          (typeof value === 'number' && !isNaN(value)) || // Handles numbers if any
          (typeof value === 'boolean') || // Handles boolean values (radio buttons)
          (value !== '' && value !== null && value !== undefined) // General case for selects and other inputs
      ) {
        delete errors.value[field];
      }
    };


    const debouncedCheckEmail = debounce(checkEmailExists, 600);

    watch(() => formData.value.email, () => {
      errors.value.email = ''; // Clear any existing errors while typing
      debouncedCheckEmail();
    });

    const nextStep = () => {
      if (!validateForm()) return;
      currentPage.value = 2;
    };

    const selectedRegionName = computed(() => {
      const region = regions.value.find(r => r.id === formData.value.region);
      return region ? region.name : null;
    });

    const selectRegion = (region) => {
      formData.value.region = region.id;
      clearError('region');
    };


    const submitForm = async () => {
      if (!validateSubmitForm()) return;

      isSubmitting.value = true;

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      try {
        const response = await fetch('/organisation/patients/store', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify(formData.value)
        });

        const result = await response.json();

        if (!result.success) {
          // Show error message
          success.value = false;
          errors.value.general = result.message || "An error occurred while processing your request.";
        } else {
          success.value = true;
          initializeDT();
        }
      } catch (error) {
        console.error('Error:', error);
        errors.value.general = "A network error occurred. Please try again later.";
      } finally {
        isSubmitting.value = false; // Re-enable button after request completes
      }
    };

    const resetForm = () => {
      console.log("resetting form");
      success.value = false;
      currentPage.value = 1; // Reset back to Step 1
      Object.assign(formData.value, initialFormData);
      errors.value = {};
    };

    onMounted(() => {
      window.resetPatientRegistrationForm = resetForm;

      flatpickr('#date-of-birthday', {
        dateFormat: 'd/m/Y',
        maxDate: new Date(),
        allowInput: true,
        altFormat: 'd/m/Y',
        disableMobile: true,
        onReady: (selectedDates, dateStr, instance) => {
          // Remove unwanted Flatpickr classes
          instance.input.classList.remove('input');
        }
      });

      const appElement = document.getElementById('vue-register-app');
      if (appElement) {
        try {
          regions.value = JSON.parse(appElement.getAttribute('data-regions'));
        } catch (error) {
          console.error('Error parsing regions:', error);
        }
      }
    });

    return {
      currentPage,
      formData,
      errors,
      validateForm,
      nextStep,
      submitForm,
      regions,
      clearError,
      checkEmailExists,
      success,
      resetForm,
      selectRegion,
      selectedRegionName,
      isSubmitting
    };
  }
};
</script>
