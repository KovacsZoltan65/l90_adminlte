@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Companies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Companies</li>
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
                    @include('components.alert.index')
                <!--
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" 
                            data-dismiss="alert" 
                            aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i>&nbsp;Alert!
                    </h5>
                    {{ $message }}
                </div>
                -->
                @endif

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Companies</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">

                        <div class="pull-right mb-2">

                            <!-- NEW company -->
                            <a class="btn btn-success" href="{{ route('companies.create') }}">Create Company</a>

                            @if( request()->has('view_deleted') )
                            <!-- View All -->
                            <a class="btn btn-info" href="{{ route('companies.index') }}">View All</a>
                            <!-- Restore All -->
                            <a class="btn btn-success" href="{{ route('companies.restore.all') }}">Restore All</a>
                            @else
                            <!-- View All Deleted -->
                            <a class="btn btn-primary" href="{{ route('companies.index', ['view_deleted' => 'DeletedRecords']) }}">View Deleted</a>
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
                                @foreach( $companies as $company )
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>
                                        @if( request()->has('view_deleted') )
                                        <!-- RESTORE button -->
                                        <a href="{{ route('companies.restore', $company->id) }}" 
                                           class="btn btn-success">RESTORE</a>
                                        @else
                                        <!-- 'companies.delete', $company->id) -->
                                        <form method="post" 
                                              action="{{ route('companies.destroy', $company) }}">

                                            <!-- EDIT button -->
                                            <a href="{{ route('companies.edit', $company->id) }}" 
                                               class="btn btn-info">EDIT</a>

                                            @csrf
                                            @method('DELETE')
                                            <!-- DELETE button -->
                                            <button class="btn btn-danger show_confirm" 
                                                    type="submit">DELETE</button>
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