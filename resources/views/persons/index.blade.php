@extends('layouts.app')

@section('title', __('global.persons'))

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.persons') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ __('global.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('global.persons') }}</li>
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
                    ( Session::has('success') ) || 
                    ( Session::has('error') ) || 
                    ( Session::has('info') ) || 
                    ( Session::has('warning') ) 
                )
                    @include('components.alert.index')
                @endif

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">{{ __('global.persons') }}</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">

                        <div class="pull-right mb-2">

                            <!-- NEW Person -->
                            <!--<a class="btn btn-success" href="{{ route('persons.create') }}"><i class="fas fa-plus"></i>Create Person</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'title' => __('global.create_person'),
                                    'href' => route('persons.create'),
                                    'icon' => 'fas fa-plus'
                                ]
                            )

                        @if( request()->has('view_deleted') )
                            <!-- View All -->
                            <!--<a class="btn btn-info" href="{{ route('persons.index') }}">View All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-info',
                                    'title' => __('global.view_all'),
                                    'href' => route('persons.index'),
                                    'icon' => 'fas fa-eye'
                                ]
                            )
                            <!-- Restore All -->
                            <!--<a class="btn btn-success" href="{{ route('persons.restore.all') }}">Restore All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'href' => route('persons.restore.all'),
                                    'title' => __('global.restore_all'),
                                    'icon' => 'fas fa-trash-arrow-up'
                                ]
                            )
                        @else
                            <!-- View All Deleted -->
                            <!--<a class="btn btn-primary" href="{{ route('persons.index', ['view_deleted' => 'DeletedRecords']) }}">View Deleted</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-primary',
                                    'title' => __('global.view_deleted'),
                                    'href' => route('persons.index', ['view_deleted' => 'DeletedRecords']),
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
                                    <th>{{ __('global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $persons as $person )
                                <tr>
                                    <td>{{ $person->id }}</td>
                                    <td>{{ $person->name }}</td>
                                    <td>
                                    @if( request()->has('view_deleted') )
                                        <!-- RESTORE button -->
                                        <!--<a href="{{ route('persons.restore', $person->id) }}" class="btn btn-success">RESTORE</a>-->
                                        @include('components.buttons.restore', ['href' => route('persons.restore', $person->id)])
                                    @else
                                        <form method="post" 
                                              action="{{ route('persons.destroy', $person->id) }}">
                                            
                                            <!-- EDIT button -->
                                            <!--<a href="{{ route('persons.edit', $person->id) }}" class="btn btn-info">EDIT</a>-->
                                            @include('components.buttons.edit', ['href' => route('persons.edit', $person->id)])

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