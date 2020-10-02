<?php $currency_code = getSetting('currency_code','site_settings');
$today = DATE('d-m-Y');
$user = Auth::user();
use App\Auction;
$featured_enable = getSetting('enable_featured_items','auction_settings');

//Featured Auctions
$featured_records = Auction::getHomeFeaturedAuctions(8);
?>
      <section class="au-categorys">
      <div class="container">
         <div class="row">

          <!--ASIDE BAR SECTION-->
            <div class="col-lg-3 col-md-4 col-sm-12">
                <h3 class="text-center">Proximas Subastas</h3>
                          <!--featured auctions start-->
                @if ($featured_enable=='Yes')
                    @foreach ($invitacion as $item)
                        @if ($user->email == $item->email)
                            @if (count($featured_records))
                                <div class="row">
                                   @foreach ($featured_records as $auction)
                                       @if ($auction->sub_category_id == $item->auction_id)
                                          <div class="col-lg-12 col-md-12 col-sm-12 p-3">

                                              <div class="au-accordina">
                                                  <div class="au-thumb"><a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}"> <img src="{{getAuctionImage($auction->image,'auction')}}" alt="{{$auction->title}}" class="img-fluid premium-img"></a> </div>

                                                  <div class="au-acord-secret">
                                                       <h6 class="card-title text-center" data-toggle="tooltip" title="{{$auction->title}}" data-placement="bottom"><a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}">{!! str_limit($auction->title,25,'..') !!}</a></h6>
                                                  </div>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?></p>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </p>


                                              </div>
                                          </div>
                                       @endif
                                   @endforeach
                                </div>
                            @endif
                         @endif
                    @endforeach
                @endif
                          <!--featured auctions tab end-->
            </div>

            <!--PRODUCTS SECTION-->
             <div class="col-lg-9 col-md-9 col-sm-12 au-wrapper-main">
               <div class="row au-main-header">
                 <div class="col-lg-9 col-md-6 col-sm-12 au-body-header">
                   <h5>AUCTIONS</h5>
                 </div>
                 <!--<div class="col-lg-3 col-md-6 col-sm-12 au-items-listt clearfix">
                      <label>Show</label>
                       <select class="form-control form-control-sm au-form-dropdown">
                        <option>10</option>
                        <option>50</option>
                        <option>100</option>
                       </select>
                       <label>Entries</label>
                 </div>-->
                   <div class="col-lg-3 col-md-6 col-sm-6 au-items-listt clearfix">
                       <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Instrucciones">
                           <i class="fa fa-question" aria-hidden="true"></i>
                       </button>
                   </div>
                </div>
                <div id="load" style="position: relative;">

      <section class="auctions">
<div class="row">
      @foreach ($invitacion as $item)
        @if ($user->email == $item->email)
            @if (count($auctions))
            @foreach ($auctions as $auction)
                @if ($auction->sub_category_id == $item->auction_id)

        <div class="col-lg-4 col-md-6 col-sm-6 au-item-categorys">
         <div class="card au-cards">
            @if (Auth::user())
            <a href="javascript:void(0);" onclick="auctionAddtoFavourites({{$auction->id}})" title="Add to Wishlist"><i class="pe-7s-like"></i></a>
            @else
             <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Add to Wishlist"><i class="pe-7s-like"></i></a>
            @endif

            <a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}" title="View Auction Details"><img class="img-fluid auction-img" src="{{getAuctionImage($auction->image,'auction')}}" alt="{{$auction->title}}"></a>
            <div class="card-block au-card-block">
              <a href="{{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}" title="View Auction Details"><h4 class="card-title au-title"> {!! str_limit($auction->title,40,'') !!} </h4></a>


              {{--@if ($auction->auction_status=='open' && $auction->start_date<=$today && $auction->end_date>=$today)--}}
              @if ($auction->auction_status=='open' && $auction->start_date<=NOW() && $auction->end_date>=NOW())
              <?php $total_bids = $auction->getAuctionBiddersCount();?>

              <ul class="action-card-details">
                  <li><p><small title="Auction End Date">
                    <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?>
                  </small><span class="pull-right"><small>{{getAuctionDaysLeft($auction->start_date,$auction->end_date)}}</small></span></p></li>
                   <li><p><small title="Precio reserva">{{$currency_code}}{{$auction->reserve_price}}</small></p></li>
              </ul>

              @elseif ($auction->auction_status=='new' && $auction->start_date<=NOW() && $auction->end_date>=NOW())
              <p>
                <span style="float:left;"><small title="Auction End Date"> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </small></span>
                <span style="float:right;"><small title="Reserve Price">{{$currency_code}}{{$auction->reserve_price}}</small></span>
              </p>
              @elseif ($auction->auction_status=='closed')
              <p>
              <span style="float:left;"><small title="Auction End Date"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?></small></span>
              <span style="float:right;"><small>{{getPhrase('auction_ended')}}</small></span>
              </p>
              @endif

            </div>
          </div>
        </div>
    @endif
    @endforeach
    @else
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h4 class="text-center">No hay subastas</h4>
    </div>
                @break
    @endif

    @endif
    @endforeach
</div>
 </section>

                </div>

            </div>
            <!--PRODUCTS SECTION-->


         </div>
      </div>
    </section>

 <!--Pagination Section-->
 <div class="row ">
 <div class="col-lg-12 col-md-12 col-sm-12 au-page">


   {{$auctions->links()}}


<!-- <div>
    Showing {{($auctions->currentpage()-1)*$auctions->perpage()+1}} to {{$auctions->currentpage()*$auctions->perpage()}}
    of  {{$auctions->total()}} entries
</div>


<div>
  {{($auctions->currentpage()-1) * $auctions->perpage() + $auctions->count()}}
</div> -->


  </div>
</div>
<!--Pagination Section-->


