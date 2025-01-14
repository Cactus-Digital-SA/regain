<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('frontend.content.mock.includes.navbar')
@vite(['resources/css/patient-index.css'])

<div class="dob-container-questions">
    <div class="d-flex justify-content-between align-items-center" style="width: 99%; margin: 0 auto">
        <a href="#" class="btn btn-link text-decoration-none">&larr; Back</a>
        <a href="#" class="btn btn-link text-decoration-none d-flex align-items-center justify-content-center"
           style="display: inline-block; width: 1.8rem; height: 1.8rem; background-color: #757CA0; border-radius: 50%; color: white; text-decoration: none;"><span
                style="position: relative; top: 2px;">i</span></a>
    </div>
    <div class="container px-5 py-2 pb-5">
        <h3 class="text-center mt-0 mb-2 text-nowrap dob-title">What is your current location?</h3>
        <p class="text-center text-muted choice mb-5">Choose one below.</p>
        <form class="mb-0" onsubmit="return false;">
            <ul class="list-unstyled grid-layout mb-5">
                @if(isset($locations))
                    @foreach($locations as $location)
                        <li>
                            <input type="radio" id="toggle-location-radio-{{ $loop->index }}" name="location"
                                   class="me-2">
                            <label for="toggle-location-radio-{{ $loop->index }}" class="toggle">
                                <span class="radio-label round">{{ $location }}</span>
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3" style="max-width:53%">Next</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
