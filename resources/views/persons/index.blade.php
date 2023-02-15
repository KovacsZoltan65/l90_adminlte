@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Persons</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Persons</li>
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

                @if( $message = Session::get('success') )
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" 
                            data-dismiss="alert" 
                            aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i>&nbsp;Alert!
                    </h5>
                    {{ $message }}
                </div>
                @endif

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Persons</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">

                        <div class="pull-right mb-2">

                            <!-- NEW Person -->
                            <a class="btn btn-success" href="{{ route('persons.create') }}">Create Person</a>

                        @if( request()->has('view_deleted') )
                            <!-- View All -->
                            <!--<a class="btn btn-info" href="{{ route('persons.index') }}">View All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-info',
                                    'title' => 'View All',
                                    'href' => route('persons.index')
                                ]
                            )
                            <!-- Restore All -->
                            <!--<a class="btn btn-success" href="{{ route('persons.restore.all') }}">Restore All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'href' => route('persons.restore.all'),
                                    'title' => 'Restore All'
                                ]
                            )
                        @else
                            <!-- View All Deleted -->
                            <!--<a class="btn btn-primary" href="{{ route('persons.index', ['view_deleted' => 'DeletedRecords']) }}">View Deleted</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-primary',
                                    'title' => 'View Deleted',
                                    'href' => route('persons.index', ['view_deleted' => 'DeletedRecords'])
                                ]
                            )
                        @endif
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
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
                                        @include(
                                            'components.anchor', 
                                            [
                                                'class' => 'btn btn-success',
                                                'title' => 'RESTORE',
                                                'href' => route('persons.restore', $person->id)
                                            ]
                                        )
                                    @else
                                        <form method="post" 
                                              action="{{ route('persons.destroy', $person->id) }}">
                                            
                                            <!-- EDIT button -->
                                            <!--<a href="{{ route('persons.edit', $person->id) }}" class="btn btn-info">EDIT</a>-->
                                            @include(
                                                'components.anchor', 
                                                [
                                                    'class' => 'btn btn-info',
                                                    'title' => 'EDIT',
                                                    'href' => route('persons.edit', $person->id)
                                                ]
                                            )
                                            @csrf
                                            @method('DELETE')
                                            <!-- DELETE button -->
                                            <!--<button class="btn btn-danger show_confirm" type="submit">DELETE</button>-->
                                            @include(
                                                'components.button', 
                                                [
                                                    'type' => 'submit',
                                                    'title' => 'DELETE',
                                                    'class' => 'btn btn-danger show_confirm'
                                                ]
                                            )
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