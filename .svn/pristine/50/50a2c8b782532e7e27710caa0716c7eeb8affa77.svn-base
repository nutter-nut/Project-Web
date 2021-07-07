@extends('layouts.tp-fastener-index.index')

@section('center')

<section class="main_container">
        <div class="container-fastener">
            <div class="col-sm-12">
                <div class="top_box" style="width:100%;">

                    <ol class="breadcrumb breadcrumb-arrow mb-5">
                        <li><a href="{{ route('Index') }}">Home</a></li>
                        <li><a href="{{ route('categoriesIndex', [ 'id' => $data['breadcrumb']['category_id'], 'name' => $data['breadcrumb']['category_name'] ]) }}">{{ $data['breadcrumb']['category_name'] }}</a></li>
                        <li class="active"><span>{{ $data['breadcrumb']['category_detail'] }}</span></li>
                    </ol>

                    <img class="img-mil-spec" src="{{ $data['image']['url'] }}" alt="{{ $data['breadcrumb']['category_detail'] }}">
                    <h1>{{ $data['breadcrumb']['category_detail'] }}</h1>
                    {{-- <p class="hidden-xs">Hardened with Ceramic Coating; Cuts Its Own Threads into Concrete &amp; Masonry.</p>
                    <p style="color:#000; font-size:14px;"></p> --}}
                </div>
                <div class="machine_list">
                    <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <h3><strong>Filter For</strong></h3>
                        <ul>
                            <li class="odd"><a href="{{ route('getProducts', [ 'id' => 0, 'name' => 'All', 'category' => $data['breadcrumb'] ]) }}">All {{ $data['breadcrumb']['category_detail'] }}</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-1 col-md-1 or mx-auto">
                        <span>or</span>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <h3><strong>Follow A Product Path Below</strong></h3>
                        <ul>
                            @foreach($data['cate_detail_filter'] as $item)
                                <li class="odd"><a href="{{ route('getProducts', [ 'id' => $item->PMenuId, 'name' => str_replace('/', ',', $item->PMenuGroupName), 'category' => $data['breadcrumb'] ]) }}">{{ $item->PMenuGroupName }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

            @include('layouts.products_more')
            
        </div>

    </section>

@endsection