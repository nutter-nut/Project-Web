@extends('layouts.tp-fastener-index.index')

@section('center')
<section class="main_container">
    <div class="container-fastener">
        <main style="background-color: white;">

            <ol class="breadcrumb breadcrumb-arrow mb-5">
                <li><a href="{{ route('Index') }}">{{ __('index.checkout.breadcrumb_home') }}</a></li>
                <li class="active"><span>{{ __('index.header.blog') }}</span></li>
            </ol>

            <div class="container">
                @include('alert')
            </div>

            <!--? Blog Area Start-->
            <br>
            <section-page class="blog_area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-8 mb-5 mb-lg-0">
                            <div class="blog_left_sidebar">
                                @if($blogs[0]->items==null)
                                    <h3>{{ __('index.blog.not_found') }}</h3>
                                @endif
                                @foreach($blogs[0]->items as $key => $item)
                                    <article class="blog_item">
                                        <div class="blog_item_img">
                                            <a href="{{ route('blogDetails',['id' => $item['id'] ]) }}" >
                                                <img class="card-img rounded-0" src="{{ asset('storage') }}/blog_images/{{$item['image']}}" alt="">
                                            </a>
                                            <a href="{{ route('blogDetails',['id' => $item['id'] ]) }}" class="blog_item_date">
                                                <h4 class="font-weight-bold">{{ $item['date'][0] }}</h4>
                                                <p>{{ $item['date'][1][1] }}</p>
                                            </a>
                                        </div>
                                        <div class="blog_details">
                                            <a class="d-inline-block" href="{{ route('blogDetails',['id' => $item['id'] ]) }}">
                                                <h2 class="blog-head" style="color: #2d2d2d;">{{ $item['title'] }}</h2>
                                            </a>
                                            <div class="blog_text">
                                                {!! $item['description'] !!}
                                            </div>
                                            <br>
                                            <ul class="blog-info-link">
                                                <li><a href="#"><i class="fa fa-user"></i> {{ $item['user_name'] }}</a></li>
                                                <li><a href="#"><i class="fa fa-comments"></i> {{ $blogs[1][$key] }} {{ __('index.blog.comments') }}</a></li>
                                            </ul>
                                        </div>
                                    </article>
                                @endforeach
                                <nav class="blog-pagination justify-content-center d-flex">
                                    <ul class="pagination">
                                    @foreach ($blogs[0]->links as $key => $values)
                                        <li class="{{$values['stly_classes']}}">
                                            <a href="?page={{$values['page']}}" class="page-link" aria-label="Previous">
                                                {{$values['icon']}}
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-7 mb-lg-0">
                            @include('layouts.blog_menu')
                        </div>
                        @include('layouts.products_more')
                    </div>
                </div>
                <br>
            </section-page>
            <!-- Blog Area End -->
        </main>
    </div>
</section>

<style>
section-page {
    position: relative;
    width: 100%;
    height: 100vh;
    background: white;
    overflow: hidden;
}

ul {
    margin: 0px;
    padding: 0px;
    list-style-type: none;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1.5rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.blog_right_sidebar .widget_title {
    font-size: 20px;
    margin-bottom: 40px;
}

</style>

@endsection
