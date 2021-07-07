    <footer>
        <div class="container">
            <div class="row p-3">
                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                    <h3 style="color:white;">{{ __('index.footer.customerresources') }}</h3>
                    <ul>
                        <li><a href="{{ route('profile') }}">{{ __('index.footer.manage_account') }}</a></li>
                        <li><a href="{{ route('cartIndex') }}">{{ __('index.footer.view_your_orders') }}</a></li>
                        <li><a href="{{ route('Contact') }}">{{ __('index.footer.contact_us') }}</a></li>
                        <li><a>{{ __('index.footer.faq') }}</a></li>
                    </ul>
                    <p class="footer_phone" style="margin: 0;margin-bottom: 15px;"><span class="number"><a href="tel:8632515258">{{ $companyData['phone']['value'] }}</a></span></p>
                    <br>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                    <h3 style="color:white;">{{ __('index.footer.directory') }}</h3>
                    <ul>
                        <li><a href="/">{{ __('index.footer.view_all_products') }}</a></li>
                        <li><a href="{{ route('Blog') }}">{{ __('index.footer.blog') }}</a></li>
                        <li><a href="{{ route('About')}}">{{ __('index.footer.about') }}</a></li>
                    </ul>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                    <h3 style="color:white;">{{ __('index.footer.support') }}</h3>
                    <img src="{{ asset('assets/tp-fastener/style/image/payment_icon.png') }}" alt="Payment icon" />
                </div>
                <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <h3 style="color:white;">{{ __('index.footer.support_bottom') }}</h3>
                    <ul class="social">
                        <li class="facebook"><a href="" target="_blank"></a></li>
                        <li class="twitter"><a href="" target="_blank"></a></li>
                        <li class="instagram"><a href="" target="_blank"></a></li>
                        <li class="in"><a href="" target="_blank"></a></li>
                    </ul>
                    <ul class="connect">
                        <li><img src="{{ asset('assets/tp-fastener/style/image/footer_rapidssl_logo.png') }}" alt="Footer rapidssl logo" /></li>
                        <li><img src="{{ asset('assets/tp-fastener/style/image/footer_ups_logo.png') }}" alt="Footer ups logo" /></li>
                        <li><img src="{{ asset('assets/tp-fastener/style/image/footer_fedex_logo.png') }}" alt="Footer fedex logo" /></li>
                    </ul>
                </div>
                <p style="margin-top: 5px;">{{ $companyData['address']['value'] }}</p>    
            </div>
        </div>

    </footer>
    
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->

    <!--Custom JavaScript -->
    <script src="{{ asset('assets/login/js/custom.min.js') }}"></script>

</body>

</html>

<script>
(function(){
  // setup your carousels as you normally would using JS
  // or via data attributes according to the documentation
  // https://getbootstrap.com/javascript/#carousel
  $('#carousel123').carousel({ interval: 2000 });
  $('#carouselABC').carousel({ interval: 5600 });
}());

(function(){
  $('.carousel-showmanymoveone .item').each(function(){
    var itemToClone = $(this);

    for (var i = 1; i < 4; i++) {
      itemToClone = itemToClone.next();

      // wrap around if at end of item collection
      if (!itemToClone.length) {
        itemToClone = $(this).siblings(':first');
      }

      // grab item, clone, add marker class, add to collection
      itemToClone.children(':first-child').clone()
        .addClass("cloneditem-"+(i))
        .appendTo($(this));
    }
  });
}());
</script>