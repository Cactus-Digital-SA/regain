<div class="d-flex justify-content-cbetween align-items-center border-0 text-center mb-3">
    <h3 class="text-center flex-grow-1" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size:1.4rem; margin-bottom: 0 !important">
        New Patient Registration
    </h3>
    <button type="button" class="btn-close btn-pinned btn-right me-3" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body" id="modal-container">
    <form>
        <div class="row g-4">
            <div class="col-md-12">
                <label for="notes" class="form-label">Military Personnel</label>
                <select class="form-control mobility-button" name="is_military" id="is_military">
                    <option value="0">Please select</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-md-12" id="military_status_container" style="display: none">
                <label for="notes" class="form-label">Military Personnel</label>
                <select class="form-control mobility-button" name="military_status" id="military_status">
                    <option value="1">Active</option>
                    <option value="2">Reserve</option>
                    <option value="3">Veteran</option>
                    <option value="4">Personnel</option>
                </select>
            </div>
            <div class="col-md-12">
                <label for="mobility" class="form-label">Accessible Mobility</label>
                <div class="row">
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="mobility" id="mobility-yes" value="1" required>
                        <label class="new-patient-input btn w-100 d-flex align-items-center justify-content-center mobility-button" for="mobility-yes">Yes</label>
                    </div>
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="mobility" id="mobility-no" value="0" required>
                        <label class="new-patient-input btn w-100 d-flex align-items-center justify-content-center mobility-button" for="mobility-no">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="notes" class="form-label">Notes (Optional)</label>
                <textarea id="notes" class="form-control new-patient-input" style="min-height: 200px"></textarea>
            </div>
            <div class="col-md-12 mt-5 d-flex justify-content-center">
                <button class="custom-next-btn" id="create-patient">Register</button>
            </div>
        </div>
    </form>
</div>
