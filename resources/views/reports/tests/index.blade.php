@php use App\Domains\Reports\Dtos\PatientReport\ReportTestResult; @endphp
@php
    /**
    * @var ReportTestResult $result
    */
@endphp

        <!DOCTYPE html>
<html>
<head>
    <title>{{$result->getTest()->getName()}} Report</title>
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
            position: absolute;
            top: 0;
            right: 0;
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

        .overview {
            margin-top: 20px;
        }

        .overview-group {
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-content: center;
            margin-bottom: 20px;
        }

        .overview-title {
            font-size: 10pt;
            font-weight: bold;
            display: flex;
            align-items: center;
            margin-right: 20px;
            flex-direction: row;
        }

        .overview-bar-container {
            padding-bottom: 5px;
        }

        .overview-content {
            margin: 30px 0 40px 0;
            font-size: 9pt;
            text-align: justify;
            line-height: 1.2;
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

        .bar-graph-3 {
            padding-left: 20px;
        }

        .bar-graph-4 {
            padding-left: 10px;
        }

        .j-bar-4-1 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-one.jpg')) }}');
            background-size: cover;
            background-color: transparent;

        }

        .j-bar-4-2 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-two.jpg')) }}');
            background-size: cover;
        }

        .j-bar-4-3 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-three.jpg')) }}');
            background-size: cover;
        }

        .j-bar-4-4 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-four.jpg')) }}');
            background-size: cover;
        }

        .j-bar-3-1 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-one.jpg')) }}');
            background-size: cover;
        }

        .j-bar-3-2 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-two.jpg')) }}');
            background-size: cover;
        }

        .j-bar-3-3 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-three.jpg')) }}');
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/logo/regainLogo.jpg')) }}"
         alt="Logo" class="logo">
    <div class="title-container">
        <div class="assessment-title">Assessment Report:</div>
        <div class="main-title">{{$result->getTest()->getName()}}</div>
    </div>
    <div class="date">{{$result->getCompletedAt()->format("d/m/Y")}}</div>
</div>

<div class="user-details">
    <p><strong>{{$result->getUser()->getName()}}</strong></p>
    <p>#{{$result->getUser()->getId()}}</p>
    <p>D.O.B. {{$result->getPatientData()->getBirthday()->format("d/m/Y")}}</p>
</div>
<div class="divider"></div>

<div class="overview">
    <div class="overview-group">
        <div class="overview-title">
            {{$result->getTest()->getName()}}
            @php
                $testColumns = $result->getTestResult()->getTestItems();
                $testIndex = $result->getTestResult()->getTestIndex();
                $testClassName = "j-bar-{$testColumns}-" . $testIndex;
            @endphp
            <div class="bar-graph-{{ $testColumns }}">
                <div class="{{ $testClassName }}" style="width: 24px; height: 22px; display: flex">
                </div>
            </div>
        </div>

    </div>
    <div class="divider"></div>
    <div class="overview-content">
        {{ $result->getDescription() }}
    </div>
</div>
@if (count($result->getSubscaleResults()) > 0)
    <div>
        <table>
            <thead>
            @php
                $columns = $result->getSubscaleItems();
                $fills = [];
                for ($i = 0; $i < $columns; $i++) {
                    $columnFills = [];
                    for ($j = 0; $j < $columns; $j++) {
                        $columnFills[] = $j <= $i ? '#333' : '#fff';
                    }
                    $fills[] = $columnFills;
                }
            @endphp
            <tr>
                <th>{{$result->getTest()->getName()}} Subscales</th>
                @for ($i = 0; $i < $columns; $i++)
                    <th>
                        @php
                            $className = "j-bar-{$columns}-" . ($i + 1);
                        @endphp
                        <div class="bar-graph-{{ $columns }}">
                            <div class="{{ $className }}" style="width: 24px; height: 22px; display: flex">
                            </div>
                        </div>
                    </th>
                @endfor
            </tr>
            </thead>
            <tbody>
            @foreach ($result->getSubscaleResults() as $subscaleResult)
                <tr>
                    <td>
                        <div class="title">{{$subscaleResult->getSubscaleName()}}</div>
                        <div class="description">{{$subscaleResult->getDescription()}}</div>
                    </td>
                    @for ($i = 1; $i <= $columns; $i++)
                        <td style="text-align: center;">
                            @if ($i === $subscaleResult->getSubscaleIndex())
                                <span class="dot"></span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
</body>
</html>
