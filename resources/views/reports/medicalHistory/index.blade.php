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
        body {
            font-family: sans-serif;
            margin: 40px;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #222;
        }

        .assessment-title {
            text-align: center;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            color: #555;
        }

        .main-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
            color: #222;
        }

        .date {
            text-align: right;
            font-size: 14px;
            color: #666;
        }

        .divider {
            border-bottom: 1px solid #ddd;
            margin: 30px 0;
        }

        .user-details {
            margin-top: 20px;
        }

        .user-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .overview-title {
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            gap: 2px;
        }

        .overview-title svg {
            width: 20px;
            padding-bottom: 5px;
        }

        .overview-content {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }

        table {
            font-size: 12px;
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f4f4f4;
            text-align: center;
            font-weight: bold;
        }

        .title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .description {
            color: #666;
            font-size: 14px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: black;
            display: inline-block;
            margin: auto;
        }

        .table-title {
            margin-top: 40px;
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            color: #222;
        }
    </style>
</head>
<body>
@if(isset($result))
    <div class="header">
        <div class="logo">regain</div>
        <div>
            <div class="assessment-title">Assessment Report:</div>
            <div class="main-title">Medical History</div>
        </div>
        <div class="date">{{ $result->getCompletedAt() ? $result->getCompletedAt()->format("d/m/Y") : 'Unknown' }}</div>
    </div>

    <div class="user-details">
        <p><strong>{{$result->getPatientData()->getUser()->getName()}}</strong></p>
        <p>#{{$result->getPatientData()->getUser()->getId()}}</p>
        <p>D.O.B. {{$result->getPatientData()->getBirthday()->format("d/m/Y")}}</p>
    </div>
    <div class="divider"></div>

    @if (count($result->getQuestionAnswers()) > 0)
        <div>
            <table>
                <tbody>
                @foreach ($result->getQuestionAnswers() as $questionAnswer)
                    <tr>
                        <td nowrap style="width: 70%;">
                            <div class="title">{{$questionAnswer->getQuestionText()}}</div>
                            <div class="description"></div>
                        </td>
                        <td style="text-align: center;">
                            {{$questionAnswer->getAnswerText()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif
</body>
</html>
