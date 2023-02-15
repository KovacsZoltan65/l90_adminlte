@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Company</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('companies') }}">Companies</a></li>
                        <li class="breadcrumb-item active">Company</li>
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

                    <form id="frmCompany" name="frmCompany" 
                          action="{{ route('companies.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="name" 
                                       class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" 
                                           id="name" placeholder="Name" 
                                           aria-describedby="span_name"
                                           value="">
                                    <span id="span_name" name="span_name" 
                                          class="help-block invalid-feedback" 
                                          style="display: block;">
                                        <?php echo ($errors->has('name')) ? $errors->first('name') : ''; ?>
                                    </span>
                                </div>
                            </div>

                        </div> <!-- /.card-body -->

                        <div class="card-footer">

                            <button type="submit" class="btn btn-info">Save</button>

                            <a class="btn btn-default float-right" href="{{ route('companies.index') }}" enctype="multipart/form-data">Back</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection

<script>
    $(function(){
        $validator.setDefaults({
            submitHandler: function(){
                alert('Form successful submitted!');
            }
        });
        $('#frmCompany').validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "A név megadása kötelező"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element){},
            highlight: function(element, errorClass, validClass){},
            unhighlight: function (element, errorClass, validClass) {}
        });
    });
</script>