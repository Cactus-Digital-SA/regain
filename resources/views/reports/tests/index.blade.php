@php use App\Domains\Reports\Http\Dtos\ReportTestResult; @endphp
@php
    /**
    * @var ReportTestResult $result
    */
@endphp

        <!DOCTYPE html>
<html>
<head>
    <title>Mental Health Report</title>

    <style>
        body {
            font-family: Roboto, DejaVu Sans, sans-serif;
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
<div class="header">
    <div class="logo">regain</div>
    <div>
        <div class="assessment-title">Assessment Report:</div>
        <div class="main-title">Mental Health and Mental Pain</div>
    </div>
    <div class="date">07.10.2024</div>
</div>

<div class="user-details">
    <p><strong>{{$result->getUser()->getName()}}</strong></p>
    <p>#{{$result->getUser()->getId()}}</p>
    <p>D.O.B. {{$result->getPatientData()->getBirthday()->format("d/m/Y")}}</p>
</div>
<div class="divider"></div>

<div class="overview">
    <div class="overview-title">
        {{$result->getTest()->getName()}}
        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="10" width="4" height="11" fill="#333"></rect>
            <rect x="10" y="6" width="4" height="15" fill="#333"></rect>
            <rect x="17" y="3" width="4" height="18" fill="#fff"></rect>
        </svg>
    </div>
    <div class="divider"></div>
    <div class="overview-content">
        {{$result->getDescription()}}
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
                    <th style="text-align: center; width: {{ 100 / $columns }}%">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            @for ($j = 0; $j < $columns; $j++)
                                @php
                                    $x = 3 + ($j * 7); // Calculate x position dynamically
                                    $y = 10 - ($j * 2); // Adjust y dynamically based on bar height
                                    $height = 11 + ($j * 2); // Adjust height dynamically
                                @endphp
                                <rect x="{{ $x }}" y="{{ $y }}" width="4" height="{{ $height }}" fill="{{ $fills[$i][$j] }}"></rect>
                            @endfor
                        </svg>
                    </th>
                @endfor
            </tr>
            </thead>
            <tbody>
            @foreach ($result->getSubscaleResults() as $subscaleResult)
                <tr>
                    <td nowrap style="width: 70%;">
                        <div class="title">{{$subscaleResult->getSubscaleName()}}</div>
                        <div class="description"></div>
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