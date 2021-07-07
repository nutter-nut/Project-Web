@extends('layouts.tp-fastener-index.index')

@section('center')

<section class="messages" style="background-color: #fff; width:100%;">
    <div class="container-fastener">
        <div class="col-sm-12" style="margin-top:5px;">
        </div>
    </div>
</section>
<section class="main_container">
    <div class="container">
        <div class="col-12">
            @include('alert')
        </div>
        <div class="col-sm-9 pull-right">
            <h1>{{ __('index.index.deliver') }}</h1>
            <div class="heading">
                <h2><span>{{ __('index.index.select_category') }}</span></h2>
            </div>
            <section class="category_list inner_col">
                <ul>
                    @foreach($data['menugroup'] as $item)
                    <li>
                        <a href="{{ route('categoriesIndex', [ 'id' => $item->PMenuGroupCode, 'name' => $item->PMenuGroupName ]) }}">
                            <span>
                                <img src="{{ $item->image['url'] }}" alt="{{ $item->PMenuGroupName }}">  
                            </span>
                            <h2>{{ $item->PMenuGroupName }}</h2>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </section>
            <div class="home_extra_description hidden-xs">
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail') }}</p>
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail2') }}</p>
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail3') }}</p>
            </div>

        </div>
        <div class="col-sm-3 red_box">
        <h3>{{ __('index.index.title') }}</h3>
            <p>{{ __('index.index.title_detail') }}</p>
            <p>{{ __('index.index.title_detail2') }}</p>
            <p>{{ __('index.index.title_detail3') }}</p>
        </div>
        
        @include('layouts.products_more')
    </div>
</section>

<!-- <section class="main_container">
    <div class="container-fastener">

        <div class="col-12">
            @include('alert')
        </div>
        
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 pull-right">
            <h1>{{ __('index.index.deliver') }}</h1>

            <div class="heading">
                <h2><span class="span-n-c">{{ __('index.index.select_category') }}</span></h2>
            </div>
            
            <section class="category_list inner_col">
                <ul>
                    @foreach($data['menugroup'] as $item)
                    <li>
                        <a href="{{ route('categoriesIndex', [ 'id' => $item->PMenuGroupCode, 'name' => $item->PMenuGroupName ]) }}">
                            <span>
                                <img src="{{ $item->image['url'] }}" alt="{{ $item->PMenuGroupName }}">
                            </span>
                            <h2>{{ $item->PMenuGroupName }}</h2>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </section>

            <div class="home_extra_description hidden-xs text-justify">
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail') }}</p>
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail2') }}</p>
                <p style="text-indent: 2.5em;">{{ __('index.index.title_detail3') }}</p>
            </div>

        </div>
        <div class="col-3 red_box hidden-xs hidden-sm text-justify">
            <h3>{{ __('index.index.title') }}</h3>
            <p>{{ __('index.index.title_detail') }}</p>
            <p>{{ __('index.index.title_detail2') }}</p>
            <p>{{ __('index.index.title_detail3') }}</p>
        </div>

        @include('layouts.products_more')
    </div>
</section> -->


@endsection
