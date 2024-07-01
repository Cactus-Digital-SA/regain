@php
    /**
     * @var array<App\Domains\Language\Models\Language> $languages
    */
@endphp
@extends('backend.layouts.app')

@section('title', 'Create Instructions')

@section('vendor-style')
    @include('includes.datatable_styles')
    @vite([])
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
        <a href="{{route('tests.instructions.index')}}">{{__('Instructions')}}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('tests.instructions.create')}}">{{__('Create Instruction')}}</a>
    </li>
@endsection

@section('content')
    <form id="form" method="POST" action="{{ route('tests.instructions.store') }}" class="form-horizontal">
        @csrf
    <div class="row">
        <div class="col-md-12">
        @foreach($languages as $language)
           <div class="card mb-4">
                <h5 class="card-header">{{ $language->getName() }}</h5>
                <div class="card-body">
                    <div>
                        <input type="text" name="instructions[{{$language->getId()}}]" class="form-control" placeholder="Instruction" aria-describedby="instruction" />
                        <div class="form-text">This will be shown to the patient as an instruction.</div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
        <div class="row">
            <div class="col text-end">
                <button class="btn btn-primary float-right" type="submit"> {{ __('Create Instruction') }}</button>
            </div><!--row-->
        </div><!--row-->
    </form>
@endsection


@section('page-script')
    @vite('resources/assets/js/form-basic-inputs.js')
@endsection
