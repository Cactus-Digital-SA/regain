<div class="modal fade" id="medicalHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div class="modal-content p-3 p-md-5" style="background-color: rgba(255, 255, 255, 1);">
            <form>
                <div class="form-group">
                    <input type="hidden" id="mobility" class="form-control" name="accessible_mobility">
                    <input type="hidden" id="notes" class="form-control" name="notes">
                </div>
            </form>
            <div class="modal-body" id="modal-container">
                <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
                </button>
                <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">Medical History</h3>
                {{--                <form id="new-patient-registration-form" method="POST" onsubmit="return false">--}}
                {{--                    <div class="row g-4">--}}
                {{--                        <div class="col-md-12">--}}
                {{--                            <label for="mobility-visible" class="form-label">Has the patient experienced any recent blackouts?</label>--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-6">--}}
                {{--                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-yes" value="yes" required>--}}
                {{--                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-yes">Yes</label>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-6">--}}
                {{--                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-no" value="no" required>--}}
                {{--                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-no">No</label>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <div class="col-md-12">--}}
                {{--                            <label for="mobility-visible" class="form-label">Does the patient drink alcohol?</label>--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-6">--}}
                {{--                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-yes" value="yes" required>--}}
                {{--                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-yes">Yes</label>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-6">--}}
                {{--                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-no" value="no" required>--}}
                {{--                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-no">No</label>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <div class="col-md-12">--}}
                {{--                            <label for="date-of-birthday-visible" class="form-label">How much alcohol does the patient consume per week?</label>--}}
                {{--                            <select id="date-of-birthday-visible" class="form-select new-patient-input" required>--}}
                {{--                                <option value="" selected disabled>Select how much alcohol the patient consumes per week</option>--}}
                {{--                                <option value="none">None</option>--}}
                {{--                                <option value="little">Little (1-2 drinks)</option>--}}
                {{--                                <option value="moderate">Moderate (3-4 drinks)</option>--}}
                {{--                                <option value="excessive">Excessive (5 or more drinks)</option>--}}
                {{--                            </select>--}}
                {{--                        </div>--}}
                {{--                        <div class="col-md-12 mt-5 d-flex justify-content-between">--}}
                {{--                            <button type="button" class="custom-back-btn" id="btn-back">Back</button>--}}
                {{--                            <button type="submit" class="custom-next-btn" id="btn-next">Register</button>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('medicalHistory');
        const modalContainer = document.getElementById('modal-container');

        // Function to fetch content from the server and replace the modal-container content
        function fetchAndReplaceContent() {
            // fetch('/your/route/here') // Replace with your route URL
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.text();
            //     })
            //     .then(html => {
            //         // Replace the modal-container content
            //         modalContainer.innerHTML = html;
            //     })
            //     .catch(error => {
            //         console.error('Error fetching modal content:', error);
            //     });
        }

        // Set up a MutationObserver to specifically watch aria-hidden on the modal
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (
                    mutation.type === 'attributes' &&
                    mutation.attributeName === 'aria-hidden' &&
                    mutation.target === modal // Ensure the mutation is for the #medicalHistory element
                ) {
                    const isHidden = modal.getAttribute('aria-hidden') === 'true';

                    // When the modal becomes visible, fetch and replace content
                    if (!isHidden) {
                        fetchAndReplaceContent();
                    }
                }
            });
        });

        // Observe changes to aria-hidden on the modal element only
        observer.observe(modal, {attributes: true, attributeFilter: ['aria-hidden']});
    });
</script>
