@extends('layouts.app')

@section('title', __('global.products'))

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('global.products') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ __('global.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('global.products') }}</li>
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
                    ( Session::has('danger') ) || 
                    ( Session::has('info') ) ||
                    ( Session::has('warning') )
                )
                @include('components.alert.index')
                <!--<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" 
                            data-dismiss="alert" 
                            aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i>&nbsp;Alert!
                    </h5>
                    {{ $message }}
                </div>-->
                @endif

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">{{ __('global.products') }}</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">

                        <div class="pull-right mb-2">

                            <!-- NEW Product -->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'title' => __('global.create_product'),
                                    'href' => route('products.create'),
                                    'icon' => 'fas fa-plus'
                                ]
                            )

                        @if( request()->has('view_deleted') )
                            <!-- View All -->
                            <!--<a class="btn btn-info" href="{{ route('products.index') }}">View All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-info',
                                    'title' => __('global.view_all'),
                                    'href' => route('products.index'),
                                    'icon' => 'fas fa-eye'
                                ]
                            )

                            <!-- Restore All -->
                            <!--<a class="btn btn-success" href="{{ route('products.restore.all') }}">Restore All</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-success',
                                    'href' => route('products.restore.all'),
                                    'title' => __('global.restore_all'),
                                    'icon' => 'fas fa-trash-arrow-up'
                                ]
                            )
                        @else
                            <!-- View All Deleted -->
                            <!--<a class="btn btn-primary" href="{{ route('products.index', ['view_deleted' => 'DeletedRecords']) }}">View Deleted</a>-->
                            @include(
                                'components.anchor', 
                                [
                                    'class' => 'btn btn-primary',
                                    'title' => __('global.view_deleted'),
                                    'href' => route('products.index', ['view_deleted' => 'DeletedRecords']),
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
                                    <th class="col-md-2">{{ __('global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $products as $product )
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                    @if( request()->has('view_deleted') )
                                        <!-- RESTORE button -->
                                        <!--<a href="{{ route('products.restore', $product->id) }}" class="btn btn-success">RESTORE</a>-->
                                        @include('components.buttons.restore', ['href' => route('products.restore', $product->id)])
                                    @else
                                        <form method="post" 
                                              action="{{ route('products.destroy', $product->id) }}">
                                            
                                            <!-- EDIT button -->
                                            @include('components.buttons.edit', ['href' => route('products.edit', $product->id)])

                                            @csrf
                                            @method('DELETE')
                                            <!-- DELETE button -->
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