@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Person</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('companies') }}">Persons</a></li>
                        <li class="breadcrumb-item active">Person</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                    </div>
                    <!-- /.card-header -->

                    <form action="{{ route('persons.store') }}" method="POST">
                        @csrf
                        <div class="card-body">

                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name" 
                                       class="col-sm-2 col-form-label"
                                >Name</label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" name="name" 
                                           class="form-control is-invalid" 
                                           placeholder="Name">
                                    @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                                
                            <button type="submit" 
                                    class="btn btn-info"
                            >Save</button>

                            <a class="btn btn-default float-right" 
                                href="{{ route('persons.index') }}" 
                                enctype="multipart/form-data"
                            >Back</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection