@extends('layouts.app', ['fullWidth' => true])

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.reset_password')],
    ]" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

    <div class="max-w-xl py-8 mx-auto">
        <livewire:auth.reset-password-form />
    </div>
@endsection
