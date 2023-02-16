@extends('layouts.app')

@section('title', __('global.edit_person'))

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.edit_person') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('global.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('persons') }}">{{ __('global.persons') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('global.edit_person') }}</li>
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
                        <h3 class="card-title">{{ __('global.basic_data') }}</h3>
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
                                           class="col-sm-2 col-form-label">{{ __('global.name') }}:</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="name" name="name" 
                                               class="form-control is-invalid" 
                                               placeholder="{{ __('global.name') }}" 
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
                            @include('components.buttons.save')
                            <!-- BACK button -->
                            @include('components.buttons.cancel', ['href' => route('persons.index')])
                            
                        </div> <!-- /.card-footer -->

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection