@extends('layouts.index.index')

@section('center')

<main>

    <br>
    <div class="container">
        @include('alert')
    </div>
    
    <!--? Properties Start -->
    <br>
    <section-page class="properties new-arrival fix">
        <div class="container">
            <!-- Section tittle -->
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="section-tittle mb-60 text-center wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay=".2s">
                        <h2>{{ __('index.search.title') }}</h2>
                        <P>{{ __('index.search.sub_title') }}</P>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row justify-content-center">
                    @foreach($products as $key => $item)
            
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-new-arrival mb-50 text-center">
                                <div class="popular-img">
                                    
                                        <!-- <img src="{{ asset('storage') }}/product_images/product_default.png" alt="" style="width: 120px;height: auto;"> -->
                                        <img src="{{ asset('storage') }}/product_images/product_default.png" alt="">
                                    
                                </div>
                                <div class="popular-caption">
                                    <h3><a href="{{ route('productDetails', [ 'prodCode' => $item->prodCode, 'uomCode' => $item->uomCode ]) }}">{{ $item->prodTName }} / {{ $item->uomName }} / {{  $item->prodUnitRatio }}(ชิ้น)</a></h3>
                                    <span>${{ $item->prodUnitPrice }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach                            
                    </div>
  
            </div>

            <div class="row justify-content-center">
                <div class="room-btn">
                    <a href="{{ route('Categories') }}" class="border-btn">{{ __('index.search.title_button') }}</a>
                </div>
            </div>

        </div>
        <br>
    </section-page>
    
</main>

@endsection
