<div class="modal-body" id="modal-container">
    <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
    </button>
    <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">New Patient Registration</h3>
    <form>
        <div class="row g-4">
            <div class="col-md-12">
                <label for="mobility" class="form-label">Accessible Mobility</label>
                <div class="row">
                    <div class="col-6">
                        <input type="radio" class="btn-check new-patient-input" name="mobility" id="mobility-yes" value="1" required>
                        <label class="btn w-100 mobility-button  d-flex align-items-center justify-content-center" for="mobility-yes">Yes</label>
                    </div>
                    <div class="col-6">
                        <input type="radio" class="btn-check new-patient-input" name="mobility" id="mobility-no" value="0" required>
                        <label class="btn w-100 mobility-button d-flex align-items-center justify-content-center" for="mobility-no">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="notes" class="form-label">Notes (Optional)</label>
                <textarea id="notes" class="form-control new-patient-input" style="min-height: 200px"></textarea>
            </div>
            <div class="col-md-12 mt-5 d-flex justify-content-right">
                <button class="custom-next-btn" id="create-patient">Register</button>
            </div>
        </div>
    </form>
</div>
