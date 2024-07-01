@php
    /**
     * @var array<App\Domains\Language\Models\Language> $languages
     * @var array<App\Domains\Tests\Models\Instruction> $instructions
     * @var array<App\Domains\Tests\Models\Test> $tests
     * @var array<App\Domains\Tests\Models\Reference> $references
     * @var array<App\Domains\Tests\Models\Response> $responses
     * @var array<App\Domains\Tests\Models\Subscale> $subscales
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
        @foreach($languages as $language)
           <div class="card mb-4">
                <h5 class="card-header">{{ $language->getName() }}</h5>
                <div class="card-body">
                    <div>
                        <input type="text" name="questions[{{$language->getId()}}]" class="form-control" placeholder="Question" aria-describedby="questions" />
                        <div class="form-text">This is the question that will be shown to the patient.</div>
                    </div>
                </div>
            </div>
        @endforeach

            <div class="card mb-4">
                <h5 class="card-header">{{ __('Responses & References') }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <select name="responses[]" multiple class="form-control select2" data-placeholder="Select Responses">
                                <option></option>
                                @foreach($responses as $response)
                                    <option value="{{ $response->getId() }}">{{ $response->getTitle() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-4">
                            <select name="references[]" multiple class="form-control select2" data-placeholder="Select References">
                                <option></option>
                                @foreach($references as $reference)
                                    <option value="{{ $reference->getId() }}">{{ $reference->getTitle() }}</option>
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
                                <select name="instruction_id" class="form-control select2" data-placeholder="Select Instruction">
                                    <option></option>
                                    @foreach($instructions as $instruction)
                                        <option value="{{ $instruction->getId() }}">{{ $instruction->getContent() }}</option>
                                    @endforeach
                                </select>

                                <div class="form-text">This is the instruction that will be shown to the patient.</div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div>
                                <select name="subscale_id" class="form-control select2" data-placeholder="Select Subscale">
                                    <option></option>
                                    @foreach($subscales as $subscale)
                                        <option value="{{ $subscale->getId() }}">{{ $subscale->getName() }}</option>
                                    @endforeach
                                </select>

                                <div class="form-text">This is the instruction that will be shown to the patient.</div>
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
@endsection
