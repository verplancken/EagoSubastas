<?php $__env->startSection('header_scripts'); ?>
<link href="<?php echo e(CSS); ?>bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo e(CSS); ?>checkbox.css" rel="stylesheet" type="text/css">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<?php
$featured_enable = getSetting('enable_featured_items','auction_settings');
$currency_code = getSetting('currency_code','site_settings');
$auctin_url = URL_HOME_AUCTIONS;


$open_auctions_count   = \App\Auction::getHomeAuctionStatusAuctions('open')->count();
$new_auctions_count    = \App\Auction::getHomeAuctionStatusAuctions('new')->count();
$closed_auctions_count = \App\Auction::getHomeAuctionStatusAuctions('closed')->count();
?>


  <!--CATEGORY BODY SECTIONAUCTIONS-->


    <?php echo $__env->make('home.pages.auctions.ajax_auctions', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <!--CATEGORY BODY SECTION-->
    <div class="modal" id="Instrucciones" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Instrucciones de ususario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img class="d-block w-100" src="<?php echo e(asset('public/images/imagenaucction.png')); ?>">
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

<!-- <script src="<?php echo e(JS); ?>moment.min.js"></script> -->
<script src="<?php echo e(JS); ?>bootstrap-datepicker.min.js"></script>
<script>

  var selected_js_format = '<?php echo getSetting('date_format_js','site_settings');?>';

/*var dateformat = '<?php echo getSetting('date_format','site_settings');?>';
if (dateformat=='' || dateformat==null)
  dateformat = 'yyyy-mm-dd';*/


$('.datepicker').datepicker({
   // format: dateformat
   format: selected_js_format,
});

var anchors = $(".pagination li a").click(function() {
  //savesubcat()
  $(this).addClass("active")
  anchors.not(this).removeClass("active")
})

</script>


<script type="text/javascript">

/*function getItemTypeAuctions(item_type) {
  console.log(item_type.value);
  var item_type = item_type.value;
  var url = '<?php echo $auctin_url;?>';
  getAuctions(url,item_type);
}
*/
$("input[name='item_type']").change(function () {
    var url = '<?php echo $auctin_url;?>';
    var item_type=$(this).val();
    getAuctions(url,item_type);
});



var auctionStatus = [];
/* look for all checkboxes that have a class 'chk' attached to it and check if it was checked */
$(".auction-status").click(function() {
  var auctionStatus = [];
  $("input[name='auction_status']:checked").each(function() {
    auctionStatus.push($(this).val());
  });
 var url = '<?php echo $auctin_url;?>';
 getAuctions(url,'',auctionStatus);
});



$('#auction_date').datepicker()
    .on("input change", function (e) {
    $("#clear_date").fadeIn();
    var url = '<?php echo $auctin_url;?>';
    var auction_date = $("#auction_date").val();

    getAuctions(url,'','',auction_date);
});


$("#clear_date").click(function(){
  $('#auction_date').data('datepicker').setDate(null);
  $("#clear_date").fadeOut();

  var url = '<?php echo $auctin_url;?>';
  getAuctions(url,'','','');
});


$("input[name='featured']").change(function () {
    var url = '<?php echo $auctin_url;?>';

    var featured= $(this).is(':checked');
    getAuctions(url,'','','','',featured);
});


var subCategories = [];
/* look for all checkboxes that have a class 'chk' attached to it and check if it was checked */
$(".auction-categories").click(function() {
  var subCategories = [];
  $("input[name='sub_categories']:checked").each(function() {
    subCategories.push($(this).val());
  });
 var url = '<?php echo $auctin_url;?>';
 getAuctions(url,'','','',subCategories);
});




//Cities
var selected_cities = [];
/* look for all checkboxes that have a class 'chk' attached to it and check if it was checked */
$(".auction-cities").click(function() {
  var selected_cities = [];
  $("input[name='city_id']:checked").each(function() {
    selected_cities.push($(this).val());
  });
 var url = '<?php echo $auctin_url;?>';
 getAuctions(url,'','','','','',selected_cities);
});



//Selected Sellers
var auctionSellers = [];
/* look for all checkboxes that have a class 'chk' attached to it and check if it was checked */
$(".auction-sellers").click(function() {
  var auctionSellers = [];
  $("input[name='user_id']:checked").each(function() {
    auctionSellers.push($(this).val());
  });
 var url = '<?php echo $auctin_url;?>';
 getAuctions(url,'','','','','','',auctionSellers);
});




$(document).ready(function()
{
    $("#clear_date").fadeOut();
     $(document).on('click', '.pagination li a',function(event)
    {
        // $('li').removeClass('active');
        // $(this).parent('li').addClass('active');
        //
        event.preventDefault();
         $('#ajax_loader').fadeIn(<?php echo e(HOME_AJAXLOADER_FADEIN_TIME); ?>);
        var url = $(this).attr('href');

       // var page=$(this).attr('href').split('page=')[1];

       getAuctions(url);
       $('#ajax_loader').fadeOut(<?php echo e(HOME_AJAXLOADER_FADEOUT_TIME); ?>);
       // window.history.pushState("", "", url);
    });
});


 function getAuctions(url,item_type='',auctionstatus='',auction_date='',sub_categories='',featured='',selected_cities='',auction_sellers='') {

    //Item type
    if (item_type=='' || item_type==null) {
      item_type = $("input[name='item_type']:checked").val();

    }

    //Auction Status
    if (auctionstatus.length<=0) {
       auction_status=[];
       $("input[name='auction_status']:checked").each(function() {
        auction_status.push($(this).val());
      });

       auctionstatus = auction_status;

    }

    //Selected sub categories
    if (sub_categories.length<=0) {
       subCategories=[];
       $("input[name='sub_categories']:checked").each(function() {
        subCategories.push($(this).val());
      });

       sub_categories = subCategories;
    }

    //featured or normal auctions
    if (featured=='' || featured==null) {
      featured = $("input[name='featured']:checked").is(':checked');
    }


    //selected cities
    if (selected_cities.length<=0) {
       selectedCities=[];
       $("input[name='city_id']:checked").each(function() {
        selectedCities.push($(this).val());
      });

       selected_cities = selectedCities;
    }


    //selected sellers
    if (auction_sellers.length<=0) {

       auctionSellers=[];
       $("input[name='user_id']:checked").each(function() {
        auctionSellers.push($(this).val());
      });

       auction_sellers = auctionSellers;

    }

      $.ajax({
          url : url,
          data: {
            "_token": "<?php echo e(csrf_token()); ?>",
            "item_type":item_type,
            "auction_status":auctionstatus,
            "auction_date":auction_date,
            "sub_categories":sub_categories,
            "featured":featured,
            "selected_cities":selected_cities,
            "auction_sellers":auction_sellers
          }
      }).done(function (data) {
        // console.log('HLDFDS');
          $('.auctions').html(data);
      }).fail(function () {
          $('.auctions').html('<h4>No Auctions Available </h4> ');
      });


}




//favourite auctions
function auctionAddtoFavourites(auction_id)
{

      if (!auction_id) {
        return false;
      } else {

        $.ajax({
            url : '<?php echo e(URL_ADD_FAVAUCTION); ?>',
            method: 'POST',
            data: {
              "_token": "<?php echo e(csrf_token()); ?>",
              "auction_id":auction_id,
            }
        }).done(function (data) {

          data = jQuery.parseJSON(data);

          if (data.status==1)
            alertify.success(data.message);
          else
            alertify.error(data.message);

           // alertify.success($scope.response.message);
        }).fail(function () {
            alertify.error('Invalid Operation');
        });
      }
}

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>