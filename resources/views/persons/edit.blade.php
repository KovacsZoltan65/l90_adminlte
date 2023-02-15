@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Person</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('persons') }}">Persons</a></li>
                        <li class="breadcrumb-item active">Person</li>
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
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                    </div>
                    <!-- /.card-header -->

                    <form action="{{ route('persons.update', $person) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" 
                                           class="col-sm-2 col-form-label"
                                    >Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="name" name="name" 
                                               class="form-control is-invalid" 
                                               placeholder="Name" 
                                               value="{{ $person->name }}">
                                        @error('name')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div> <!-- /.card-body -->

                        </div>

                        <div class="card-footer">
                            
                            <!-- SAVE button -->
                            <button type="submit" 
                                    class="btn btn-info"
                            >Save</button>

                            <!-- BACK button -->
                            <a class="btn btn-default float-right" 
                               href="{{ route('persons.index') }}"
                            >Back</a>
                        </div> <!-- /.card-footer -->

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection