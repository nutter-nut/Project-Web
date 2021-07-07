@extends('layouts.tp-fastener-index.index')

@section('center')

<section class="main_container">
    <div class="container-fastener">
        <div class="col-sm-12">

            <ol class="breadcrumb breadcrumb-arrow mb-5">
                <li><a href="{{ route('Index') }}">{{ __('index.categorie.breadcrumb_home') }}</a></li>
                <li class="active"><span>{{ $data['breadcrumb']['category_name'] }}</span></li>
            </ol>

            <h1 style="text-align: left!important;">{{ \ucfirst($data['breadcrumb']['category_name']) }} Categories</h1>
            <div class="category_extra_description hidden-xs">
                <p>Using the right kind of screw is essential to any construction project, large or small, whether you are a contractor doing a renovation or a builder erecting an entire residential subdivision or office complex. You need screws specifically manufactured for the material to be fastened — whether it’s concrete, wood, metal or something else — and that will hold up for their designated use. At Fastener SuperStore we provide a wide range of options for customers looking to buy wholesale screws of virtually any type. Below is a list of screw categories and some common uses, along with information about what Fastener SuperStore can do for you.</p>
            </div>
            <h3><span>Select a Category Below</span></h3>

            <section class="category_list">
                <ul>
                    @foreach($data['cate_data'] as $item)
                    <li>
                        <a href="{{ route('detalCategories', [ 'id' => $item->PMenuGroupCode, 'name' => $item->PMenuGroupName, 'category' => $data['breadcrumb'] ]) }}">
                            <span>
                                <img class="img-mil-spec" src="{{ $item->image['url'] }}" alt="{{ $item->PMenuGroupName }}">
                            </span>
                            <h2>{{ $item->PMenuGroupName }}</h2>
                        </a>
                        {{-- <p class="hidden-xs">Hardened with Ceramic Coating; Cuts Its Own Threads into Concrete &amp; Masonry.</p> --}}
                    </li>
                    @endforeach
                </ul>
            </section>
        </div>

        @include('layouts.products_more')

    </div>
</section>

@endsection

