@php
    /**
    * @var App\Domains\Auth\Models\User $user
    * */
@endphp
@extends('backend.layouts.app')

@section('title', 'Ενημέρωση Χρήστη')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('backend.auth.users.includes.account-header')

            <form id="form" method="POST" action="{{ route('admin.users.update',$user->getId()) }}" class="form-horizontal">
                @csrf
                @method('PATCH')
                <div class="row justify-content-center mt-4">
                    <!-- User Sidebar -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <div class="form-group row mb-1 mt-1">
                                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $user->getName() }}" maxlength="100" required />
                                    </div>
                                </div>
                                <div class="form-group row mb-1 mt-1">
                                    <label for="email" class="col-md-2 col-form-label">@lang('E-mail Address')</label>
                                    <div class="col-md-10">
                                        <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $user->getEmail() }}" maxlength="255" required />
                                    </div>
                                </div>

                                @include('backend.auth.includes.roles')

                                @include('backend.auth.includes.permissions')
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col text-end">
                                        <button class="btn btn-primary float-right" type="submit">Ενημέρωση Χρήστη</button>
                                    </div><!--row-->
                                </div><!--row-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('after-scripts')
    <script type="module">

    </script>
@endpush
