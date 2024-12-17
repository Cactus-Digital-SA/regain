<div class="modal fade" id="preAssessmentReportModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%;">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Regain Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pre-assessment-tab" data-bs-toggle="pill" data-bs-target="#pre-assessment" type="button" role="tab">Pre-Assessment</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="module1-tab" data-bs-toggle="pill" data-bs-target="#module1" type="button" role="tab">Module 1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="module2-tab" data-bs-toggle="pill" data-bs-target="#module2" type="button" role="tab">Module 2</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="module3-tab" data-bs-toggle="pill" data-bs-target="#module3" type="button" role="tab">Module 3</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="module4-tab" data-bs-toggle="pill" data-bs-target="#module4" type="button" role="tab">Module 4</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pre-assessment" role="tabpanel">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search a report">
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Assessment Report</th>
                                <th>Date</th>
                                <th>Download</th>
                                <th>Scientific References</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($completedTestsWithSubscales as $key => $value)
                                <tr>
                                    <td>{{$value}}</td>
                                    <td>03.11.2024</td>
                                    <td>
                                        <a href="{{route("practitioner.test-report", [
                                            "userId" => $userId,
                                            "testId" => $key
                                            ])}}"><i class="bi bi-download">Download</i></a>
                                    </td>
                                    <td><i class="bi bi-eye"></i> View</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="module1" role="tabpanel">Module 1 Content</div>
                    <div class="tab-pane fade" id="module2" role="tabpanel">Module 2 Content</div>
                    <div class="tab-pane fade" id="module3" role="tabpanel">Module 3 Content</div>
                    <div class="tab-pane fade" id="module4" role="tabpanel">Module 4 Content</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark">Start Module 2</button>
            </div>
        </div>
    </div>
</div>
