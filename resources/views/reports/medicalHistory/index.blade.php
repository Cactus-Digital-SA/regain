@php use App\Domains\Reports\Dtos\MedicalHistoryReport\MedicalHistoryResult; @endphp
@php
    /**
    * @var MedicalHistoryResult $result
    */
@endphp

    <!DOCTYPE html>
<html>
<head>
    <title>Medical History Report</title>

    <style>
        #medicalHistoryResult{
            min-width: 1120px;
        }
        @page {
            size: A4;
            margin: 1in;
        }

        body {
            margin: 0;
            padding: 0;
        }

        /*same for bar graph*/
    </style>
</head>
<body>
@if(isset($result))
<div class="d-flex justify-content-cbetween align-items-center border-0 text-center mb-3">
    <h3 class="text-center flex-grow-1" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size:1.4rem; margin-bottom: 0 !important">
        Medical History Results
    </h3>
    <button type="button" class="btn-close btn-pinned btn-right me-3" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pre-assessment" role="tabpanel">
            @if (count($result->getQuestionAnswers()) > 0)
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #fff; z-index: 2;">
                        <tr>
                            <th class="text-left" style="width: 80%">Question</th>
                            <th class="text-left" style="width: 20%">Answer</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($result->getQuestionAnswers() as $questionAnswer)
                            <tr>
                                <td class="text-left">{{$questionAnswer->getQuestionText()}}</td>
                                <td class="text-left">{{$questionAnswer->getAnswerText()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endif
</body>
</html>
