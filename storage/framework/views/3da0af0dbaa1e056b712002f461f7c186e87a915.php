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
                <?php if($featured_enable=='Yes'): ?>
                    <?php $__currentLoopData = $invitacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($user->email == $item->email): ?>
                                <div class="row">
                                   <?php $__currentLoopData = $featured_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($auction->sub_category_id == $item->auction_id): ?>

                                          <div class="col-lg-12 col-md-12 col-sm-3 p-3">

                                              <div class="au-accordina">
                                                  <div class="au-thumb"><a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>"> <img src="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" alt="<?php echo e($auction->title); ?>" class="img-fluid premium-img"></a> </div>

                                                  <div class="au-acord-secret">
                                                       <h6 class="card-title text-center" data-toggle="tooltip" title="<?php echo e($auction->title); ?>" data-placement="bottom"><a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>"><?php echo str_limit($auction->title,25,'..'); ?></a></h6>
                                                  </div>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?></p>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </p>


                                              </div>
                                          </div>
                                       <?php endif; ?>
                                       <?php break; ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                         <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Ver mas</button>
                          <!--featured auctions start-->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
                <?php if($featured_enable=='Yes'): ?>
                    <?php $__currentLoopData = $invitacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($user->email == $item->email): ?>
                            <?php if(count($featured_records)): ?>
                                <div class="row">
                                   <?php $__currentLoopData = $featured_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($auction->sub_category_id == $item->auction_id): ?>

                                          <div class="col-lg-3 col-md-3 col-sm-3 p-3">

                                              <div class="au-accordina">
                                                  <div class="au-thumb"><a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>"> <img src="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" alt="<?php echo e($auction->title); ?>" class="img-fluid premium-img"></a> </div>

                                                  <div class="au-acord-secret">
                                                       <h6 class="card-title text-center" data-toggle="tooltip" title="<?php echo e($auction->title); ?>" data-placement="bottom"><a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>"><?php echo str_limit($auction->title,25,'..'); ?></a></h6>
                                                  </div>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->start_date));?></p>

                                                  <p class="card-title text-center"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </p>


                                              </div>
                                          </div>
                                       <?php endif; ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                         <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
           </div>
  </div>
</div>
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
      <?php $__currentLoopData = $invitacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($user->email == $item->email): ?>
            <?php if(count($auctions)): ?>
            <?php $__currentLoopData = $auctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($auction->sub_category_id == $item->auction_id): ?>

        <div class="col-lg-4 col-md-6 col-sm-6 au-item-categorys">
         <div class="card au-cards">
            <?php if(Auth::user()): ?>
            <a href="javascript:void(0);" onclick="auctionAddtoFavourites(<?php echo e($auction->id); ?>)" title="Add to Wishlist"><i class="pe-7s-like"></i></a>
            <?php else: ?>
             <a href="javascript:void(0);" onclick="showModal('loginModal')" title="Add to Wishlist"><i class="pe-7s-like"></i></a>
            <?php endif; ?>

            <a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>" title="View Auction Details"><img class="img-fluid auction-img" src="<?php echo e(getAuctionImage($auction->image,'auction')); ?>" alt="<?php echo e($auction->title); ?>"></a>
            <div class="card-block au-card-block">
              <a href="<?php echo e(URL_HOME_AUCTION_DETAILS); ?>/<?php echo e($auction->slug); ?>" title="View Auction Details"><h4 class="card-title au-title"> <?php echo str_limit($auction->title,40,''); ?> </h4></a>


              
              <?php if($auction->auction_status=='open' && $auction->start_date<=NOW() && $auction->end_date>=NOW()): ?>
              <?php $total_bids = $auction->getAuctionBiddersCount();?>

              <ul class="action-card-details">
                  <li><p><small title="Auction End Date">
                    <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?>
                  </small><span class="pull-right"><small><?php echo e(getAuctionDaysLeft($auction->start_date,$auction->end_date)); ?></small></span></p></li>
                   <li><p><small title="Precio reserva"><?php echo e($currency_code); ?><?php echo e($auction->reserve_price); ?></small></p></li>
              </ul>

              <?php elseif($auction->auction_status=='new' && $auction->start_date<=NOW() && $auction->end_date>=NOW()): ?>
              <p>
                <span style="float:left;"><small title="Auction End Date"> <?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?> </small></span>
                <span style="float:right;"><small title="Reserve Price"><?php echo e($currency_code); ?><?php echo e($auction->reserve_price); ?></small></span>
              </p>
              <?php elseif($auction->auction_status=='closed'): ?>
              <p>
              <span style="float:left;"><small title="Auction End Date"><?php echo date(getSetting('date_format','site_settings').' H:i:s', strtotime($auction->end_date));?></small></span>
              <span style="float:right;"><small><?php echo e(getPhrase('auction_ended')); ?></small></span>
              </p>
              <?php endif; ?>

            </div>
          </div>
        </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h4 class="text-center">No hay subastas</h4>
    </div>
                <?php break; ?>
    <?php endif; ?>

    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


   <?php echo e($auctions->links()); ?>



<!-- <div>
    Showing <?php echo e(($auctions->currentpage()-1)*$auctions->perpage()+1); ?> to <?php echo e($auctions->currentpage()*$auctions->perpage()); ?>

    of  <?php echo e($auctions->total()); ?> entries
</div>


<div>
  <?php echo e(($auctions->currentpage()-1) * $auctions->perpage() + $auctions->count()); ?>

</div> -->


  </div>
</div>
<!--Pagination Section-->


