@extends('layouts.app')

@section('title', __('global.companies'))

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.companies') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ __('global.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('global.companies') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">

                @if(
                    (Session::has('success')) || 
                    (Session::has('danger')) || 
                    (Session::has('info')) || 
                    (Session::has('warning'))
                )
                    @include('components.alert.index')
                @endif

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">{{ __('global.companies') }}</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">

                        <div class="pull-right mb-2">

                            <!-- NEW company -->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'href' => route('companies.create'),
                                    'icon' => 'fas fa-plus',
                                    'title' => __('global.create_company')
                                ]
                            )

                            @if( request()->has('view_deleted') )
                            <!-- View All -->
                            <!--<a class="btn btn-info" href="{{ route('companies.index') }}">View All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-info',
                                    'title' => __('global.view_all'),
                                    'href' => route('companies.index'),
                                    'icon' => 'fas fa-eye'
                                ]
                            )
                            <!-- Restore All -->
                            <!--<a class="btn btn-success" href="{{ route('companies.restore.all') }}">Restore All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'href' => route('companies.restore.all'),
                                    'title' => __('global.restore_all'),
                                    'icon' => 'fas fa-trash-arrow-up'
                                ]
                            )
                            @else
                            <!-- View All Deleted -->
                            <!--<a class="btn btn-primary" href="{{ route('companies.index', ['view_deleted' => 'DeletedRecords']) }}">View Deleted</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-primary',
                                    'title' => __('global.view_deleted'),
                                    'href' => route('companies.index', ['view_deleted' => 'DeletedRecords']),
                                    'icon' => 'fas fa-eye'
                                ]
                            )
                            @endif
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('global.name') }}</th>
                                    <th class="col-md-3">{{ __('global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $companies as $company )
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>
                                        @if( request()->has('view_deleted') )
                                            <!-- RESTORE button -->
                                            <!--<a href="{{ route('companies.restore', $company->id) }}" class="btn btn-success">RESTORE</a>-->
                                            @include('components.buttons.restore', ['href' => route('companies.restore', $company->id)])
                                        @else
                                        <!-- 'companies.delete', $company->id) -->
                                        <form method="post" 
                                              action="{{ route('companies.destroy', $company) }}">

                                            <!-- EDIT button -->
                                            <!--<a href="{{ route('companies.edit', $company->id) }}" class="btn btn-info">EDIT</a>-->
                                            @include('components.buttons.edit', ['href' => route('companies.edit', $company->id)])

                                            @csrf
                                            @method('DELETE')
                                            <!-- DELETE button -->
                                            <!--<button class="btn btn-danger show_confirm" type="submit">DELETE</button>-->
                                            @include('components.buttons.delete')
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection