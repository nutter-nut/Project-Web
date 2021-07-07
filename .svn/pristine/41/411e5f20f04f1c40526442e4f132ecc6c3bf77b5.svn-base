<div class="related_product">
    <h4>{{ __('index.cart.related_products') }}</h4>
        <div class="row">
            <div class="col-12">
                <div class="carousel carousel-showmanymoveone slide" id="carouselABC">
                    <div class="carousel-inner">
                        @foreach($data['top_products'] as $key => $item)
                            <div class="item @if($key == 0) active @endif">
                                <div class="col-10 col-sm-7 col-md-6 col-lg-3 col-xl-3">
                                    <div class="left_box">
                                        <div class="mil-spec">
                                            <div class="item border p-3 mb-5 bg-white rounded">
                                                <a href="{{ route('productDetal', [ 'prodCode' => $item['detal']['prodCode'], 'uomCode' => $item['detal']['uomCode'], 'name' => $item['detal']['prodTName'] ]) }}">
                                                    @if($item['detal']['promotion'] != 'no')
                                                        <span class="notify-badge">-{{ $item['detal']['discount'] }}%</span>
                                                    @endif
                                                    @if($item['detal']['best_seller'] == 1)
                                                        <span class="notify-badge" style="background: #f0ad4e;">ขายดี</span>
                                                    @endif
                                                    <img src="{{ $item['data']['product_image']['url'] }}" alt="{{ $item['detal']['image'][0] }}" >
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right_box" style="margin-left: 1rem;">
                                        <small>{{ $item['detal']['prodCode'] }}</small>
                                        <strong>
                                            <a href="{{ route('productDetal', [ 'prodCode' => $item['detal']['prodCode'], 'uomCode' => $item['detal']['uomCode'], 'name' => $item['detal']['prodTName'] ]) }}" class="text-limit"> {{ $item['detal']['prodTName'] }}</a>
                                        </strong>
                                        <div class="review-block-rate mb-0">
                                            <button type="button" class="btn @if($item['detal']['ratting'] == 1 || $item['detal']['ratting'] > 0) btn-warning @else btn-default btn-grey @endif btn-sm" aria-label="Left Align" style="padding: 5px 3px;height: 25px">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn @if($item['detal']['ratting'] == 2 || $item['detal']['ratting'] > 1) btn-warning @else btn-default btn-grey @endif btn-sm" aria-label="Left Align" style="padding: 5px 3px; height: 25px">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn @if($item['detal']['ratting'] == 3 || $item['detal']['ratting'] > 2) btn-warning @else btn-default btn-grey @endif btn-sm" aria-label="Left Align" style="padding: 5px 3px; height: 25px">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn @if($item['detal']['ratting'] == 4 || $item['detal']['ratting'] > 3) btn-warning @else btn-default btn-grey @endif btn-sm" aria-label="Left Align" style="padding: 5px 3px; height: 25px">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn @if($item['detal']['ratting'] == 5) btn-warning @else btn-default btn-grey @endif btn-sm" aria-label="Left Align" style="padding: 5px 3px; height: 25px">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <strong style="font-size: 25px;">${{ number_format($item['detal']['price'], 2) }}</strong>
                                        @if($item['detal']['promotion'] != 'no')
                                            <sub class="pl-3"><del style="font-size: 15px;" class="text-muted">${{ number_format($item['detal']['price_vat'], 2) }}</del></sub>      
                                        @endif  
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="left carousel-control text-secondary" href="#carouselABC" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="right carousel-control text-secondary" href="#carouselABC" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.carousel-showmanymoveone .carousel-control {
  width: 4%;
  background-image: none;
}
.carousel-showmanymoveone .carousel-control.left {
  margin-left: 15px;
}
.carousel-showmanymoveone .carousel-control.right {
  margin-right: 15px;
}
.carousel-showmanymoveone .cloneditem-1,
.carousel-showmanymoveone .cloneditem-2,
.carousel-showmanymoveone .cloneditem-3 {
  display: none;
}

@media all and (min-width: 768px) {
  .carousel-showmanymoveone .carousel-inner > .active.left,
  .carousel-showmanymoveone .carousel-inner > .prev {
    left: -50%;
  }
  .carousel-showmanymoveone .carousel-inner > .active.right,
  .carousel-showmanymoveone .carousel-inner > .next {
    left: 50%;
  }
  .carousel-showmanymoveone .carousel-inner > .left,
  .carousel-showmanymoveone .carousel-inner > .prev.right,
  .carousel-showmanymoveone .carousel-inner > .active {
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner .cloneditem-1 {
    display: block;
  }
}
@media all and (min-width: 768px) and (transform-3d), all and (min-width: 768px) and (-webkit-transform-3d) {
  .carousel-showmanymoveone .carousel-inner > .item.active.right,
  .carousel-showmanymoveone .carousel-inner > .item.next {
    -webkit-transform: translate3d(50%, 0, 0);
            transform: translate3d(50%, 0, 0);
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner > .item.active.left,
  .carousel-showmanymoveone .carousel-inner > .item.prev {
    -webkit-transform: translate3d(-50%, 0, 0);
            transform: translate3d(-50%, 0, 0);
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner > .item.left,
  .carousel-showmanymoveone .carousel-inner > .item.prev.right,
  .carousel-showmanymoveone .carousel-inner > .item.active {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
    left: 0;
  }
}
@media all and (min-width: 992px) {
  .carousel-showmanymoveone .carousel-inner > .active.left,
  .carousel-showmanymoveone .carousel-inner > .prev {
    left: -25%;
  }
  .carousel-showmanymoveone .carousel-inner > .active.right,
  .carousel-showmanymoveone .carousel-inner > .next {
    left: 25%;
  }
  .carousel-showmanymoveone .carousel-inner > .left,
  .carousel-showmanymoveone .carousel-inner > .prev.right,
  .carousel-showmanymoveone .carousel-inner > .active {
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner .cloneditem-2,
  .carousel-showmanymoveone .carousel-inner .cloneditem-3 {
    display: block;
  }
}
@media all and (min-width: 992px) and (transform-3d), all and (min-width: 992px) and (-webkit-transform-3d) {
  .carousel-showmanymoveone .carousel-inner > .item.active.right,
  .carousel-showmanymoveone .carousel-inner > .item.next {
    -webkit-transform: translate3d(25%, 0, 0);
            transform: translate3d(25%, 0, 0);
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner > .item.active.left,
  .carousel-showmanymoveone .carousel-inner > .item.prev {
    -webkit-transform: translate3d(-25%, 0, 0);
            transform: translate3d(-25%, 0, 0);
    left: 0;
  }
  .carousel-showmanymoveone .carousel-inner > .item.left,
  .carousel-showmanymoveone .carousel-inner > .item.prev.right,
  .carousel-showmanymoveone .carousel-inner > .item.active {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
    left: 0;
  }
}

.carousel-inner>.item {
    -webkit-transition: -webkit-transform .6s ease-in-out;
    -o-transition: -o-transform .6s ease-in-out;
    transition: transform .6s ease-in-out;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-perspective: 1000;
    perspective: 1000;
}

</style>


