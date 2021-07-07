<div class="blog_right_sidebar">
    <aside class="single_sidebar_widget search_widget">
        <form action="{{ route('searchBlog') }}" method="GET">
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder='{{ __('index.blog.search_blog') }}' value="{{ $search ?? '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Blog'">
                </div>
            </div>
            <button class="button rounded-0 primary-bg w-100 btn_1 boxed-btn" type="submit">{{ __('index.blog.search_btn') }}</button>
        </form>
    </aside>
    <!-- <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title" style="color: #2d2d2d;">{{ __('index.blog.category') }}</h4>
        <ul class="list cat-list">
            @foreach($array_menu[0] as $item)
                @if($item['count']*1 > 0)
                <li>
                    <a href="#" class="d-flex">
                        <p>{{ $item['prodGroupName'] }}</p>
                        <p>({{ $item['count'] }})</p>
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
    </aside> -->
    <aside class="single_sidebar_widget popular_post_widget">
        <h4 class="widget_title" style="color: #2d2d2d;">{{ __('index.blog.recent_post') }}</h4>
        @foreach($array_menu[1] as $key => $item)
        <div class="media post_item">
            <a href="{{ route('blogDetails', ['id' => $item['id'] ]) }}">
                <img src="{{ asset('storage') }}/blog_images/{{$item['image']}}" width="80" height="80" alt="">
            </a>
            <div class="media-body">
                <a href="{{ route('blogDetails', ['id' => $item['id'] ]) }}">
                    <h4 style="color: #2d2d2d;">{{ $item['title'] }}</h4>
                </a>
                <!-- <p>January 12, 2019</p> -->
                <p>{{ $array_menu[2][$key] }}</p>
            </div>
        </div>
        @endforeach
    </aside>
</div>
