@extends($layout)

@section('header_scripts')

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">

@endsection

@section('content')
<?php
        use App\Bidding;
$today = DATE('d-m-Y');
$currency_code = getSetting('currency_code','site_settings');
$auctin_url = URL_HOME_AUCTIONS;
$last_bidcerrada = Bidding::getLastBidRecordCerrada($auction->id);

$enter_amount = 'Ingresar cantidad ';
if ($auction->visibilidad == 1){
    if (isset($last_bid) && !empty($last_bid->bid_amount))
      $enter_amount .= 'mayor a '.number_format($last_bid->bid_amount);
    elseif ($auction->minimum_bid>0)
      $enter_amount .= 'mayor a '.number_format($auction->minimum_bid);
}else{
    if (isset($last_bid) && !empty($last_bidcerrada->bid_amount))
      $enter_amount .= 'mayor a '.number_format($last_bidcerrada->bid_amount);
    elseif ($auction->minimum_bid>0)
      $enter_amount .= 'mayor a '.number_format($auction->minimum_bid);
}

$total_bids = $auction->getAuctionBiddersCount();

$active_picture_gallary = getSetting('active_picture_gallary','auction_settings');

$max_number_of_pictures = getSetting('max_number_of_pictures','auction_settings');

if (isset($active_class))
$active_class = $active_class;
else
$active_class='';

$user = Auth::user();
use App\AuctionBidder;
use App\Auction;
use App\SubCatogory;

?>

<style>
    .shadow{
-webkit-box-shadow: 10px 10px 30px 0px rgba(230,230,230,1);
-moz-box-shadow: 10px 10px 30px 0px rgba(230,230,230,1);
box-shadow: 10px 10px 30px 0px rgba(230,230,230,1);
    }
@media screen and (max-width: 986px) {
  .btn-res {
     font-size: 15px;
  }
}

@media screen and (max-width: 536px) {
  .btn-res {
    font-size: 13px;
  }
    .au-product-nav{
        padding: 5px !important;
    }
}
</style>

<div class="container">
    <div class="row">
        <div class="accordion" id="accordionExample">
            <div class="col-12 mt-3" >
                <div class="d-flex justify-content-between">

                      <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-auction" role="button" aria-controls="nav-auction" aria-expanded="false">
                          detalles de la subasta
                      </a>

                      <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-shipping" role="button" aria-controls="nav-shipping" aria-expanded="false">
                          Envío & pago
                      </a>

                      <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-terms" role="button" aria-controls="nav-terms" aria-expanded="false">
                          condiciones de subasta & informacion
                      </a>

                      <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-bid" role="button" aria-controls="nav-bid" aria-expanded="false">
                          historial de ofertas
                      </a>

                </div>

                    {{--  Detalles de la subasta--}}
                     <div class="collapse" id="nav-auction" data-parent="#accordionExample">
                      <div class="card card-body shadow">
                            <div class="row">

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                            Fecha de inicio
                                          <span class="btn-res"> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?></span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                            Fecha final
                                          <span class="btn-res"> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </span>
                                        </li>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                             Precio de reserva
                                          <span class="btn-res">@if($auction->reserve_price) $ {{ number_format($auction->reserve_price)}} mxn @endif</span>
                                         </li>


                                         <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                             Tiros por subasta
                                          <span class="btn-res">@if($auction->tiros) {{$auction->tiros}} @endif</span>
                                         </li>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                         <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                              Inicio de oferta
                                          <span class="btn-res">@if ($auction->minimum_bid) $  {{ number_format($auction->minimum_bid) }} mxn @endif</span>
                                         </li>

                                          <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                             ¿La subasta de de auto incremento?
                                            <span class="btn-res">
                                                @if ($auction->is_bid_increment==1)
                                                    Si
                                                @else
                                                    No
                                                @endif
                                            </span>
                                         </li>

                                        @if ($auction->bid_increment)
                                             <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                 Incremento de oferta ($MXN)
                                              <span class="btn-res">{{$currency_code}} {{$auction->bid_increment}}</span>
                                             </li>
                                         @endif

                                         <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                            Tipo de subastas
                                            <span class="btn-res">
                                            @if ($auction->visibilidad==1)
                                                Abierta
                                            @else
                                                Cerrada
                                            @endif
                                            </span>
                                         </li>

                                          @if ($auction->is_buynow==1)
                                              <li class="list-group-item d-flex justify-content-between align-items-center btn-res">

                                                  comprar ahora precio
                                                <span class="btn-res">@if ($auction->buy_now_price) {{$currency_code}} {{$auction->buy_now_price}} @endif</span>
                                              </li>
                                          @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Fin  Detalles de la subasta--}}

                    {{--  Envio y Pago--}}
                     <div class="collapse" id="nav-shipping" data-parent="#accordionExample">
                          <div class="card card-body shadow">
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                      <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                        <p>{!! $auction->shipping_conditions !!}</p>

                                      </div>
                                    </div>

                                </div>
                          </div>
                     </div>
                     {{-- Fin Envio y Pago--}}

                     {{--  Condiciones De Subasta & Informacion--}}
                     <div class="collapse" id="nav-terms" data-parent="#accordionExample">
                          <div class="card card-body shadow">
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                        <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                          <p>{!! $auction->shipping_terms !!}</p>

                                        </div>
                                    </div>

                                </div>
                          </div>
                     </div>
                     {{-- Fin Condiciones De Subasta & Informacion--}}

                      {{--  Historial De Ofertas --}}
                     <div class="collapse" id="nav-bid" data-parent="#accordionExample">
                          <div class="card card-body shadow">
                                <div class="row">

                                  <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                      <div class=" au-policy">

                                        @if (isset($bidding_history) && count($bidding_history))

                                          @if ($auction->visibilidad==1)
                                            <ul class="list-group z-depth-0">
                                              <li class="list-group-item justify-content-between">
                                                  <span><b>{{getPhrase('username')}}</b></span>
                                                  <span style="float:right;"><b>{{getPhrase('bid_amount')}}</b></span>
                                              </li>
                                              @foreach ($bidding_history as $bid)
                                                  <li class="list-group-item justify-content-between">
                                                    <span>Usuario</span>
                                                    <span style="float:right;">${{$bid->bid_amount}} MXN</span>
                                                  </li>
                                              @endforeach
                                            </ul>
                                           @else
                                             <span>Usuario</span>
                                          @endif
                                        @endif

                                      </div>
                                  </div>

                                </div>
                          </div>
                     </div>
                     {{-- Fin Historial De Ofertas --}}
            </div>
        </div>
    </div>
</div>


 <!--CATEGORY BODY SECTION-->
 @foreach ($invitacion as $item)
    @if ($user->email == $item->email)
    @if ($auction->sub_category_id == $item->auction_id)

     <section class="single-product section-pad">
      <div class="container">

          <div class="row">


            <div class="col-lg-6">
               <!-- Product-gallery-container -->

                    <!-- <div class="sm-product-show">
                        <div class="sm-product-slider-img">
                            <img src="http://via.placeholder.com/550x350" id="sm-product-zoom" class="img-responsive" data-zoom-image="http://via.placeholder.com/950x650" alt="">
                            <i class="sm-zoom-icn fa fa-expand"></i>
                        </div>
                        <ul class="product-slider-thumbs" id="gallery_01">

                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-image="http://via.placeholder.com/650x551">
                                    <img id="img_01" src="http://via.placeholder.com/120x71" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x552">
                                    <img id="img_02" src="http://via.placeholder.com/120x72" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x553">
                                    <img id="img_03" src="http://via.placeholder.com/120x73" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x554">
                                    <img id="img_04" src="http://via.placeholder.com/120x74" alt="">
                                </a>
                            </li>

                        </ul>
                    </div> -->
            <div class="sm-product-show">

                        <div class="sm-product-slider-img">
                            <img src="{{getAuctionImage($auction->image)}}" id="sm-product-zoom" class="img-responsive img-fluid" data-zoom-image="{{getAuctionImage($auction->image,'auction')}}" alt="">
                            <i class="sm-zoom-icn fa fa-expand"></i>
                        </div>


                        @if ($active_picture_gallary=='Yes')
                        <ul class="product-slider-thumbs" id="gallery_01">

                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-image="{{getAuctionImage($auction->image,'auction')}}">
                                    <img id="img_01" src="{{getAuctionImage($auction->image)}}" alt="">
                                </a>
                            </li>

                          @if ($auction_images)
                          <?php $i=0;?>
                          @foreach ($auction_images as $image)
                          <?php $i=$i+1;

                          if ($i==$max_number_of_pictures)
                            break;
                          ?>
                          @if ($image->filename && file_exists(AUCTION_IMAGES_PATH.$image->filename))
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-image="{{AUCTION_IMAGES_PATH_URL}}{{$image->filename}}">
                                    <img id="img_01" src="{{AUCTION_IMAGES_PATH_URL}}{{$image->filename}}" alt="">
                                </a>
                            </li>
                            @endif


                          @endforeach


                            <!-- <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x552">
                                    <img id="img_02" src="http://via.placeholder.com/120x72" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x553">
                                    <img id="img_03" src="http://via.placeholder.com/120x73" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="#" class="elevatezoom-gallery" data-image="http://via.placeholder.com/650x554">
                                    <img id="img_04" src="http://via.placeholder.com/120x74" alt="">
                                </a>
                            </li> -->
                            @endif
                        </ul>

                        @endif
                    </div>

                    <!-- /Product-gallery-container-->
               <!-- <img id="zoom_01" src="{{getAuctionImage($auction->image,'auction')}}" data-zoom-image="{{IMAGES_HOME}}large/image1.jpg" class="img-fluid"> -->
             </div>


            <div class="col-lg-6">

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary btn-sm text-left" data-toggle="modal" data-target="#Instrucciones2">
                     <i class="fa fa-question" aria-hidden="true"></i>
                </button>

                 <a class="btn btn-dark btn-sm text-left" href="javascript:location.reload()" data-toggle="tooltip" title="Recargar pagina"> <i class="fa fa-refresh" aria-hidden="true"></i> </a>
            </div>
                <div class="d-flex bd-highlight mb-3">
                  <div class="mr-auto p-2 bd-highlight"><h4 class="text-left">{{$auction->title}}</h4></div>
                  <div class="p-2 bd-highlight"><p class="text-muted text-right">IDSubasta{{$auction->id}}</p></div>
                  <div class="p-2 bd-highlight"><p class="text-muted text-right">IDLote:{{$auction->sub_category_id}}</p></div>
                </div>

                   @if (!$live_auction) <!--normal auction happening-->
                        <p title="Auction End Date"> La subasta regular finaliza el <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </p>
                   @endif

                    @if ($live_auction_starts)
                      <p title="Auction End Date"> La subasta en vivo comienza en <i class="fa fa-clock-o"></i>{{$auction->live_auction_start_time}}, Prepárate para participar</p>
                    @endif
                @foreach($auctionbidders as $bid)
                                @if(Session::has('succes'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-warning alert-dismissible fade show mb-4 mt-4" role="alert">
                                            {{Session::get('succes')}}
                                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                     @break
                                @endif
                                  @if(Session::has('warning'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-warning alert-dismissible fade show mb-4 mt-4" role="alert">
                                            {{Session::get('warning')}}
                                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                    @break
                @endforeach

              @if ($live_auction) <!--live auction happening-->

              <div>
                  <p title="Auction End Date"> ¡Subasta en vivo ahora! de <i class="fa fa-clock-o"></i>{{$auction->live_auction_start_time}} a <i class="fa fa-clock-o"></i>{{$auction->live_auction_end_time}}</p>
              </div>

              <div class="">
                @if (!Auth::check())
{{--                  <a class="btn btn-info au-btn-modren login-bttn" href="javascript:void(0);" onclick="showModal('loginModal')">{{getPhrase('participate_in_live_auction')}}</a>--}}
                     <a class="btn btn-info au-btn-modren login-bttn" href="javascript:void(0);" onclick="showModal('loginModal')">participar en una subasta en vivo</a>
                @else
{{--                  <a class="btn btn-info au-btn-modren login-bttn live" href="javascript:void(0);" onclick="liveAuction('{{$auction->slug}}')">{{getPhrase('participate_in_live_auction')}}</a>--}}
                     <a class="btn btn-info au-btn-modren login-bttn live" href="javascript:void(0);" onclick="liveAuction('{{$auction->slug}}')">participar en una subasta en vivo</a>
                @endif
              </div>
              @endif


              @if (!$live_auction)<!--si la subasta en vivo no ocurre subasta normal-->

                @if ($auction->auction_status=='open' && $auction->start_date<=now() && $auction->end_date>=now())
                <!--si el estado de la subasta es inicio en vivo-->
                 <!--producto con contenido de borde-->
                 @if ($bid_div)
     <div class="product-border">
                   <!-- <p class="text-blue"><b><i class="pe-7s-timer"> </i>
                        {{strtoUpper(getAuctionDaysLeft($auction->start_date,$auction->end_date))}}</b></p>-->
                       <div class="row">
                           <div class="col-6">
                               <h4>
                                    <p data-toggle="tooltip" title="Precio de reserva" data-placement="top" >Precio Reserva <br> <strong>${!! number_format($auction->reserve_price) !!} MXN</strong></p>

            {{--                        {{$auction->reserve_price}}--}}
                                  <!--<span class="badge" data-toggle="tooltip" title="No. de ofertantes" data-placement="top" >-->
                                    <!--@if ($total_bids>1)-->
                                    <!--     ofertas - {{$total_bids}}-->
                                    <!--@elseif ($total_bids==1)-->
                                    <!--      oferta - {{$total_bids}}-->
                                    <!--@else-->
                                    <!--    0 {{getPhrase('bids')}}-->
                                    <!--@endif-->
                                  <!--</span>-->

                                </h4>
                           </div>
                           <div class="col-6">
                               @foreach($auctionbidders as $item)
                                   @if($item->auction_id == $auction->id)
                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #2064e7; border-radius: 10px; color: #fff" >
                                      Tiros realizados <span class="badge" style="background-color: #0c100c;">{{$item->no_of_times}}</span>
                                    </button>
                                   @endif

                               @endforeach

                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #2064e7; border-radius: 10px; color: #fff" >
                                      Tiros permitidos <span class="badge" style="background-color: #0c100c;">{{$auction->tiros}}</span>
                                    </button>

                               @foreach($auctionbidders as $item)
                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #e9841a; border-radius: 10px; color: #fff" >
                                      Art ganados <span class="badge" style="background-color: #0c100c;"><?php echo $auctionbidders2[0]->bidder_count; ?></span>
                                    </button>
                                       @break
                               @endforeach

                               @foreach($lote as $lotes)
                                    <button class="btn mb-3 ml-4" style="padding: 3px; font-size: 12px; background-color: #e9841a; border-radius: 10px; color: #fff" >
                                      Art a ganar <span class="badge" style="background-color: #0c100c;">{{$lotes->articulos}}</span>
                                    </button>
                                   @break
                               @endforeach

                           </div>
                       </div>


            @if ($bid_options || $bid_options2)
                @if($auction->visibilidad == 1)
                       <p>Seleccione oferta máxima</p>
                        <div class="row">
                          <div class="col-lg-5">
                                {!! Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')) !!}

                                {{-- Traer el id de la subasta en que se esta --}}
                              @foreach($lote as $lotes)
                                    @if ($auctionbidders2[0]->bidder_count < $lotes->articulos)
                                                  <div class="form-group">
                                                        {{Form::select('bid_amount', $bid_options, null, ['placeholder'=>'select',

                                                            'class'=>'form-control',

                                                            'ng-model'=>'bid_amount',

                                                            'required'=> 'true',

                                                            'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}'

                                                        ])}}
                                                        <div class="validation-error" ng-messages="formBid.bid_amount.$error" ></div>
                                                      </div>
                          </div>
                                <div class="col-lg-7">

                                                      <div class="form-group">
                                                        <input type="hidden" name="bid_auction_id" value="{{$auction->id}}">
                                                        <input type="hidden" name="sub" value="{{$auction->sub_category_id}}">
                                                          <div class="col-12 d-flex">
                                                            <a class="btn btn-danger"  href="{{URL_HOME_AUCTIONS}}" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver</a>
                                                            <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>

                                                          </div>
                                                          </div>
                                                      </div>
                                                      {!! Form::close() !!}

                                                            @if($auction->is_bid_increment == 1)
                                                                <p class="ml-3" title="Precio de reserva" data-placement="top" >Incremento de: <strong>${!! number_format($auction->bid_increment) !!} MXN</strong></p>
                                                           @endif
                                      @else
                                        <p>Lo sentimos, ya no puede subastar</p>
                                      @endif
                                       @break
                              @endforeach

                          </div>
                        </div>
                @else
                        <p>Seleccione oferta máxima</p>
                        <div class="row">
                          <div class="col-lg-5">
                                {!! Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')) !!}

                                {{-- Traer el id de la subasta en que se esta --}}
                              @foreach($lote as $lotes)
                                    @if ($auctionbidders2[0]->bidder_count < $lotes->articulos)
                                                  <div class="form-group">
                                                        {{Form::select('bid_amount', $bid_options2, null, ['placeholder'=>'select',

                                                            'class'=>'form-control',

                                                            'ng-model'=>'bid_amount',

                                                            'required'=> 'true',

                                                            'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}'

                                                        ])}}
                                                        <div class="validation-error" ng-messages="formBid.bid_amount.$error" ></div>
                                                      </div>
                          </div>
                                <div class="col-lg-7">

                                                      <div class="form-group">
                                                        <input type="hidden" name="bid_auction_id" value="{{$auction->id}}">
                                                        <input type="hidden" name="sub" value="{{$auction->sub_category_id}}">
                                                          <div class="col-12 d-flex">
                                                            <a class="btn btn-danger"  href="{{URL_HOME_AUCTIONS}}" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver</a>
                                                            <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>

                                                          </div>
                                                          </div>
                                                      </div>
                                                      {!! Form::close() !!}

                                                            @if($auction->is_bid_increment == 1)
                                                                <p class="ml-3" title="Precio de reserva" data-placement="top" >Incremento de: <strong>${!! number_format($auction->bid_increment) !!} MXN</strong></p>
                                                           @endif
                                      @else
                                        <p>Lo sentimos, ya no puede subastar</p>
                                      @endif
                                       @break
                              @endforeach

                          </div>
                        </div>
                @endif
            @else

                <div class="row">
                  <div class="col-lg-12">

                    {!! Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')) !!}

                        {{-- Traer el id de la subasta en que se esta --}}
                            @foreach($lote as $lotes)
                                @if($auction->sub_category_id == $lotes->id)
                                    @if ($auctionbidders2[0]->bidder_count < $lotes->articulos)
                                              <div class="form-group">
                                                {{ Form::number('bid_amount', null, $attributes =

                                                    array('class' => 'form-control',

                                                    'placeholder' => $enter_amount,

                                                    'ng-model' => 'bid_amount',

                                                    'required' => 'true',

                                                    'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}',

                                                    )) }}
                                                <div class="validation-error" ng-messages="formBid.bid_amount.$error" ></div>
                                              </div>


                                              <div class="form-group">
                                                <input type="hidden" name="bid_auction_id" value="{{$auction->id}}">
                                                <input type="hidden" name="sub" value="{{$auction->sub_category_id}}">
                                                  <div class="col-12 d-flex">
                                                      <a class="btn btn-danger"  href="{{URL_HOME_AUCTIONS}}" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver</a>
                                                    <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>
                                                  </div>
                                              </div>
                                              {!! Form::close() !!}

                                    @else
                                        <p>Lo sentimos, ya no puede subastar, ha ganado el numero de articulos permitidos </p>
                                    @endif
                                @endif
                              @endforeach


                  </div>
                </div>
            @endif

                </div>
                @endif

                <!--/product with border content-->
                <!--if auction status is live end-->
                @elseif ($auction->auction_status=='new' && $auction->start_date<=now() && $auction->end_date>=now())
                <!--if auction status is upcoming start-->
                <div>
                    <p class="text-blue"><b><i class="pe-7s-timer"></i> {{strtoUpper(getAuctionDaysLeft($auction->start_date,$auction->end_date))}}</b></p>

                     <h4>
                      {{$currency_code}}{{$auction->reserve_price}}
                      <span class="badge">
                           {{$auction->getAuctionBiddersCount()}} ofertas
                      </span>
                    </h4>
                </div>
                <!--if auction status is upcoming end-->
                @elseif ($auction->auction_status=='closed')
                <!--if auction status is closed start-->
                 <div>
                     <p class="text-blue">
                         <b> Subasta finalizada </b>
                     </p>


                </div>
                 @else
                        <strong>La subasta inicia:  <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?><br></strong>
                <!--if auction status is closed end-->
                @endif

                @endif <!--if live auction not happening-->
                <br>
                <div>

                  @if (Auth::user())
                    <a href="javascript:void(0);" ng-click="addtoFavourites({{$auction->id}})" title="añadir a la lista de deseos" class="btn btn-info au-btn-modren login-bttn"><i class="pe-7s-plus"></i>
{{--                    {{getPhrase('add_to_wish_list')}}</a>--}}
                        añadir a la lista de deseos</a>
                  @else
                   <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Add to Wishlist" class="btn btn-info au-btn-modren login-bttn">
{{--                       <i class="pe-7s-plus"></i> {{getPhrase('add_to_wish_list')}} --}}
                       <i class="pe-7s-plus"></i> añadir a la lista de deseos
                   </a>
                  @endif


                  @if ($auction->is_buynow==1 && $auction->buy_now_price && $is_already_sold=='No')
                  @if ($bid_div)
                  @if (Auth::user())
{{--                    <a href="{{URL_BID_AUCTION_PAYMENT}}/{{$auction->slug}}" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn"> {{getPhrase('buy_now')}}</a>--}}
                      <a href="{{URL_BID_AUCTION_PAYMENT}}/{{$auction->slug}}" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn"> compra ahora</a>
                  @else
{{--                   <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn"> {{getPhrase('buy_now')}} </a>--}}
                      <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn">compra ahora </a>
                  @endif
                  @endif
                  @endif


                 {{--
                 {!! Share::page('http://phpstack-127012-364033.cloudwaysapps.com/', getSetting('site_title','site_settings'))
  ->facebook()
  ->twitter()
  ->googlePlus()
  ->linkedin('Extra linkedin summary can be passed here'); !!} --}}



{{--                 <ul class="list-inline au-social-links">--}}

{{--                   <li class="list-inline-item">--}}
{{--                     <a href="https://www.facebook.com/sharer/sharer.php?u={{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}"> <i class="fa fa-facebook-f au-common"></i></a>--}}
{{--                   </li>--}}

{{--                   <li class="list-inline-item">--}}
{{--                     <a href="https://twitter.com/intent/tweet?text={{getSetting('site_title','site_settings')}}&amp;url={{URL_HOME_AUCTION_DETAILS}}/{{$auction->slug}}"><i class="fa fa-twitter au-common"></i></a>--}}
{{--                   </li>--}}

{{--                    <li class="list-inline-item">--}}
{{--                     <a href="https://plus.google.com/share?url={{PREFIX}}"><i class="fa fa-google au-common"></i></a>--}}
{{--                   </li>--}}

{{--                   <li class="list-inline-item">--}}
{{--                     <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{PREFIX}}&amp;title={{getSetting('site_title','site_settings')}}&amp;summary={{$auction->title}}"><i class="fa fa-linkedin au-common"></i></a>--}}
{{--                   </li>--}}
{{--                 </ul>--}}
                </div>
       </div>

   </div>



    <!--SAME CATEGORY AUCTIONS SECTION-->
     @include('home.pages.auctions.category-auctions')

    <!--SAME CATEGORY AUCTIONS SECTION-->

    <!--SELLER AUCTIONS SECTION-->
    {{-- @include('home.pages.auctions.seller-auctions') --}}

    <!--SELLER AUCTIONS SECTION-->

    @else
    <div class="col-lg-12 col-md-12 col-sm-12">

    </div>
      @endif
      @endif
      @endforeach

 <div class="modal" id="Instrucciones2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Como subastar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img class="d-block w-100" src="{{asset('public/images/imagenaucctio2n.png')}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



    @endsection

@section('footer_scripts')

@include('common.validations')
@include('common.alertify')
@include('home.pages.auctions.auctions-js-script')

 <script src="{{JS_HOME}}jquery.elevatezoom.js"></script>
  <script src="{{JS_HOME}}elevationzoom.js"></script>


<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<script src="{{JS}}share.js"></script>

<script type="text/javascript">

  if ($('#sm-product-zoom').length) {
        $("#sm-product-zoom").elevateZoom({
            gallery: 'gallery_01',
            zoomType: "inner",
            cursor: 'crosshair',
            galleryActiveClass: 'active',
            imageCrossfade: true
        });
    }
</script>

<!-- <script src="{{JS_HOME}}prefixfree.min.js"></script> -->
<!-- <script src="{{JS_HOME}}zoom-slideshow.js"></script> -->

<!-- <script>


$(document).ready(function() {
   // Initialisation du plugin jQuery
   $('#view').setZoomPicture({
   thumbsContainer: '#pics-thumbs',
   prevContainer: '#nav-left-thumbs',
   nextContainer: '#nav-right-thumbs',
   zoomContainer: '#zoom',
   zoomLevel: 2,
   });
});
</script>
 -->

 <script>
  function liveAuction(auction_slug) {

    window.open("{{URL_LIVE_AUCTION}}/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
    console.log("{{URL_LIVE_AUCTION}}/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
  }
 </script>
@endsection
