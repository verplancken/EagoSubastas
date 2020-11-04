<?php $__env->startSection('header_scripts'); ?>

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
@media  screen and (max-width: 986px) {
  .btn-res {
     font-size: 15px;
  }
}

@media  screen and (max-width: 536px) {
  .btn-res {
    font-size: 13px;
  }
    .au-product-nav{
        padding: 5px !important;
    }
}
</style>

 <!--BODY SECTION-->
 <?php $__currentLoopData = $invitacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <?php if($user->email == $item->email): ?>
     <?php if($auction->sub_category_id == $item->auction_id): ?>

        <div class="container">
            <div class="row">
                <div class="accordion" id="accordionExample">
                    <div class="col-12 mt-3" >
                        <div class="d-flex justify-content-between">

                              <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-auction" role="button" aria-controls="nav-auction" aria-expanded="false" >
                                  detalles de la subasta
                              </a>

                              <a class="nav-item au-product-nav nav-link d-inline btn-res" data-toggle="collapse" href="#nav-description" role="button" aria-controls="nav-description" aria-expanded="false">
                                  Descripcion
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

                            
                             <div class="collapse" id="nav-auction" data-parent="#accordionExample">
                              <div class="card card-body shadow">
                                    <h5 class="ml-3"><strong>Detalles de la subasta</strong></h5>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                    Fecha de inicio
                                                  <span class="btn-res"> <strong> Fecha: </strong> <?php echo date(getSetting('date_format','site_settings'), strtotime($auction->start_date));; ?>

                                                  <br> <strong> Hora: </strong> <?php echo date(' H:i:s', strtotime($auction->start_date));; ?>

                                                  </span>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                    Fecha final
                                                  <span class="btn-res"><strong> Fecha: </strong><?php echo date(getSetting('date_format','site_settings'), strtotime($auction->end_date));; ?>

                                                    <br> <strong> Hora: </strong><?php echo date(' H:i:s', strtotime($auction->start_date));; ?>

                                                  </span>
                                                </li>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                     Precio de reserva
                                                  <span class="btn-res"><?php if($auction->reserve_price): ?> $ <?php echo e(number_format($auction->reserve_price)); ?> mxn <?php endif; ?></span>
                                                 </li>


                                                 <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                     Tiros por subasta
                                                  <span class="btn-res"><?php if($auction->tiros): ?> <?php echo e($auction->tiros); ?> <?php endif; ?></span>
                                                 </li>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                                 <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                      Inicio de oferta
                                                  <span class="btn-res"><?php if($auction->minimum_bid): ?> $  <?php echo e(number_format($auction->minimum_bid)); ?> mxn <?php endif; ?></span>
                                                 </li>

                                                  <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                     ¿La subasta de de auto incremento?
                                                    <span class="btn-res">
                                                        <?php if($auction->is_bid_increment==1): ?>
                                                            Si
                                                        <?php else: ?>
                                                            No
                                                        <?php endif; ?>
                                                    </span>
                                                 </li>

                                                <?php if($auction->bid_increment): ?>
                                                     <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                         Incremento de oferta ($MXN)
                                                      <span class="btn-res"><?php echo e($currency_code); ?> <?php echo e($auction->bid_increment); ?></span>
                                                     </li>
                                                 <?php endif; ?>

                                                 <li class="list-group-item d-flex justify-content-between align-items-center btn-res">
                                                    Tipo de subastas
                                                    <span class="btn-res">
                                                    <?php if($auction->visibilidad==1): ?>
                                                        Abierta
                                                    <?php else: ?>
                                                        Cerrada
                                                    <?php endif; ?>
                                                    </span>
                                                 </li>

                                                  <?php if($auction->is_buynow==1): ?>
                                                      <li class="list-group-item d-flex justify-content-between align-items-center btn-res">

                                                          comprar ahora precio
                                                        <span class="btn-res"><?php if($auction->buy_now_price): ?> <?php echo e($currency_code); ?> <?php echo e($auction->buy_now_price); ?> <?php endif; ?></span>
                                                      </li>
                                                  <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            

                             
                             <div class="collapse" id="nav-description" data-parent="#accordionExample">
                                  <div class="card card-body shadow">
                                      <h5 class="ml-3"><strong>Descripcion</strong></h5>
                                        <div class="row">
                                              <div class="col-lg-12 col-md-12 col-sm-12 au-policy">
                                                <p><?php echo $auction->description; ?></p>
                                            </div>
                                        </div>
                                  </div>
                             </div>
                             

                            
                             <div class="collapse" id="nav-shipping" data-parent="#accordionExample">
                                  <div class="card card-body shadow">
                                      <h5 class="ml-3"><strong>Envio y Pago</strong></h5>
                                        <div class="row">

                                            <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                              <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                                <p><?php echo $auction->shipping_conditions; ?></p>

                                              </div>
                                            </div>

                                        </div>
                                  </div>
                             </div>
                             

                             
                             <div class="collapse" id="nav-terms" data-parent="#accordionExample">
                                  <div class="card card-body shadow">
                                      <h5 class="ml-3"><strong>Condiciones De Subasta e Informacion</strong></h5>
                                        <div class="row">

                                            <div class="col-lg-12 col-md-12 col-sm-12 au-terms">
                                                <div class="col-lg-12 col-md-12 col-sm-12 au-policy">

                                                  <p><?php echo $auction->shipping_terms; ?></p>

                                                </div>
                                            </div>

                                        </div>
                                  </div>
                             </div>
                             

                              
                             <div class="collapse" id="nav-bid" data-parent="#accordionExample">
                                  <div class="card card-body shadow">
                                           <h5 class="ml-3"><strong>Historial De Ofertas</strong></h5>
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
        </div>

             <section class="single-product section-pad">
              <div class="container">

                  <div class="row">

                    <div class="col-lg-6">
                       <!-- Product-gallery-container -->

                        <div class="sm-product-show">
                             <div class="sm-product-slider-img">
                                        <img src="<?php echo e(getAuctionImage($auction->image)); ?>" id="sm-product-zoom" class="img-responsive img-fluid" data-zoom-image="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" alt="">
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
                                          <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                            </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-sm text-left" data-toggle="modal" data-target="#Instrucciones2">
                                 <i class="fa fa-question" aria-hidden="true">Ayuda</i>
                            </button>
                             <a class="btn btn-dark btn-sm text-left" href="javascript:location.reload()" data-toggle="tooltip" title="Recargar pagina"> Recargar pag <i class="fa fa-refresh" aria-hidden="true"></i> </a>
                        </div>

                        <div class="d-flex bd-highlight mb-3">
                            <div class="mr-auto p-2 bd-highlight"><h3 class="text-left"><strong><?php echo e($auction->title); ?></strong></h3></div>
                            <div class="p-2 bd-highlight"><p class="text-muted text-right">IDSubasta: <?php echo e($auction->id); ?></p></div>
                            <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-2 bd-highlight"><p class="text-muted text-right">IDLote:<?php echo e($auction->sub_category_id); ?> <strong><?php echo e($lotes->sub_category); ?></strong></p></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                                <?php if(!$live_auction): ?> <!--normal auction happening-->
                                    <?php if($auction->start_date<=now() && $auction->end_date>=now()): ?>
                                        <p title="Auction End Date"> La subasta finaliza <br><strong>Fecha:</strong>  <?php echo date(getSetting('date_format','site_settings'), strtotime($auction->end_date));; ?>

                                                                                         <strong>  Hora:</strong>  <?php echo date(' H:i:s', strtotime($auction->end_date));; ?>

                                    <?php endif; ?>
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
                                                            <br>
                                                            <p>Por favor llena tus datos de  <a href="<?php echo e(URL_USERS_EDIT); ?>/<?php echo e($user->slug); ?>">Facturacion</a></p>
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

                                <?php if(!$live_auction): ?>
                            <!--si la subasta en vivo no ocurre subasta normal-->

                            <?php if($auction->auction_status=='open' && $auction->start_date<=now() && $auction->end_date>=now()): ?>
                            <!--si el estado de la subasta es inicio en vivo-->
                             <!--producto con contenido de borde-->
                               <?php if($bid_div): ?>
                                 <div class="product-border">
                                               <!-- <p class="text-blue"><b><i class="pe-7s-timer"> </i>
                                                    <?php echo e(strtoUpper(getAuctionDaysLeft($auction->start_date,$auction->end_date))); ?></b></p>-->
                                                   <div class="row">
                                                       <div class="col-12">
                                                           <h4>
                                                                <p data-toggle="tooltip" title="  Oferta Inicial" data-placement="top" >
                                                                    Oferta Inicial  <strong> $<?php echo number_format($auction->minimum_bid); ?> MXN </strong>
                                                                </p>
                                                            </h4>
                                                       </div>
                                                      <div class="col-lg-12 col-md-12 col-sm-12 au-deals">
                                                          <?php if($auction->visibilidad == 1): ?>
                                                              <h2 style="font-weight: 500">Última oferta $<?php echo number_format($last_bid->bid_amount); ?> MXN</h2>
                                                              <?php else: ?>
                                                              <h2 style="font-weight: 500">Última oferta $<?php echo number_format($last_bidcerrada->bid_amount); ?> MXN</h2>
                                                          <?php endif; ?>
                                                      </div>
                                                   </div>

                                        <?php if($bid_options || $bid_options2): ?>
                                            <?php if($auction->visibilidad == 1): ?>
                                                <div class="d-flex justify-content-between">
                                                   <p>Seleccione oferta máxima</p>
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
                                                   <?php if($auction->is_bid_increment == 1): ?>
                                                      <p class="ml-3" title="Incremento" data-placement="top" >Incremento de: <strong>$<?php echo number_format($auction->bid_increment); ?> MXN</strong></p>
                                                   <?php endif; ?>
                                                </div>
                                                    <div class="row">
                                                          <div class="col-lg-12">
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

                                                          <div class="col-lg-12">
                                                              <div class="form-group">
                                                                  <input type="hidden" name="bid_auction_id" value="<?php echo e($auction->id); ?>">
                                                                  <input type="hidden" name="sub" value="<?php echo e($auction->sub_category_id); ?>">
                                                                  <div class="d-flex justify-content-between">
                                                                      <a class="btn btn-danger"  href="<?php echo e(URL_HOME_AUCTIONS); ?>" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true" ></i>   Reg a Subastas</a>
                                                                      <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                             <?php echo Form::close(); ?>


                                                                 <?php else: ?>
                                                                    <p>Lo sentimos, ya no puede subastar</p>
                                                                 <?php endif; ?>
                                                                 <?php break; ?>
                                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>

                                            <?php else: ?>
                                                <div class="d-flex justify-content-between">
                                                   <p>Seleccione oferta máxima</p>
                                                   <?php if($auction->is_bid_increment == 1): ?>
                                                      <p class="ml-3" title="Incremento" data-placement="top" >Incremento de: <strong>$<?php echo number_format($auction->bid_increment); ?> MXN</strong></p>
                                                   <?php endif; ?>
                                                </div>
                                                    <div class="row">
                                                        <div class="col-lg-5">
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
                                                            <?php echo Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')); ?>


                                                            
                                                          <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($auctionbidders2[0]->bidder_count < $lotes->articulos): ?>
                                                                    <div class="form-group">
                                                                        <?php echo e(Form::select('bid_amount', $bid_options2, null, ['placeholder'=>'select',

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

                                                               <div class="d-flex justify-content-between">
                                                                   <a class="btn btn-danger"  href="<?php echo e(URL_HOME_AUCTIONS); ?>" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver a Subastas</a>
                                                                   <button data-toggle="tooltip" title="Subastar" data-placement="top" class="btn btn-success login-bttn au-btn-modren" ng-disabled='!formBid.$valid'> <i class="fa fa-gavel"></i>   Ofertar</button>
                                                               </div>
                                                           </div>
                                                       </div>
                                                             <?php echo Form::close(); ?>


                                                            <?php else: ?>
                                                                <p>Lo sentimos, ya no puede subastar</p>
                                                            <?php endif; ?>
                                                            <?php break; ?>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>

                                            <?php endif; ?>
                                        <?php else: ?>

                                            <div class="row">
                                              <div class="col-lg-12">
                                                <?php echo Form::open(array('url' => URL_SAVE_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')); ?>


                                                    
                                                        <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($auction->sub_category_id == $lotes->id): ?>
                                                                <?php if($auctionbidders2[0]->bidder_count < $lotes->articulos): ?>

                                                                          <div class="form-group" style="animation-name:pulse ;animation-delay: 1.5s; animation-duration: 2.0s; ">
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
                                                                              <div class="d-flex justify-content-between">
                                                                                  <a class="btn btn-danger"  href="<?php echo e(URL_HOME_AUCTIONS); ?>" data-toggle="tooltip" title="Regresar a las subastas" data-placement="top" > <i class="fa fa-arrow-left" aria-hidden="true"></i>   Volver a Subastas</a>
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
                                             <div class="row">
                                                 <div class="col-12">
                                                     <div class="d-flex justify-content-between">
                                                         <?php $__currentLoopData = $auctionbidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <?php if($item->auction_id == $auction->id): ?>
                                                                     <div class="d-flex flex-column bd-highlight text-success">
                                                                         <a class="text-info" href="#" data-toggle="modal" data-target="#bidHistoryModal" title="Tiros Realizados">
                                                                             <h6 class="text-center d-inline-block" style="text-decoration: underline"><strong>Tiros Realizados</strong></h6>
                                                                             <p class="text-center"><?php echo e($item->no_of_times); ?></p>
                                                                         </a>
                                                                     </div>
                                                             <?php endif; ?>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         <div class="d-flex flex-column bd-highlight ">
                                                             <h6 class="text-center d-inline-block" style="color:#888888"><strong>Tiros permitidos</strong></h6>
                                                             <p class="text-center" style="color:#888888"><?php echo e($auction->tiros); ?></p>
                                                         </div>
                                                             <?php $__currentLoopData = $auctionbidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <div class="d-flex flex-column bd-highlight text-success">
                                                                     <a href="#" data-toggle="modal" data-target="#ModalWon" title="Articulos ganados" style="color:#17a2b8">
                                                                         <h6 class="text-center" style="text-decoration: underline"><strong>Art ganados</strong></h6>
                                                                         <p class="text-center"><?php echo $auctionbidders2[0]->bidder_count; ?></p>
                                                                     </a>
                                                                 </div>
                                                                 <?php break; ?>
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                             <?php $__currentLoopData = $lote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <div class="d-flex flex-column bd-highlight text-primary">
                                                                     <h6 class="text-center" style="color: #888888;"><strong> Art a ganar</strong></h6>
                                                                     <p class="text-center" style="color: #888888;"><?php echo e($lotes->articulos); ?></p>
                                                                 </div>
                                                                 <?php break; ?>
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                     </div>
                                                 </div>
                                             </div>
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
                                                     La subasta inicia:  <strong>Fecha:</strong> <?php echo date(getSetting('date_format','site_settings'), strtotime($auction->end_date));; ?>

                                                      <br> <strong>Hora: </strong> <?php echo date(' H:i:s', strtotime($auction->end_date));; ?><br>
                            <!--if auction status is closed end-->
                            <?php endif; ?>

                          <?php endif; ?>
                  <!--if live auction not happening-->
                            <br>
                            <div>

                              <?php if(Auth::user()): ?>
                                <a href="javascript:void(0);" ng-click="addtoFavourites(<?php echo e($auction->id); ?>)" title="añadir a la lista de deseos" class="btn btn-info au-btn-modren login-bttn"><i class="pe-7s-plus"></i>
                                    añadir a la lista de deseos
                                </a>
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

            <!--SELLER AUCTIONS SECTION-->
            
            <!--SELLER AUCTIONS SECTION-->
     <?php else: ?>
     <?php endif; ?>
   <?php endif; ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <!--END BODY SECTION-->

<!-- Bid history Modal -->
<div class="modal fade right" id="bidHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-right" role="document">


    <div class="modal-content">
      <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">historial de ofertas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          <table class="table">

              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="text-center">
                      <i class="fa fa-money" aria-hidden="true"></i>    Monto de la oferta
                      <p class="bg-light text-center" style="padding: 2px; width: 100px; position: relative; top: 5px; left: 27%"></p>
                  </th>
                  <th scope="col" class="text-center">
                      <i class="fa fa-calendar" aria-hidden="true"></i>    Fecha y hora
                      <p class="bg-light text-center" style="padding: 2px; width: 75px; position: relative; top: 5px; left: 35%"></p>
                  </th>
                </tr>
              </thead>

              <tbody>
               <?php $__currentLoopData = $tiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subastas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>

                      <td class="text-center">$<?php echo number_format($subastas->bid_amount); ?> MXN</td>

                      <td class="text-center">
                          <strong>Fecha:</strong> <?php echo date(getSetting('date_format','site_settings'), strtotime($subastas->created_at));; ?>

                                          <br> <strong>Hora: </strong> <?php echo date(' H:i:s', strtotime($subastas->created_at));; ?>

                      </td>

                </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>

            </table>

    </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-secondary login-bttn" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>
<!--Bid history modal END-->

<!-- Modal Won -->
<div class="modal fade right" id="ModalWon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-right" role="document">


    <div class="modal-content">
      <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Articulos ganados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">


        <ul class="list-group z-depth-0">

            <li class="list-group-item justify-content-between">
              <div class="d-flex justify-content-between">
                 <span><b>Articulo</b></span>
                 <span><b>fecha y hora</b></span>
                 <span><b>Ver</b></span>
              </div>
            </li>

            <?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item justify-content-between">
                        <div class="d-flex justify-content-between">
                            <span> <?php echo e($articulo->title); ?></span>
                            <span style="float:right;"><strong>Fecha:</strong> <?php echo date(getSetting('date_format','site_settings'), strtotime($articulo->created_at));; ?>

                                 <br> <strong>Hora: </strong> <?php echo date(' H:i:s', strtotime($articulo->created_at));; ?>

                            </span>
                            <a  target="_blank" href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($articulo->auction_slug); ?>">
                                <span>Ir</span>
                            </a>
                        </div>
                    </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

    </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-secondary login-bttn" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>
<!--Modal Won END-->

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

 <script>
  function liveAuction(auction_slug) {

    window.open("<?php echo e(URL_LIVE_AUCTION); ?>/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
    console.log("<?php echo e(URL_LIVE_AUCTION); ?>/"+auction_slug, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=300,width=800,height=500");
  }
 </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>