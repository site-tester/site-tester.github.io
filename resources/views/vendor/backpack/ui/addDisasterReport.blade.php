@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.add') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? trans('backpack::crud.add') . ' ' . $crud->entity_name !!}</p>
    </section>
@endsection

@section('content')
    <div class="row" bp-section="crud-operation-create">
        <div class="{{ $crud->getCreateContentClass() }}">
            {{-- Default box --}}

            @include('crud::inc.grouped_errors')

            <form class="" method="post" action="{{ url($crud->route) }}"
                @if ($crud->hasUploadFields('create')) enctype="multipart/form-data" @endif>
                {!! csrf_field() !!}
                {{-- load the view from the application if it exists, otherwise load the one in the package --}}
                @if (view()->exists('vendor.backpack.crud.add_disaster_request_form_content'))
                    @include('vendor.backpack.crud.add_disaster_request_form_content', [
                        'fields' => $crud->fields(),
                        'action' => 'create',
                    ])
                @else
                    @include('crud::add_disaster_request_form_content', ['fields' => $crud->fields(), 'action' => 'create'])
                @endif



                {{-- This makes sure that all field assets are loaded. --}}
                <div class="d-none" id="parentLoadedAssets">{{ json_encode(Basset::loaded()) }}</div>
                <div class="text-center">
                    @include('crud::inc.form_add_disaster_report_buttons')
                </div>
            </form>
        </div>
    </div>
@endsection
