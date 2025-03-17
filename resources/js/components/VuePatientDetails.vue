    <template>
    <div>
        <div class="d-flex justify-content-between align-items-center border-0 text-center mb-3">
            <h3 class="text-center flex-grow-1" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size:1.4rem; margin-bottom: 0 !important">
                Patient Info
            </h3>
        </div>
        <div id="modal-container" class="modal-body">
                <div v-if="patientData" class="card shadow p-3">
                    <div class="row">
                        <!-- Left Column - Basic Info -->
                        <div class="col-md-6">
                            <h5 class="text-dark fw-bold">Basic Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="margin-left: -15px"><strong>Name:</strong> {{ patientData.fullName }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Email:</strong> {{ patientData.email }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Birthday:</strong> {{ formatDate(patientData.birthday.date) }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Post Code:</strong> {{ patientData.post_code }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Region:</strong> {{ patientData.regionName }}</li>
                            </ul>
                        </div>

                        <!-- Right Column - Contact Info -->
                        <div class="col-md-6">
                            <h5 class="text-dark fw-bold">Contact Details</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="margin-left: -15px"><strong>Primary Phone:</strong> {{ patientData.primaryPhone }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Secondary Phone:</strong> {{ patientData.secondaryPhone || "N/A" }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Accessible Mobility:</strong> {{ patientData.accessibleMobility ? "Yes" : "No" }}</li>
                                <li class="list-group-item" style="margin-left: -15px"><strong>Military:</strong> {{ patientData.isMilitary ? "Yes" : "No" }}</li>
                                <li v-if="patientData.isMilitary" class="list-group-item" style="margin-left: -15px"><strong>Military Status:</strong> {{ patientData.militaryStatus }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="mt-3">
                        <h5 class="text-dark fw-bold">Notes</h5>
                        <p class="text-muted">{{ patientData.notes || "No additional notes available." }}</p>
                    </div>
                </div>

                <!-- Loading / No Data -->
                <div v-else class="text-center text-muted">
                    <p>Loading patient details...</p>
                </div>
            </div>
    </div>
    </template>

    <script>
    import {onMounted, ref} from 'vue';

    export default {
      setup() {
          const patientData = ref(null);

          const formatDate = (dateString) => {
              if (!dateString) return "N/A";
              const options = { year: "numeric", month: "long", day: "numeric" };
              return new Date(dateString).toLocaleDateString("en-US", options);
          };

          window.fetchPatientData = async (id) => {
              if (!id) return;
              try {
                  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                  const response = await fetch(`/organisation/patients/${id}`, {
                      method: 'GET',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': csrfToken
                      }
                  });
                  patientData.value = await response.json();
              } catch (error) {
                  console.error("Error fetching patient data:", error);
              }
          };

          const resetForm = () => {
              patientData.value = null;
          };

          onMounted(() => {
              window.resetPatientData = resetForm;
          });

        return {
            patientData,
            formatDate
        };
      }
    };
    </script>
