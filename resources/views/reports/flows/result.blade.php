@php
    use App\Domains\Reports\Http\Dtos\ReportResults;
    use \App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
/**
* @var ReportResults $result
*/
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        table {
            border-collapse: collapse; /* Collapse borders for a cleaner look */
            border: 1px solid black; /* Outer border */
            text-align: left; /* Default alignment for table content */
            background-color: white; /* Optional table background color */
        }

        th, td {
            border: 1px solid black; /* Cell borders */
            padding: 8px; /* Space inside cells */
            text-align: center; /* Center align text inside cells */
        }

        th {
            background-color: #ddd; /* Optional header background color */
        }
    </style>
</head>
<body>
<div>
    @foreach ($result->getTestResults() as $testResult)
        <div>
            <h4>Assessment Report:</h4>
        </div>
        <div>
            <h3>{{$testResult->getTest()->getName()}}</h3>
        </div>
        <br><br>
        <hr>
        <div>
            {{$testResult->getTest()->getName()}}<br>
            @if ($testResult !== null && $testResult->getTestResult() !== null)
                {{$testResult->getTestResult()->getResultLabel()}}
                @if ($testResult->getTestResult()->getResultNotes() !== null)
                    <br>
                    {{$testResult?->getTestResult()?->getResultNotes()}}
                @endif
            @endif
        </div>
        <hr>
        @if ($testResult->getDisplayType()  === ThresholdDisplayType::DISPLAY)
            <table>
                @foreach ($testResult->getPlainResponses() as $plainResponse)
                    <tr>
                        <td>{{$plainResponse->getQuestion()}}</td>
                        <td>{{$plainResponse->getAnswer()}}</td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($testResult->getDisplayType()  === ThresholdDisplayType::TOTAL_SCORE)
            <div>Total Score: {{$testResult->getTestResult()->getScore()}}</div>
        @endif
        @if ($testResult->getSubscaleItems() > 0)
            <table>
                <tr>
                    <td><h3>{{$testResult->getTest()->getName()}} Subscales</h3></td>
                    @for ($i = 1; $i <= $testResult->getSubscaleItems(); $i++)
                        <td>{{$i}}</td>
                    @endfor
                </tr>
                @foreach ($testResult->getSubscaleResults() as $subscaleResult)
                    <tr>
                        <td>{{$subscaleResult->getSubscaleName()}}</td>
                        @for ($i = 1; $i <= $testResult->getSubscaleItems(); $i++)
                            <td>
                                @if ($i === $subscaleResult->getSubscaleIndex())
                                    *
                                @endif
                            </td>
                    @endfor
                @endforeach

            </table>
        @endif
        <br/><br/>
    @endforeach
</div>
</body>
</html>