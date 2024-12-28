@php use App\Domains\Reports\Http\Presenters\FlowPresenter; @endphp
@php
    /**
     * @var FlowPresenter $presenter
     * @var int $userId
    */
@endphp

<style>
.modal-link.active{
    background-color: #DDDEF1 !important;
}

.modal-link{
    border: 3px solid #DDDEF1 !important;
}
</style>

<div class="modal fade" id="flow-{{$flow->getFlowType()}}" tabindex="-1" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%;">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Regain Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3 gap-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link modal-link active" id="pre-assessment-tab" data-bs-toggle="pill"
                                data-bs-target="#pre-assessment" type="button" role="tab">Pre-Assessment
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link modal-link" id="module1-tab" data-bs-toggle="pill" data-bs-target="#module1"
                                type="button" role="tab">Module 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link modal-link" id="module2-tab" data-bs-toggle="pill" data-bs-target="#module2"
                                type="button" role="tab">Module 2
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link modal-link" id="module3-tab" data-bs-toggle="pill" data-bs-target="#module3"
                                type="button" role="tab">Module 3
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link modal-link" id="module4-tab" data-bs-toggle="pill" data-bs-target="#module4"
                                type="button" role="tab">Module 4
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pre-assessment" role="tabpanel">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search a report">
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover" style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #fff; z-index: 2;">
                                <tr>
                                    <th class="text-left w-50">Assessment Report</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Download</th>
                                    <th class="text-center">Scientific References</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($flow->getTests() as $test)
                                    <tr>
                                        <td class="text-left">{{$test->getName()}}</td>
                                        <td class="text-center">{{$test->getCompletedAt()->format("d.m.Y")}}</td>
                                        <td class="text-center">
                                            <a href="{{route("practitioner.test-report", [
                                                "userId" => $userId,
                                                "testId" => $test->getId()
                                            ])}}" class="text-decoration-none text-black font-weight-bold">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        </td>
                                        <td class="text-center"><i class="ti ti-eye"></i> View</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="module1" role="tabpanel">Module 1 Content</div>
                    <div class="tab-pane fade" id="module2" role="tabpanel">Module 2 Content</div>
                    <div class="tab-pane fade" id="module3" role="tabpanel">Module 3 Content</div>
                    <div class="tab-pane fade" id="module4" role="tabpanel">Module 4 Content</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-next">Start Module 2</button>
            </div>
        </div>
    </div>
</div>
