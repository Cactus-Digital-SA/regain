<!DOCTYPE html>
<html>
<head>
    <title>Mental Health Report</title>

    <style>
        @page {
            size: A4;
            margin: 1in;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo {
            max-width: 100px;
            width: 100%;
        }

        .assessment-title {
            font-size: 11pt;
            font-weight: 500;
            color: #3c3c3c;
            text-align: center;
        }

        .main-title {
            font-size: 12pt;
            font-weight: bold;
        }

        .date {
            font-size: 11pt;
            font-weight: 500;
            color: #3c3c3c;
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
            font-size: 12pt;
            font-weight: bold;
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .overview-bar-container {
            padding-bottom: 5px;
        }

        .overview-content {
            margin: 30px 0 40px 0;
            font-size: 7pt;
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
            font-size: 10pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
            text-align: center;
        }

        td:first-child {
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        .title {
            font-size: 10pt;
            font-weight: bold;
        }

        .description {
            font-size: 9pt;
        }

        .dot {
            height: 8px;
            width: 8px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
        }

        .bar-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 3px;
            height: 30px;
        }

        .bar {
            width: 6px;
            background-color: #333;
        }

        .gray-bar {
            width: 6px;
            background-color: lightgray;
        }

        h1, h2, h3, h4, h5, h6, table {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ Vite::asset('resources/images/logo/regainLogo.svg') }}" alt="Logo" class="logo">
    <div>
        <div class="assessment-title">Assessment Report:</div>
        <div class="main-title">Mental Health and Mental Pain</div>
    </div>
    <div class="date">07.10.2024</div>
</div>

<div class="user-details">
    <p><strong>Olha Maximova</strong></p>
    <p style="color: #3c3c3c;">#145445</p>
    <p style="color: #3c3c3c;">D.O.B. 04/03/1985</p>
</div>
<div class="divider"></div>

<div class="overview">
    <div class="overview-group">
        <div class="overview-title">
            Mental Health and Mental Pain Overview
        </div>
        <div class="overview-bar-container">
            <div class="bar-container">
                <div class="bar-container">
                    <div class="bar" style="height: 7px;"></div>
                    <div class="bar" style="height: 13px;"></div>
                    <div class="bar" style="height: 17px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="overview-content">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
        a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
        remaining essentially unchanged.
    </div>
</div>
<div>
    <table>
        <colgroup>
            <col style="width: 60%;">
            <col style="width: 13.33%;">
            <col style="width: 13.33%;">
            <col style="width: 13.33%;">
        </colgroup>
        <thead>
        <tr>
            <th>Mental Health and Mental Pain Subscales</th>
            <th>
                <div class="bar-container">
                    <div class="bar" style="height: 7px;"></div>
                    <div class="gray-bar" style="height: 13px;"></div>
                    <div class="gray-bar" style="height: 17px;"></div>
                </div>
            </th>
            <th>
                <div class="bar-container">
                    <div class="bar" style="height: 7px;"></div>
                    <div class="bar" style="height: 13px;"></div>
                    <div class="gray-bar" style="height: 17px;"></div>
                </div>
            </th>
            <th>
                <div class="bar-container">
                    <div class="bar" style="height: 7px;"></div>
                    <div class="bar" style="height: 13px;"></div>
                    <div class="bar" style="height: 17px;"></div>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data['subscales'] as $subscale)
            <tr>
                <td>
                    <div class="title">{{ $subscale['title'] }}</div>
                    <div class="description">{{ $subscale['description'] }}</div>
                </td>
                <td>{!! $subscale['indicator_1'] ? '<span class="dot"></span>' : '' !!}</td>
                <td>{!! $subscale['indicator_2'] ? '<span class="dot"></span>' : '' !!}</td>
                <td>{!! $subscale['indicator_3'] ? '<span class="dot"></span>' : '' !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
