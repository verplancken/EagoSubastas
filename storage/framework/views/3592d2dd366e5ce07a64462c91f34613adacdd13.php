<?php $__env->startSection('header_scripts'); ?>

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$today = DATE('d-m-Y');
$currency_code = getSetting('currency_code','site_settings');
$auctin_url = URL_HOME_AUCTIONS;

$enter_amount = 'Ingresar cantidad ';
if (isset($last_bid) && !empty($last_bid->bid_amount))
  $enter_amount .= 'mayor a '.number_format($last_bid->bid_amount);
elseif ($auction->minimum_bid>0)
  $enter_amount .= 'mayor a '.number_format($auction->minimum_bid);

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


<div class="container">
    <div class="row">
        <div class="col-12 mt-3" >
            <div class="d-flex justify-content-between">

                  <a class="nav-item au-product-nav nav-link active d-inline" data-toggle="collapse" href="#nav-auction" role="button" aria-controls="nav-auction" aria-expanded="false">
                      detalles de la subasta
                  </a>

                  <a class="nav-item au-product-nav nav-link d-inline" data-toggle="collapse" href="#nav-shipping" role="button" aria-controls="nav-shipping" aria-expanded="true">
                      Envío & pago
                  </a>

                  <a class="nav-item au-product-nav nav-link d-inline" data-toggle="collapse" href="#nav-terms" role="button" aria-controls="nav-terms" aria-expanded="false">
                      condiciones de subasta & informacion
                  </a>

                  <a class="nav-item au-product-nav nav-link d-inline" data-toggle="collapse" href="#nav-bid" role="button" aria-controls="nav-bid" aria-expanded="false">
                      historial de ofertas
                  </a>

            </div>

                
                 <div class="collapse" id="nav-auction">
                  <div class="card card-body">
                        <div class="row">

                            <div class="col-4 ">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Fecha de inicio
                                      <span> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?></span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Fecha final
                                      <span> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </span>
                                    </li>
                            </div>

                            <div class="col-4 ">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                         Precio de reserva
                                      <span><?php if($auction->reserve_price): ?> <?php echo e($currency_code); ?> <?php echo e(number_format($auction->reserve_price)); ?> <?php endif; ?></span>
                                     </li>


                                     <li class="list-group-item d-flex justify-content-between align-items-center">
                                         Tiros por subasta
                                      <span><?php if($auction->tiros): ?> <?php echo e($auction->tiros); ?> <?php endif; ?></span>
                                     </li>
                            </div>

                            <div class="col-4 ">

                                     <li class="list-group-item d-flex justify-content-between align-items-center">
                                          Inicio de oferta
                                      <span><?php if($auction->minimum_bid): ?> <?php echo e($currency_code); ?>  <?php echo e(number_format($auction->minimum_bid)); ?> <?php endif; ?></span>
                                     </li>

                                      <li class="list-group-item d-flex justify-content-between align-items-center">
                                         ¿La subasta de de auto incremento?
                                        <span>
                                            <?php if($auction->is_bid_increment==1): ?>
                                                Si
                                            <?php else: ?>
                                                No
                                            <?php endif; ?>
                                        </span>
                                     </li>

                                    <?php if($auction->bid_increment): ?>
                                         <li class="list-group-item d-flex justify-content-between align-items-center">
                                             Incremento de oferta ($MXN)
                                          <span><?php echo e($currency_code); ?> <?php echo e($auction->bid_increment); ?></span>
                                         </li>
                                     <?php endif; ?>

                                     <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tipo de subastas
                                        <span>
                                        <?php if($auction->visibilidad==1): ?>
                                            Abierta
                                        <?php else: ?>
                                            Cerrada
                                        <?php endif; ?>
                                        </span>
                                     </li>

                                      <?php if($auction->is_buynow==1): ?>
                                          <li class="list-group-item d-flex justify-content-between align-items-center">

                                              comprar ahora precio
                                            <span><?php if($auction->buy_now_price): ?> <?php echo e($currency_code); ?> <?php echo e($auction->buy_now_price); ?> <?php endif; ?></span>
                                          </li>
                                      <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
                

                
                 <div class="collapse" id="nav-shipping">
                      <div class="card card-body">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                  <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                    <p><?php echo $auction->shipping_conditions; ?></p>

                                  </div>
                                </div>

                            </div>
                      </div>
                 </div>
                 

                 
                 <div class="collapse" id="nav-terms">
                      <div class="card card-body">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                    <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                      <p><?php echo $auction->shipping_terms; ?></p>

                                    </div>
                                </div>

                            </div>
                      </div>
                 </div>
                 

                  
                 <div class="collapse" id="nav-bid">
                      <div class="card card-body">
                            <div class="row">

                              <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                  <div class=" au-policy">

                                    <?php if(isset($bidding_history) && count($bidding_history)): ?>

                                      <?php if($auction->visibilidad==1): ?>
                                        <ul class="list-group z-depth-0">
                                          <li class="list-group-item justify-content-between">
                                              <span><b><?php echo e(getPhrase('username')); ?></b></span>
                                              <span style="float:right;"><b><?php echo e(getPhrase('bid_amount')); ?></b></span>
                                          </li>
                                          <?php $__currentLoopData = $bidding_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <li class="list-group-item justify-content-between">
                                                <span>Usuario</span>
                                                <span style="float:right;">$<?php echo e($bid->bid_amount); ?> MXN</span>
                                              </li>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                       <?php else: ?>
                                         <span>Usuario</span>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                  </div>
                              </div>

                            </div>
                      </div>
                 </div>
                 


        </div>
    </div>
</div>


 <!--CATEGORY BODY SECTION-->
 <?php $__currentLoopData = $invitacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($user->email == $item->email): ?>
    <?php if($auction->sub_category_id == $item->auction_id): ?>

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
                            <img src="<?php echo e(getAuctionImage($auction->image)); ?>" id="sm-product-zoom" class="img-responsive" data-zoom-image="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" alt="">
                            <i class="sm-zoom-icn fa fa-expand"></i>
                        </div>


                        <?php if($active_picture_gallary=='Yes'): ?>
                        <ul class="product-slider-thumbs" id="gallery_01">

                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-image="<?php echo e(getAuctionImage($auction->image,'auction')); ?>">
                                    <img id="img_01" src="<?php echo e(getAuctionImage($auction->image)); ?>" alt="">
                                </a>
                            </li>

                          <?php if($auction_images): ?>
                          <?php $i=0;?>
                          <?php $__currentLoopData = $auction_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php $i=$i+1;

                          if ($i==$max_number_of_pictures)
                            break;
                          ?>
                          <?php if($image->filename && file_exists(AUCTION_IMAGES_PATH.$image->filename)): ?>
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-image="<?php echo e(AUCTION_IMAGES_PATH_URL); ?><?php echo e($image->filename); ?>">
                                    <img id="img_01" src="<?php echo e(AUCTION_IMAGES_PATH_URL); ?><?php echo e($image->filename); ?>" alt="">
                                </a>
                            </li>
                            <?php endif; ?>


                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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
                            <?php endif; ?>
                        </ul>

                        <?php endif; ?>
                    </div>

                    <!-- /Product-gallery-container-->
               <!-- <img id="zoom_01" src="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" data-zoom-image="<?php echo e(IMAGES_HOME); ?>large/image1.jpg" class="img-fluid"> -->
             </div>


            <div class="col-lg-6">

                <button class="btn btn-primary btn-sm text-left" data-toggle="modal" data-target="#Instrucciones2">
                     <i class="fa fa-question" aria-hidden="true"></i>
                </button>

                <div class="d-flex bd-highlight mb-3">
                  <div class="mr-auto p-2 bd-highlight"><h4 class="text-left"><?php echo e($auction->title); ?></h4></div>
                  <div class="p-2 bd-highlight"><p class="text-muted text-right">IDSubasta<?php echo e($auction->id); ?></p></div>
                  <div class="p-2 bd-highlight"><p class="text-muted text-right">IDLote:<?php echo e($auction->sub_category_id); ?></p></div>
                </div>

                   <?php if(!$live_auction): ?> <!--normal auction happening-->
                        <p title="Auction End Date"> La subasta regular finaliza el <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </p>
                   <?php endif; ?>

                    <?php if($live_auction_starts): ?>
                      <p title="Auction End Date"> La subasta en vivo comienza en <i class="fa fa-clock-o"></i><?php echo e($auction->live_auction_start_time); ?>, Prepárate para participar</p>
                    <?php endif; ?>
                <?php $__currentLoopData = $auctionbidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(Session::has('succes')): ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-warning alert-dismissible fade show mb-4 mt-4" role="alert">
                                            <?php echo e(Session::get('succes')); ?>

                                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                     <?php break; ?>
                                <?php endif; ?>
                                  <?php if(Session::has('warning')): ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-warning alert-dismissible fade show mb-4 mt-4" role="alert">
                                            <?php echo e(Session::get('warning')); ?>

                                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                    <?php break; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <?php if($live_auction): ?> <!--live auction happening-->

              <div>
                  <p title="Auction End Date"> ¡Subasta en vivo ahora! de <i class="fa fa-clock-o"></i><?php echo e($auction->live_auction_start_time); ?> a <i class="fa fa-clock-o"></i><?php echo e($auction->live_auction_end_time); ?></p>
              </div>

              <div class="">
                <?php if(!Auth::check()): ?>

                     <a class="btn btn-info au-btn-modren login-bttn" href="javascript:void(0);" onclick="showModal('loginModal')">participar en una subasta en vivo</a>
                <?php else: ?>

                     <a class="btn btn-info au-btn-modren login-bttn live" href="javascript:void(0);" onclick="liveAuction('<?php echo e($auction->slug); ?>')">participar en una subasta en vivo</a>
                <?php endif; ?>
              </div>
              <?php endif; ?>


              <?php if(!$live_auction): ?><!--si la subasta en vivo no ocurre subasta normal-->

                <?php if($auction->auction_status=='open' && $auction->start_date<=now() && $auction->end_date>=now()): ?>
                <!--si el estado de la subasta es inicio en vivo-->
                 <!--producto con contenido de borde-->
                 <?php if($bid_div): ?>
     <div class="product-border">
                   <!-- <p class="text-blue"><b><i class="pe-7s-timer"> </i>
                        <?php echo e(strtoUpper(getAuctionDaysLeft($auction->start_date,$auction->end_date))); ?></b></p>-->
                       <div class="row">
                           <div class="col-6">
                               <h4>
                                    <p data-toggle="tooltip" title="Precio de reserva" data-placement="top" >Precio Reserva <br> <strong>$<?php echo number_format($auction->reserve_price); ?> MXN</strong></p>

            
                                  <!--<span class="badge" data-toggle="tooltip" title="No. de ofertantes" data-placement="top" >-->
                                    <!--<?php if($total_bids>1): ?>-->
                                    <!--     ofertas - <?php echo e($total_bids); ?>-->
                                    <!--<?php elseif($total_bids==1): ?>-->
                                    <!--      oferta - <?php echo e($total_bids); ?>-->
                                    <!--<?php else: ?>-->
                                    <!--    0 <?php echo e(getPhrase('bids')); ?>-->
                                    <!--<?php endif; ?>-->
                                  <!--</span>-->

                                </h4>
                           </div>
                           <div class="col-6">
                               <?php $__currentLoopData = $auctionbidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <?php if($item->auction_id == $auction->id): ?>
                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #2064e7; border-radius: 10px; color: #fff" >
                                      Tiros realizados <span class="badge" style="background-color: #0c100c;"><?php echo e($item->no_of_times); ?></span>
                                    </button>
                                   <?php endif; ?>

                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #2064e7; border-radius: 10px; color: #fff" >
                                      Tiros permitidos <span class="badge" style="background-color: #0c100c;"><?php echo e($auction->tiros); ?></span>
                                    </button>

                               <?php $__currentLoopData = $auctionbidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="btn mb-3" style="padding: 3px; font-size: 12px; background-color: #e9841a; border-radius: 10px; color: #fff" >
                                      Art ganados <span class="badge" style="background-color: #0c100c;"><?php echo $auctionbidders2[0]->bidder_count; ?></span>
                                    </button>
                                       <?php break; ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                               <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="btn mb-3 ml-4" style="padding: 3px; font-size: 12px; background-color: #e9841a; border-radius: 10px; color: #fff" >
                                      Art a ganar <span class="badge" style="background-color: #0c100c;"><?php echo e($lotes->articulos); ?></span>
                                    </button>
                                   <?php break; ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                           </div>
                       </div>


            <?php if($bid_options): ?>

              
                                <p>Seleccione oferta máxima</p>
                        <div class="row">
                          <div class="col-lg-5">
                                <?php echo Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')); ?>


                                
                              <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($auctionbidders2[0]->bidder_count < $lotes->articulos): ?>
                                                  <div class="form-group">
                                                        <?php echo e(Form::select('bid_amount', $bid_options, null, ['placeholder'=>'select',

                                                            'class'=>'form-control',

                                                            'ng-model'=>'bid_amount',

                                                            'required'=> 'true',

                                                            'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}'

                                                        ])); ?>

                                                        <div class="validation-error" ng-messages="formBid.bid_amount.$error" ></div>
                                                      </div>
                          </div>
                                <div class="col-lg-7">

                                                      <div class="form-group">
                                                        <input type="hidden" name="bid_auction_id" value="<?php echo e($auction->id); ?>">
                                                        <input type="hidden" name="sub" value="<?php echo e($auction->sub_category_id); ?>">
                                                          <div class="col-12 d-flex">
                                                            <a class="btn btn-danger"  href="<?php echo e(URL_HOME_AUCTIONS); ?>" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver</a>
                                                            <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>

                                                          </div>
                                                          </div>
                                                      </div>
                                                      <?php echo Form::close(); ?>


                                                            <?php if($auction->is_bid_increment == 1): ?>
                                                                <p class="ml-3" title="Precio de reserva" data-placement="top" >Incremento de: <strong>$<?php echo number_format($auction->bid_increment); ?> MXN</strong></p>
                                                           <?php endif; ?>
                                      <?php else: ?>
                                        <p>Lo sentimos, ya no puede subastar</p>
                                      <?php endif; ?>
                                       <?php break; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          </div>
                        </div>
            <?php else: ?>

                <div class="row">
                  <div class="col-lg-12">

                    <?php echo Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')); ?>


                        
                            <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($auction->sub_category_id == $lotes->id): ?>
                                    <?php if($auctionbidders2[0]->bidder_count < $lotes->articulos): ?>
                                              <div class="form-group">
                                                <?php echo e(Form::number('bid_amount', null, $attributes =

                                                    array('class' => 'form-control',

                                                    'placeholder' => $enter_amount,

                                                    'ng-model' => 'bid_amount',

                                                    'required' => 'true',

                                                    'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}',

                                                    ))); ?>

                                                <div class="validation-error" ng-messages="formBid.bid_amount.$error" ></div>
                                              </div>


                                              <div class="form-group">
                                                <input type="hidden" name="bid_auction_id" value="<?php echo e($auction->id); ?>">
                                                <input type="hidden" name="sub" value="<?php echo e($auction->sub_category_id); ?>">
                                                  <div class="col-12 d-flex">
                                                      <a class="btn btn-danger"  href="<?php echo e(URL_HOME_AUCTIONS); ?>" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver</a>
                                                    <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>
                                                  </div>
                                              </div>
                                              <?php echo Form::close(); ?>


                                    <?php else: ?>
                                        <p>Lo sentimos, ya no puede subastar, ha ganado el numero de articulos permitidos </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                  </div>
                </div>
            <?php endif; ?>
                </div>
                <?php endif; ?>

                <!--/product with border content-->
                <!--if auction status is live end-->
                <?php elseif($auction->auction_status=='new' && $auction->start_date<=now() && $auction->end_date>=now()): ?>
                <!--if auction status is upcoming start-->
                <div>
                    <p class="text-blue"><b><i class="pe-7s-timer"></i> <?php echo e(strtoUpper(getAuctionDaysLeft($auction->start_date,$auction->end_date))); ?></b></p>

                     <h4>
                      <?php echo e($currency_code); ?><?php echo e($auction->reserve_price); ?>

                      <span class="badge">
                           <?php echo e($auction->getAuctionBiddersCount()); ?> ofertas
                      </span>
                    </h4>
                </div>
                <!--if auction status is upcoming end-->
                <?php elseif($auction->auction_status=='closed'): ?>
                <!--if auction status is closed start-->
                 <div>
                     <p class="text-blue">
                         <b> Subasta finalizada </b>
                     </p>


                </div>
                 <?php else: ?>
                        <strong>La subasta inicia:  <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?><br></strong>
                <!--if auction status is closed end-->
                <?php endif; ?>

                <?php endif; ?> <!--if live auction not happening-->
                <br>
                <div>

                  <?php if(Auth::user()): ?>
                    <a href="javascript:void(0);" ng-click="addtoFavourites(<?php echo e($auction->id); ?>)" title="añadir a la lista de deseos" class="btn btn-info au-btn-modren login-bttn"><i class="pe-7s-plus"></i>

                        añadir a la lista de deseos</a>
                  <?php else: ?>
                   <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Add to Wishlist" class="btn btn-info au-btn-modren login-bttn">

                       <i class="pe-7s-plus"></i> añadir a la lista de deseos
                   </a>
                  <?php endif; ?>


                  <?php if($auction->is_buynow==1 && $auction->buy_now_price && $is_already_sold=='No'): ?>
                  <?php if($bid_div): ?>
                  <?php if(Auth::user()): ?>

                      <a href="<?php echo e(URL_BID_AUCTION_PAYMENT); ?>/<?php echo e($auction->slug); ?>" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn"> compra ahora</a>
                  <?php else: ?>

                      <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Buy Auction" class="btn btn-info au-btn-modren login-bttn">compra ahora </a>
                  <?php endif; ?>
                  <?php endif; ?>
                  <?php endif; ?>


                 





















                </div>
       </div>

   </div>



    <!--SAME CATEGORY AUCTIONS SECTION-->
     <?php echo $__env->make('home.pages.auctions.category-auctions', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!--SAME CATEGORY AUCTIONS SECTION-->

    <!--SELLER AUCTIONS SECTION-->
    

    <!--SELLER AUCTIONS SECTION-->

    <?php else: ?>
    <div class="col-lg-12 col-md-12 col-sm-12">

    </div>
      <?php endif; ?>
      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
        <img class="d-block w-100" src="<?php echo e(asset('public/images/imagenaucctio2n.png')); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



    <?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

<?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('home.pages.auctions.auctions-js-script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 <script src="<?php echo e(JS_HOME); ?>jquery.elevatezoom.js"></script>
  <script src="<?php echo e(JS_HOME); ?>elevationzoom.js"></script>


<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<script src="<?php echo e(JS); ?>share.js"></script>

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

<!-- <script src="<?php echo e(JS_HOME); ?>prefixfree.min.js"></script> -->
<!-- <script src="<?php echo e(JS_HOME); ?>zoom-slideshow.js"></script> -->

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

    window.open("<?php echo e(URL_LIVE_AUCTION); ?>/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
    console.log("<?php echo e(URL_LIVE_AUCTION); ?>/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
  }
 </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>