
<?php
          $user = Auth::user();
  use App\Auction;
$category_auctions=[];
if (isset($auction) && !empty($auction)) {

  $category_auctions = App\Auction::getCategoryAuctions($auction->sub_category_id);
  $currency_code = getSetting('currency_code','site_settings');

  ?>

 <!--SIMILAR CATEGORY PRODUCTS SECTION-->

    @if (count($category_auctions))
    <section class="au-similar-products">
        <div class="container-fluid">
            <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12 au-deals">
                <h2 class="text-center">Siguientes subastas</h2>
              </div>

               <div class="screenshot-similar-product">

                @foreach ($category_auctions as $auction)
                    @if ($auction->auction_status=='open'  && $auction->end_date>=NOW())
                    <div class="card au-similar-card">
                      @if (Auth::user())
                        <a href="javascript:void(0);" ng-click="addtoFavourites({{$auction->id}})"><i class="pe-7s-like like"></i></a>
                        @else
                         <a href="javascript:void(0);" onclick="showModal('loginModal')"><i class="pe-7s-like like"></i></a>
                        @endif

                        <a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}" title="Auction Details">
                        <img class="img-fluid similar-img" src="{{getAuctionImage($auction->image,'auction')}}" alt="{{$auction->title}}"></a>


                        <div class="card-block au-similar-block text-center">

                            <a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}" data-toggle="tooltip" title="{{$auction->title}}" data-placement="bottom">
                              <h4 class="card-title text-center p-2"> {!! str_limit($auction->title,30,'..') !!}</h4>
                            </a>

                            <p class="card-title text-center">
                                <strong> Fecha Inicio: <br></strong> {!!  date(getSetting('date_format','site_settings'), strtotime($auction->start_date)); !!}
                                <br> <strong> Hora Inicio: <br></strong> {!!  date(' H:i:s', strtotime($auction->start_date)); !!}
                            </p>

                               <hr>

                            <p class="card-title text-center">
                                <strong> Fecha Fin: <br></strong> {!!  date(getSetting('date_format','site_settings'), strtotime($auction->end_date)); !!}
                                <br> <strong> Hora Fin: <br></strong> {!!  date(' H:i:s', strtotime($auction->end_date)); !!}
                            </p>

                      </div>
                    </div>
                        @endif
                @endforeach

            </div>
          </div>
        </div>
    </section>
    @endif


    <!--SIMILAR CATEGORY PRODUCTS SECTION-->

    <?php } ?>
                <style>
		.owl-controls {
		    display: none;
		}
                </style>
