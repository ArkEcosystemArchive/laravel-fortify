@extends('layouts.app')

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.sign_up')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

            <div class="mt-5 lg:mt-8">
                <livewire:auth.register-form />
            </div>
        </div>
    </div>
@endsection
