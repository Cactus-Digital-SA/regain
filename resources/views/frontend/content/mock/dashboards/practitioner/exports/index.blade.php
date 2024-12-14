<!DOCTYPE html>
<html>
<head>
    <title>Mental Health Report</title>

    @vite(['resources/css/export-assessment-report.css'])
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
    <p><strong>Olha Maximova</strong></p>
    <p>#145445</p>
    <p>D.O.B. 04/03/1985</p>
</div>
<div class="divider"></div>

<div class="overview">
    <div class="overview-title">
        Mental Health and Mental Pain Overview
        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="10" width="4" height="11" fill="#333"></rect>
            <rect x="10" y="6" width="4" height="15" fill="#333"></rect>
            <rect x="17" y="3" width="4" height="18" fill="#fff"></rect>
        </svg>
    </div>
    <div class="divider"></div>
    <div class="overview-content">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
    </div>
</div>
<div>
    <table>
        <thead>
        <tr>
            <th>Mental Health and Mental Pain Subscales</th>
            <th style="text-align: center; width: 20%">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="10" width="4" height="11" fill="#333"></rect>
                    <rect x="10" y="6" width="4" height="15" fill="#fff"></rect>
                    <rect x="17" y="3" width="4" height="18" fill="#fff"></rect>
                </svg>
            </th>
            <th style="text-align: center; width: 20%">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="10" width="4" height="11" fill="#333"></rect>
                    <rect x="10" y="6" width="4" height="15" fill="#333"></rect>
                    <rect x="17" y="3" width="4" height="18" fill="#fff"></rect>
                </svg>
            </th>
            <th style="text-align: center; width: 20%">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="10" width="4" height="11" fill="#333"></rect>
                    <rect x="10" y="6" width="4" height="15" fill="#333"></rect>
                    <rect x="17" y="3" width="4" height="18" fill="#333"></rect>
                </svg>
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
                <td style="text-align: center;">{!! $subscale['indicator_1'] ? '<span class="dot"></span>' : '' !!}</td>
                <td style="text-align: center;">{!! $subscale['indicator_2'] ? '<span class="dot"></span>' : '' !!}</td>
                <td style="text-align: center;">{!! $subscale['indicator_3'] ? '<span class="dot"></span>' : '' !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
