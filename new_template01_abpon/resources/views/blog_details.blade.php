@extends('layouts.tp-fastener-index.index')

@section('center')
<section class="main_container">
    <div class="container-fastener">
        <main style="background-color: white;">
            <ol class="breadcrumb breadcrumb-arrow mb-5">
                <li><a href="{{ route('Index') }}">{{ __('index.checkout.breadcrumb_home') }}</a></li>
                <li><a href="{{ route('Blog') }}">{{ __('index.header.blog') }}</a></li>
                <li class="active"><span>{{ $blog['title'] }}</span></li>
            </ol>

            <div class="container">
                @include('alert')
            </div>

            <!--? Blog Area Start -->
            <br>
            <section-page class="blog_area single-post-area section-padding">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-lg-8 posts-list"> -->
                        <div class="col-12 col-sm-8 col-md-8 posts-list">
                            <div class="single-post">
                                <div class="feature-img">
                                    <img class="img-fluid" src="{{ asset('storage') }}/blog_images/{{$blog['image']}}" alt="">
                                </div>
                                <div class="blog_details">
                                    <h2 style="color: #2d2d2d;">{{ $blog['title'] }}</h2>
                                    <ul class="blog-info-link mt-3 mb-4">
                                        <li><a href="#"><i class="fa fa-user"></i> {{ $blog['user_name'] }}</a></li>
                                        <li><a href="#"><i class="fa fa-comments"></i> {{ $comment_count }} {{ __('index.blog_detail.comments') }}</a></li>
                                    </ul>
                                    {!! $blog['description'] !!}
                                </div>
                            </div>
                            <div class="navigation-top">
                                <div class="d-sm-flex justify-content-between text-center">
                                @php
                                if(isset($blog['like'])){
                                    $count_like = count($blog['like']);
                                }else{
                                    $count_like = 0;
                                }
                                @endphp
                                    @if($like_status == true)
                                        <a href="{{ route('blogUnLike', ['id' => $blog['id'] ]) }}"><p class="like-info"><span class="align-middle"><i class="fa fa-heart" style="color: coral;"></i></span> {{ __('index.blog_detail.like_start') }} {{ $count_like }} {{ __('index.blog_detail.like_end') }}</p></a>
                                    @elseif($like_status == false)
                                        <a href="{{ route('blogLike', ['id' => $blog['id'] ]) }}"><p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> {{ __('index.blog_detail.like_start') }} {{ $count_like }} {{ __('index.blog_detail.like_end') }}</p></a>
                                    @else
                                        <p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> {{ __('index.blog_detail.like_start') }} {{ $count_like }} {{ __('index.blog_detail.like_end') }}</p>
                                    @endif
                                    <div class="col-sm-4 text-center my-2 my-sm-0">
                                    </div>
                                    <ul class="social-icons">
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                    </ul>
                                </div>
                                <div class="navigation-area">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                        @if(isset($before))
                                            <div class="thumb">
                                                <a href="{{ route('blogDetails', ['id' => $before['id'] ]) }}">
                                                    <img class="img-fluid" src="{{ asset('storage') }}/blog_images/{{$before['image']}}" width="60" height="60" alt="">
                                                </a>
                                            </div>
                                            <div class="arrow">
                                                <a href="{{ route('blogDetails', ['id' => $before['id'] ]) }}">
                                                    <span class="lnr text-white ti-arrow-left"></span>
                                                </a>
                                            </div>
                                            <div class="detials">
                                                <p>{{ __('index.blog_detail.prev_post') }}</p>
                                                <a href="{{ route('blogDetails', ['id' => $before['id'] ]) }}">
                                                    <h4 style="color: #2d2d2d;">{{ $before['title'] }}</h4>
                                                </a>
                                            </div>
                                        @endif
                                        </div> 
                                        <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                        @if(isset($next))
                                            <div class="detials">
                                                <p>{{ __('index.blog_detail.next_post') }}</p>
                                                <a href="{{ route('blogDetails', ['id' => $next['id'] ]) }}">
                                                    <h4 style="color: #2d2d2d;">{{ $next['title'] }}</h4>
                                                </a>
                                            </div>
                                            <div class="arrow">
                                                <a href="{{ route('blogDetails', ['id' => $next['id'] ]) }}">
                                                    <span class="lnr text-white ti-arrow-right"></span>
                                                </a>
                                            </div>
                                            <div class="thumb" style="padding-left: 15px;">
                                                <a href="{{ route('blogDetails', ['id' => $next['id'] ]) }}">
                                                    <img class="img-fluid" src="{{ asset('storage') }}/blog_images/{{$next['image']}}" width="60" height="60" alt="">
                                                </a>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comments-area">
                                {{-- <h4>{{ $comment_count }} {{ __('index.blog_detail.comments') }}</</h4> --}}
                                @foreach($comments[0]->items as $key => $item)
                                <div class="comment-list">
                                    <div class="single-comment justify-content-between d-flex" style="@if(isset($comment_edit) && $comment_edit['id'] == $item['id']) background-color: bisque;border-radius: 30px; @endif">
                                        <div class="user justify-content-between d-flex">
                                            <div class="thumb">
                                                <img src="{{ asset('storage') }}/user_images/{{$item['user_image']}}" width="70" height="70" alt="">
                                            </div>
                                            <div class="desc">
                                                <p class="comment">{{ $item['text'] }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <h5>
                                                            <a href="#">{{ $item['user_name'] }}</a>
                                                        </h5>
                                                        <!-- <p class="date">December 4, 2017 at 3:12 pm </p> -->
                                                        <p class="date">{{ $comments[1][$key] }}</p>
                                                    </div>
                                                    @if(Auth::check() && $item['user_id'] == Auth::user()->id)
                                                    <div class="row">
                                                        <div class="btn-reply">
                                                            <a href="{{ route('editComment', ['blog' => $blog['id'], 'comment' => $item['id'] ]) }}"><i class="fa fa-edit" style="color: coral;"></i></a>
                                                            <a href="{{ route('deleteComment', ['id' => $item['id'] ]) }}"><i class="fa fa-trash" style="color: coral;"></i></a>                                                
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <nav class="blog-pagination justify-content-center d-flex" style="margin-top: 0px">
                                    <ul class="pagination">
                                    @foreach ($comments[0]->links as $key => $values)
                                        <li class="{{$values['stly_classes']}}">
                                            <a href="?page={{$values['page']}}" class="page-link" aria-label="Previous">
                                                {{$values['icon']}}
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </nav>
                            </div>
                            @if(Auth::check())
                            <div class="comment-form">
                                @if(isset($comment_edit))
                                <h4>{{ __('index.blog_detail.edit_comment') }}</h4>
                                <form class="form-contact comment_form" action="{{ route('updeteComment', ['blog' => $blog['id'], 'comment' => $comment_edit['id'] ]) }}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea class="form-control w-100" name="comment" cols="30" rows="9" placeholder="Write Comment">{{ $comment_edit['text'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="button button-contactForm btn_1 boxed-btn">{{ __('index.blog_detail.update_comment') }}</button>
                                    </div>
                                </form>
                                @else
                                <h4>{{ __('index.blog_detail.post_comment') }}</h4>
                                <form class="form-contact comment_form" action="{{ route('sendComment', ['id' => $blog['id'] ]) }}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea class="form-control w-100" name="comment" cols="30" rows="9" placeholder="{{ __('index.blog_detail.write_comment') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="button button-contactForm btn_1 boxed-btn">{{ __('index.blog_detail.post_comment') }}</button>
                                    </div>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 mb-7 mb-lg-0">
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

h1, h2, h3, h4, h5, h6 {
    font-family: "Poppins", sans-serif;
    color: #1a1a1a;
    margin-top: 0px;
    font-style: normal;
    font-weight: 500;
    text-transform: normal;
}
</style>

@endsection
