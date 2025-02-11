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
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-top: 0.1px;
        }

        .title-container {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            flex: 1;
            margin: 0.1px 20px;
        }

        .assessment-title {
            font-family: Roboto, DejaVu Sans, sans-serif;
            font-size: 10pt;
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
            font-size: 10pt;
            color: #3c3c3c;
            white-space: nowrap;
            text-align: right;
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 0.1px;
        }

        .user-details {
            margin-bottom: 30px;
        }

        .user-details p {
            margin: 2px 0;
            font-size: 9pt;
        }

        .divider {
            border-top: 0.7px solid #dfe3ec;
            margin: 10px 0;
        }

        .overview-content {
            margin: 20px 0 30px 0;
            font-size: 9pt;
            text-align: justify;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*margin-top: 20px;*/
            table-layout: fixed;
        }

        th, td {
            border: 0.7px solid #dfe3ec;
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

        .exclude {
            all: unset;
        }

        .title {
            font-size: 8pt;
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
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-one.png')) }}');
            background-size: cover;
            background-color: transparent;

        }

        .j-bar-4-2 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-two.png')) }}');
            background-size: cover;
        }

        .j-bar-4-3 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-three.png')) }}');
            background-size: cover;
        }

        .j-bar-4-4 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/four-bar-four.png')) }}');
            background-size: cover;
        }

        .j-bar-3-1 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-one.png')) }}');
            background-size: cover;
        }

        .j-bar-3-2 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-two.png')) }}');
            background-size: cover;
        }

        .j-bar-3-3 {
            background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents('./assets/img/three-bar-three.png')) }}');
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
    <div class="date">{{$result->getCompletedAt()->format("d.m.Y")}}</div>
</div>

<div class="user-details">
    <p><strong>{{$result->getUser()->getName()}}</strong></p>
    <p>#{{$result->getUser()->getId()}}</p>
    <p>D.O.B. {{$result->getPatientData()->getBirthday()->format("d/m/Y")}}</p>
</div>
<div class="divider"></div>

<div class="overview">
    <table class="exclude" style="text-wrap: nowrap; padding: 0; margin: 0; table-layout: auto;">
        <tr class="exclude">
            <td class="exclude" style="font-size: 10pt; font-weight: bold; padding-right: 20px; border: none !important; white-space: nowrap; width: 1%;">
                {{$result->getTest()->getName()}}
            </td>
            @php
                $testColumns = $result->getTestResult()->getTestItems();
                $testIndex = $result->getTestResult()->getTestIndex();
                $testClassName = "j-bar-{$testColumns}-" . $testIndex;
            @endphp
            <td class="exclude" style="width: auto; border: none !important;">
                <div class="bar-graph-{{ $testColumns }}" style="padding: 0 !important;">
                    <div class="{{ $testClassName }}" style="width: 24px; height: 22px;"></div>
                </div>
            </td>
        </tr>
    </table>

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
                <th style="text-align: left; background-color: #f0f1f5; font-weight: normal; font-size: 10pt!important; border-left: 0;">{{$result->getTest()->getName()}} Subscales</th>
                @for ($i = 0; $i < $columns; $i++)
                    <th style=" background-color: #f0f1f5; border-right: 0;">
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
                    <td style="border-left: 0;">
                        <div class="title">{{$subscaleResult->getSubscaleName()}}</div>
                        <div class="description">{{$subscaleResult->getDescription()}}</div>
                    </td>
                    @for ($i = 1; $i <= $columns; $i++)
                        <td style="text-align: center; border-right: 0;">
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
