@php
    use App\Domains\Instructions\Models\Instruction;
    use App\Domains\References\Models\Reference;
    use App\Domains\Responses\Models\Response;
    use App\Domains\Subscales\Models\Subscale;
        /**
         * @var array<App\Domains\Language\Models\Language> $languages
         * @var array<Instruction> $instructions
         * @var array<App\Domains\Tests\Models\Test> $tests
         * @var array<Reference> $references
         * @var array<Response> $responses
         * @var array<Subscale> $subscales
         * @var array<Response> $professions
        */
@endphp
@extends('backend.layouts.app')

@section('title', 'Create Question')

@section('vendor-style')
    @include('includes.datatable_styles')
    @vite(['resources/assets/vendor/libs/select2/select2.scss',])
@endsection

@section('page-style')
    @vite([])
@endsection

@section('content-header')

@endsection

@section('content-header-breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('tests.questions.index')}}">{{__('Questions')}}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('tests.questions.create')}}">{{__('Create Question')}}</a>
    </li>
@endsection

@section('content')
    <form id="form" method="POST" action="{{ route('tests.questions.store') }}" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Title') }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Title" value="{{ old('title') }}" aria-describedby="title"/>
                                    <div class="form-text">This is the title of the question. It will not show to the
                                        patient.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills" role="tablist">
                            @foreach($languages as $language)
                                <li class="nav-item">
                                    <button type="button" class="nav-link @if($loop->iteration == 1 ) active @endif"
                                            role="tab" data-bs-toggle="tab"
                                            data-bs-target="#language_{{$language->getCode()}}"
                                            aria-controls="#language_{{$language->getCode()}}" aria-selected="true">
                                        {{ $language->getName() }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            @foreach($languages as $language)
                                <div class="tab-pane fade @if($loop->iteration == 1 )show active @endif"
                                     id="#language_{{$language->getCode()}}" role="tabpanel">
                                    <div>
                                        <input type="text" name="questions[{{$language->getId()}}]" class="form-control"
                                               placeholder="Question"
                                               value="{{ old('questions['.$language->getId().']') }}"
                                               aria-describedby="questions"/>
                                        <div class="form-text">This is the question that will be shown to the patient.
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('References') }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <select name="references[]" multiple class="form-control select2"
                                        data-placeholder="Select References">
                                    <option></option>
                                    @foreach($references as $reference)
                                        <option value="{{ $reference->getId() }}">{{ $reference->getTitle() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Responses') }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <select name="responses[]" multiple class="form-control select2"
                                        data-placeholder="Select Responses">
                                    <option></option>
                                    @foreach($responses as $response)
                                        <option value="{{ $response->getId() }}">{{ $response->getTitle() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Professions') }}</h5>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button id="checkAllBtn" class="btn btn-primary">{{__('Check All')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <select name="professions[]" multiple class="form-control select2"
                                        data-placeholder="Select Professions">
                                    <option></option>
                                    @foreach($professions as $profession)
                                        <option value="{{ $profession->getId() }}">{{ $profession->getTitle() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Instruction, Test & Subscale') }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div>
                                    <select name="test_id" class="form-control select2" data-placeholder="Select Test">
                                        <option></option>
                                        @foreach($tests as $test)
                                            <option value="{{ $test->getId() }}">{{ $test->getName() }}</option>
                                        @endforeach
                                    </select>

                                    <div class="form-text">This is the test that this questions belongs to.</div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div>
                                    <select name="instruction_id" class="form-control select2"
                                            data-placeholder="Select Instruction">
                                        <option></option>
                                        @foreach($instructions as $instruction)
                                            <option
                                                value="{{ $instruction->getId() }}">{{ $instruction->getContent() }}</option>
                                        @endforeach
                                    </select>

                                    <div class="form-text">This is the instruction that will be shown to the patient.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div>
                                    <select name="subscale_id" class="form-control select2"
                                            data-placeholder="Select Subscale">
                                        <option></option>
                                        @foreach($subscales as $subscale)
                                            <option value="{{ $subscale->getId() }}">{{ $subscale->getName() }}</option>
                                        @endforeach
                                    </select>

                                    <div class="form-text">This is the instruction that will be shown to the patient.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-end">
                <button class="btn btn-primary float-right" type="submit"> {{ __('Create Question') }}</button>
            </div><!--row-->
        </div><!--row-->
    </form>
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',])
@endsection

@section('page-script')
    @vite([
    'resources/assets/js/form-basic-inputs.js',
    'resources/assets/js/forms-selects.js',
    ])

    <script>
        /**
         * Button click event to check all options
         */
        $('#checkAllBtn').on('click', function() {
            let allValues = [];
            $('select[name="professions[]"] option').each(function() {
                if ($(this).val()) {
                    allValues.push($(this).val());
                }
            });
            $('select[name="professions[]"]').val(allValues).trigger('change');
        });
    </script>
@endsection
