@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.blog.create.title') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.blog.create.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('adminBlogs') }}">{{ __('login.page.blog.create.breadcrumb_blog') }}</a></li>
                <li class="breadcrumb-item active">{{ __('login.page.blog.create.breadcrumb_view') }}</li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>
    <!-- Add product end -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <!-- <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Create Blog</h3>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-xl-12 order-xl-1">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('createBlog') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                                    {{csrf_field()}}
                                    <!-- Address -->

                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">* {{ __('login.page.blog.create.field_title') }}</label>
                                                <input type="text" name="title" class="form-control" placeholder="{{ __('login.page.blog.create.input_title') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">* {{ __('login.page.blog.create.date') }}</label>
                                                <input type="date" name="date" class="form-control" required>
                                            </div>
                                        </div>                                         
                                    </div>

                                    <!-- Description -->
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <textarea id="mytextarea" rows="15" id="description" name="description" class="form-control" placeholder="description of blog ..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <center class=""> 
                                                <img class="img-fluid" id="blah" src="{{ asset('assets/img/product-default.jpg') }}" height="300" width="auto" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>                                      
                                            </center>
                                            <br><br>
                                            <center class=""> 
                                                <input id="image_file" name="image" type="file"
                                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                                    accept="image/x-png,image/gif,image/jpeg" required />
                                                <br>
                                                <small class="text-danger">
                                                    {{ __('login.index.form.image_pattern') }}
                                                </small>
                                            </center>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-12">
                                            <table class="table table-bordered" id="dynamicTable"></table>
                                        </div>
                                    </div> -->
                                    <hr class="my-4" />
                                    <div class="float-left">
                                        <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.blog.display.btn_save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    @include('layouts.textarea')

    @endsection
