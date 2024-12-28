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
            font-family: Roboto, DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: nowrap;
        }

        .logo {
            max-width: 100px;
            width: 100%;
            {{--background-image: {{base64_encode(file_get_contents('./assets/img/logo/regainLogo.jpg'))}};--}}
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .title-container {
            position: relative;
            text-align: center;
            flex: 1;
            margin: 0 20px;
        }

        .assessment-title {
            font-size: 10pt;
            font-weight: 500;
            color: #3c3c3c;
            text-align: center;
            margin: 0;
        }

        .main-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
        }

        .date {
            font-size: 11pt;
            font-weight: 500;
            color: #3c3c3c;
            white-space: nowrap;
            text-align: right;
            position: relative;
        }

        .user-details {
            margin-bottom: 30px;
        }

        .user-details p {
            margin: 2px 0;
            font-size: 9pt;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .scope table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }

        .scope th, .scope td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 9pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
            text-align: center;
        }

        .scope td:first-child {
            text-align: left !important;
            width: 60%;
        }

        .scope thead {
            background-color: #fff;
        }

        .title {
            font-size: 9pt;
            font-weight: bold;
        }

        .description {
            font-size: 8pt;
        }

        .dot {
            height: 8px;
            width: 8px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
            margin-top: 5px;
        }

        h1, h2, h3, h4, h5, h6, table {
            page-break-inside: avoid;
        }

        /*same for bar graph*/
    </style>
</head>
<body>
@if(isset($result))
    <div class="header">
        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/logo/regainLogo.jpg')) }}"
             alt="Logo" class="logo">
        <div class="title-container">
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
        <div class="scope">
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
