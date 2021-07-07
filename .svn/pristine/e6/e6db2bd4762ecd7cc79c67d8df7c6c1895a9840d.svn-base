@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.blog.display.title') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <a href="{{ route('addBlog') }}" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down"> {{ __('login.page.blog.display.btn_create') }}</a>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.blog.display.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('adminBlogs') }}">{{ __('login.page.blog.display.breadcrumb_blog') }}</a></li>
                @if($text_search_blog ?? '' != null)
                <li class="breadcrumb-item active">{{ __('login.page.blog.display.breadcrumb_search') }}</li>
                @else
                <li class="breadcrumb-item active">{{ __('login.page.blog.display.breadcrumb_view') }}</li>
                @endif
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <div class="row">
            <!-- Column -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('login.page.blog.display.image') }}</th>
                                        <th>{{ __('login.page.blog.display.field_title') }}</th>
                                        <th>{{ __('login.page.blog.display.description') }}</th>
                                        <!-- <th>{{ __('login.page.blog.display.products') }}</th> -->
                                        <th>{{ __('login.page.blog.display.user') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $items)
                                    <tr>
                                        <td>{{ $items['id'] }}</td>
                                        <td>
                                            <img src="{{ asset('storage') }}/blog_images/{{$items['image']}}" alt="" style="width:auto;height:150px;">
                                        </td>
                                        <td>{{ $items['title'] }}</td>
                                        <td>{{ $items['description'] }}</td>
                                        <!-- <td>
                                        @if(isset($items['products']))
                                            <ul>
                                            @foreach($items['products'] as $item)
                                                <li>{{ $item['name'] }}</li>
                                            @endforeach
                                            </ul>
                                        @endif
                                        </td> -->
                                        <td>{{ $items['user_name'] }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a href="{{ route('editBlog',['id' => $items['id'] ]) }}"><button class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i> {{ __('login.page.blog.display.btn_edit') }}</button></a>
                                                <a href="{{ route('deleteBlog',['id' => $items['id'] ]) }}"><button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> {{ __('login.page.blog.display.btn_delete') }}</button></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/displayBlog.js') }}"></script>

@endsection
