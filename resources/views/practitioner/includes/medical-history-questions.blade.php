<div class="modal-body" id="modal-container">
    <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
    </button>
    <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">Medical History</h3>

    @foreach ($presenter->getQuestions() as $question)
        <div
                class="question-container row g-4 {{$question->isHiddenBecauseOfRequired() ? "hidden" : ""}}"
                data-hide="{{$question->isHiddenBecauseOfRequired() ? "true" : "false"}}"
                data-user-input="{{$question->isUserInput() ? "true" : "false" }}"
                style="margin-bottom: 50px;">
            <form
                    id="input-form_{{$question->getId()}}"
                    class="collect-question"
                    data-question-id="{{$question->getId()}}"
                    data-condition-question-id="{{$question->getRequiredQuestionId()}}"
                    data-condition-required-response-ids="[{{implode(", ", $question->getRequiredQuestionResponseIds())}}]"
                    @if ($question->isSelectMultiple())
                        data-max-selections="{{count($question->getResponses())}}"
                    @else
                        data-max-selections="1"
                    @endif
            >
                <div class="col-md-12">
                    <label for="mobility-visible" class="form-label">{{$question->getTitle()}}</label>
                    <div class="row">
                        @if (!$question->isUserInput())
                            @foreach ($question->getResponses() as $response)
                                @csrf
                                <div class="col-6">
                                    <input
                                            type="checkbox"
                                            class="select-response btn-check"
                                            data-question-id="{{$question->getId()}}"
                                            data-response-id="{{$response->getId()}}"
                                            id="response-{{$question->getId()}}-{{$response->getId()}}"
                                            name="response-{{$question->getId()}}"
                                    >
                                    <label
                                            class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center"
                                            for="response-{{$question->getId()}}-{{$response->getId()}}">
                                        {{ $response->getTitle() }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <textarea
                                        data-question-id="{{$question->getId()}}"
                                        name="response-{{$question->getId()}}"
                                        class="form-control select-response" style="min-height: 200px"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    @endforeach
    <div class="col-md-12 mt-5 d-flex justify-content-end">
        <button type="submit" class="custom-next-btn" id="next-button">Next</button>
    </div>
</div>
<div id="overlay" class="overlay">
    <div class="spinner"></div>
</div>
<style>
    /* Make sure the overlay covers the entire screen or modal */
    .overlay {
        position: fixed; /* Position the overlay fixed to the screen */
        top: 0;
        left: 0;
        width: 100%; /* Cover the entire width of the viewport */
        height: 100%; /* Cover the entire height of the viewport */
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        display: flex; /* Use flexbox to center the spinner */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        z-index: 9999; /* Make sure it's on top of other content */
        visibility: hidden; /* Initially hidden (can be toggled later) */
    }

    /* Spinner styling */
    .overlay .spinner {
        border: 4px solid #f3f3f3; /* Light gray border */
        border-top: 4px solid #3498db; /* Blue border on top */
        border-radius: 50%; /* Circular shape */
        width: 50px; /* Size of the spinner */
        height: 50px; /* Size of the spinner */
        animation: spin 2s linear infinite; /* Spinning animation */
    }

    /* Keyframe animation for spinning */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>