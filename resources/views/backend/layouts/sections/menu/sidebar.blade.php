@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @if(!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{url('/')}}" class="app-brand-link">
              <span class="app-brand-logo " style="width: 60%; height:100%">
                  <img src="{{ Vite::asset('resources/images/logo/Logo_White.svg') }}" style="width: 100%;" alt class="h-auto">
              </span>
                {{--      <span class="app-brand-text demo menu-text fw-bold">{{config('appVariables.templateName')}}</span>--}}
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif



    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

            @if(Auth::user()->can('admin.tests.view'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text"> {{ __('Manage Tests') }} </span>
            </li>
            <li class="menu-item has-sub {{ activeClass(request()->is('admin/tests*'),'open') }}">
                <a class="menu-link menu-toggle" href="#">
                    <i class="menu-icon tf-icons ti ti-checklist"></i>
                    <span class="menu-title">{{ __('Tests') }}</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ activeClass(request()->is('admin/tests/questions'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.questions.index') }}">
                            <span class="menu-title">{{__("Questions")}}</span>
                        </a>
                    </li>
                    @if(Auth::user()->can('admin.instructions.view'))
                    <li class="menu-item {{ activeClass(request()->is('admin/tests/instructions'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.instructions.index') }}">
                            <span class="menu-title">{{__("Instructions")}}</span>
                        </a>
                    </li>
                    @endif
                    {{--<li class="menu-item {{ activeClass(request()->is('admin/tests/references'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.references') }}">
                            <span class="menu-title">{{__('References')}}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ activeClass(request()->is('admin/tests/categories'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.categories') }}">
                            <span class="menu-title">{{__('Categories')}}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ activeClass(request()->is('admin/tests/responses'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.responses') }}">
                            <span class="menu-title">{{__('Responses')}}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ activeClass(request()->is('admin/tests/instructions'),'active') }}">
                        <a class="menu-link" href="{{ route('tests.instructions') }}">
                            <span class="menu-title">{{__("Instructions")}}</span>
                        </a>
                    </li>--}}
                </ul>
            </li>
           @endif

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text"> {{ __('Manage App') }} </span>
            </li>

            <li class="menu-item {{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('admin.home') }}">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <span class="menu-title" >
                    {{__('Home')}}
                </span>
                </a>
            </li>


            @if(Auth::user()->can('admin.access.user'))
                <li class="menu-item {{ activeClass(request()->is('admin/users*'),'open active') }}">
                    <a class="menu-link menu-toggle" href="#">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <span class="menu-title"> {{__('Manage Users')}}</span>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item {{ activeClass(request()->is('admin/users'),'active') }}">
                            <a class="menu-link" href="{{ route('admin.users.index') }}">
                            <span class="menu-title" >
                                {{__('Active Users')}}
                            </span>
                            </a>
                        </li>
                        <li class="menu-item {{ activeClass(request()->is('admin/users/deactivated'),'active') }}">
                            <a class="menu-link" href="{{ route('admin.users.deactivated') }}">
                            <span class="menu-title" >
                                {{__('Not Active Users')}}
                            </span>
                            </a>
                        </li>
                        <li class="menu-item {{ activeClass(request()->is('admin/users/deleted'),'active') }}">
                            <a class="menu-link" href="{{ route('admin.users.deleted') }}">
                            <span class="menu-title" >
                                {{__('Deleted Users')}}
                            </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->can('crud roles'))
                <li class="menu-item {{ activeClass(request()->is('admin/roles*'),'active') }}">
                    <a class="menu-link" href="{{ route('admin.roles.index') }}">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <span class="menu-title">{{ __('User Roles') }}</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('settings.view'))
                <li class="menu-item has-sub {{ activeClass(request()->is('admin/app-settings*'),'open') }}">
                    <a class="menu-link menu-toggle" href="#">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <span class="menu-title">{{ __('Settings Admin') }}</span>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ activeClass(request()->is('admin/app-settings'),'active') }}">
                            <a class="menu-link" href="{{ route('admin.setting.index') }}">
                                <span class="menu-title">Cache & Optimizations</span>
                            </a>
                        </li>
                    </ul>
                    @if(Auth::user()->hasRole('Administrator|super-admin'))
                        <ul class="menu-sub">
                            <li class="menu-item {{ activeClass(request()->is('log-viewer*'),'active') }}">
                                <a class="menu-link" href="{{ route('log-viewer::logs.list') }}">
                                    <i class="menu-icon tf-icons ti ti-list"></i>
                                    <span class="menu-title" >
                                Admin Logs
                            </span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            @endif
        </ul>


</aside>
