@extends('layouts.app')

@section('title', __('global.create_person'))

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.create_person') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('global.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('companies') }}">{{ __('global.persons') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('global.create_person') }}</li>
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
                        <h3 class="card-title">{{ __('global.basic_data') }}</h3>
                    </div>
                    <!-- /.card-header -->

                    <form action="{{ route('persons.store') }}" 
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name" 
                                       class="col-sm-2 col-form-label"
                                >{{ __('global.name') }}:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" name="name" 
                                           class="form-control is-invalid" 
                                           placeholder="{{ __('global.name') }}">
                                    @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            @include('components.buttons.save')

                            @include('components.buttons.cancel', ['href' => route('persons.index')])

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection