<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.1rem;
            justify-items: start;
            max-width: 100%;
            margin: 0 auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .grid-layout li {
            padding: 0 1rem;
            font-size: 15px;
            font-weight: 400;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            color: #27343D;
        }

        input[type="radio"] {
            appearance: none;
            width: 0.9rem;
            height: 0.9rem;
            border: 2px solid #161B2C;
            border-radius: 100%;
            position: relative;
            cursor: pointer;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        input[type="radio"]:hover,
        label.toggle:hover + input[type="radio"] {
            border-color: #555;
        }

        label.toggle:hover + input[type="radio"] {
            background-color: #f0f0f0;
        }

        input[type="radio"]:checked {
            background-color: #333;
            border-color: #333;
        }

        label.toggle {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.3rem 0.3rem;
            border-radius: 0.5rem;
        }

        label.toggle:hover {
            background-color: #f0f0f0;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        input[type="radio"]:checked + label.toggle {
            background-color: #151B2C;
            color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        label.toggle:hover + input[type="radio"]:checked {
            background-color: #333;
            border-color: #333;
        }

        @media (max-width: 990px) {
            .grid-layout {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .grid-layout {
                display: flex;
                flex-direction: column;
                justify-content: start;
                align-items: start;
            }
            .grid-layout ul {
                display: flex;
                flex-wrap: nowrap;
                justify-content: center;
                align-items: center;
                padding: 0;
                margin: 0;
            }
        }

    </style>
</head>
<body>

@include('frontend.content.mock.includes.navbar')

<div class="dob-container">
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
