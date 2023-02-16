@extends('layouts.app')

@section('title', __('global.edit_company'))

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.edit_company') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{ __('global.home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('companies') }}">{{ __('global.companies') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('global.edit_company') }}</li>
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

                    <form action="{{ route('companies.update', $company->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="name" 
                                       class="col-sm-2 col-form-label">{{ __('global.name') }}:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" 
                                           id="name" placeholder="{{ __('global.name') }}" 
                                           aria-describedby="span_name"
                                           value="{{ $company->name }}">
                                    <span id="span_name" name="span_name" 
                                          class="help-block invalid-feedback" 
                                          style="display: block;">
                                        <?php echo ($errors->has('name')) ? $errors->first('name') : ''; ?>
                                    </span>
                                </div>
                            </div>

                        </div> <!-- /.card-body -->

                        <div class="card-footer">
                            @include('components.buttons.save')
                            
                            @include('components.buttons.cancel', ['href' => route('companies.index')])

                        </div> <!-- /.card-footer -->

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection