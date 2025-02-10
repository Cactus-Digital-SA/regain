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
        @page {
            size: A4;
            margin: 1in;
        }

        body {
            font-family: Roboto, DejaVu Sans, sans-serif !important;
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
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            flex: 1;
            margin: 0 20px;
        }


        .main-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .date {
            font-size: 9pt;
            font-weight: 500;
            color: #000;
            white-space: nowrap;
            text-align: right;
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 3px;
        }

        .user-details {
            margin-bottom: 30px;
        }

        .user-details p {
            margin: 2px 0;
            font-size: 9pt;
            font-weight: 500;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 9pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
            text-align: center;
        }

        td:first-child {
            text-align: left !important;
            width: 60%;
        }

        thead {
            /*background-color: #f2f2f2;*/
            background-color: #fff;
        }

        h1, h2, h3, h4, h5, h6, table {
            page-break-inside: avoid;
        }

        /*add bar graph logic if need*/
    </style>
</head>
<body>
<div class="header">
    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/logo/regainLogo.jpg')) }}"
         alt="Logo" class="logo">
    <div class="title-container">
        <div class="main-title">Medical History Report</div>
    </div>
    <div class="date">{{$result->getCompletedAt()->format("d/m/Y")}}</div>
</div>

<div class="user-details">
    <p><strong>{{$result->getPatientData()->getUser()->getName()}}</strong></p>
    <p>#{{$result->getPatientData()->getUser()->getId()}}</p>
    <p>D.O.B. {{$result->getPatientData()->getBirthday()->format("d/m/Y")}}</p>
</div>
<div class="divider"></div>

@if (count($result->getQuestionAnswers()) > 0)
    <div>
        <table class="table table-hover" style="table-layout: fixed; width: 100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th class="text-left" style="width: 80%; text-align: left !important;">Question</th>
                <th class="text-left" style="width: 20%; text-align: left !important;">Answer</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($result->getQuestionAnswers() as $questionAnswer)
                <tr>
                    <td class="text-left" style="text-align: left !important;">{{$questionAnswer->getQuestionText()}}</td>
                    <td class="text-left" style="text-align: left !important;">{{$questionAnswer->getAnswerText()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
</body>
</html>
