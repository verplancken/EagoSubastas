
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Live Auction :: {{$auction->title}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{IMAGE_PATH_SETTINGS.getSetting('site_favicon', 'site_settings')}}" type="image/x-icon" />


 <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{LIVE_AUCTION}}bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
 -->


  <link rel="stylesheet" href="{{LIVE_AUCTION}}bootstrap.min.css">

  <script src="{{LIVE_AUCTION}}jquery.min.js"></script>
  <script src="{{LIVE_AUCTION}}bootstrap.min.js"></script>
  <script src="{{LIVE_AUCTION}}socket.io.js"></script>


<!--alertify-->
<link rel="stylesheet" href="{{ALERTIFY}}css/themes/bootstrap.css">
<link rel="stylesheet" href="{{ALERTIFY}}css/alertify.min.css">
<link rel="stylesheet" href="{{ALERTIFY}}css/themes/default.css">
<link rel="stylesheet" href="{{ALERTIFY}}css/themes/alertify.core.css">


<!-- include alertify script -->
<script src="{{ALERTIFY}}/alertify.min.js"></script>


<link rel="stylesheet" type="text/css" href="{{CSS_HOME}}style.css">
</head>
<body class="bidding-page">


<div class="container">
<?php 

$currency_code = getSetting('currency_code','site_settings');

$date_format = getSetting('date_format','site_settings');

$live_auction_date = date($date_format, strtotime($auction->live_auction_date));


/*	$enter_amount = 'Enter amount ';
if (isset($last_bid) && !empty($last_bid->bid_amount))
  $enter_amount .= '> '.$last_bid->bid_amount;
elseif ($auction->minimum_bid>0)
  $enter_amount .= '> '.$auction->minimum_bid;*/


 //placeholder
$enter_amount = 'Ingrese cantidad ';
if ($auction->is_bid_increment && $auction->bid_increment>0) {
  //if increment = add incremental cost +current one=show to user
  
  if (isset($bidding) && !empty($bidding->bid_amount)) {
     $amnt = $bidding->bid_amount+$auction->bid_increment;
     $enter_amount .= ' = '.$amnt;
  }
  elseif ($auction->minimum_bid>0)
    $enter_amount .= ' > '.$auction->minimum_bid;

} else {
  //if not incremental
  if (isset($bidding) && !empty($bidding->bid_amount))
    $enter_amount .= '> '.number_format($bidding->bid_amount);
  elseif ($auction->minimum_bid>0)
    $enter_amount .= '> '.number_format($auction->minimum_bid);
}


$user = Auth::user();
use App\AuctionBidder;
use App\Auction;
use App\SubCatogory;

?>
@foreach ($invitacion as $item)
    @if ($user->email == $item->email)
    @if ($auction->sub_category_id == $item->auction_id)
<div class="row">

	<div class="col-md-12">

	<div class="col-md-6 bid-data">

		<div class="form-group bid-form-group">
			<p>{{$auction->sub_category_id}}</p>
			<p>Precio Reserva ${!! number_format($auction->reserve_price) !!} MXN</p>
			<p>Termina {{$live_auction_date}} {{$auction->live_auction_end_time}}</p>
			<p id="demo"></p> 
		</div>
	@if ($bid_options)
{!! Form::open(array('url' => URL_SAVE_LIVE_AUCTION_BID, 'method' => 'POST','name'=>'formBid', 'files'=>'true', 'novalidate'=>'')) !!}
                                         <div class="form-group bid-form-group">
											  {{Form::select('bid_amount', $bid_options, null, ['placeholder'=>'select',

                                                            'class'=>'form-control',

                                                            'ng-model'=>'bid_amount',

                                                            'required'=> 'true',

                                                            'ng-class'=>'{"has-error": formBid.bid_amount.$touched && formBid.bid_amount.$invalid}'

                                              ])}}

											@if ($bid_options)
											  <small>+{{$auction->bid_increment}}</small>
											@endif
										</div>

										<div class="form-group" align="right">
											<button type="submit" id="bid_amount" class="btn btn-success bid-submit-btn" style="padding:3px 16px;">pujar</button>
										</div>

 {!! Form::close() !!}

            @else

						<div class="form-group bid-form-group">
							<input type="number" class="form-control form-control-sm" id="bid_amount" placeholder="{{$enter_amount}}">
						</div>

							<div class="form-group" align="right">
								<button type="submit" id="au_submit" class="btn btn-success bid-submit-btn" style="padding:3px 16px;">pujar</button>
						</div>
	@endif
	  	<div class="bid-loader" style="display:none;" id="bid_loader"><img src="{{AJAXLOADER}}"> {{trans('please_wait')}}...</div>

	</div>


	

		 
		<div class="col-md-6">
			<div id="latest_bids">
			@if (count($live_biddings))
			
			

				@if ($auction->visibilidad==1)
					<ul class="list-group">
					 @foreach ($live_biddings as $bid)
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							{{$bid->name}}
							<span class="badge badge-primary badge-pill">{{$currency_code}}{{$bid->bid_amount}}</span>
						  </li>
					  @endforeach
					</ul>
					@else
					<li class="list-group-item d-flex justify-content-between align-items-center">
						<p>Tipo de subasta cerrada, no podras ver a los apostadores</p>
						<p>Usuario</p>
					</li>
				@endif

          	
          
            @endif  
            </div>
             </div>
		





</div>

</div>

</div>
  @endif
 @endif
@endforeach




<script>

$(document).ready(function() {


alertify.set('notifier','position', 'top-right');

//get placeholder = how much amount should be enter - starting || if participate during

/* $.ajax({
    "url" : "{{URL_LIVE_AUCTION_INFO}}",
    "type" : "POST",
    "data" : {
        "auction_id" : "{{$auction->id}}",
        "_token" : "{{csrf_token()}}"
    },
    "dataType":"json",
    'success' : function(response) {  

        console.log('Data: '+JSON.stringify(response));
    },
    'error' : function(request,error)
    {
        console.log("Request: "+JSON.stringify(request));
    }
});
*/









	var socket = io.connect('http://localhost:3000');

	socket.on('au_bid', function(content) {
		//conten = placeholder, latest 5 bids
	  	// console.log('On socket live kdjfd');
	   	// $('#latest_bids').append(content + "");
	   	
	   	// console.log("HELLOdsfsdfds");
	   	//bid successfully placed
		/*$("#latest_bids").html('');
		$("#latest_bids").append(content["latest_bids"]);
		*/
		//placeholder
		/*$('input').val('');
		$('input').attr('placeholder',content["placeholder"]);*/

	});


	socket.on('place', function(content) {
		$('input').val('');
		$('input').attr('placeholder',content["placeholder"]);
	});


	socket.on('lts_bids', function(content) {
		$("#latest_bids").html('');
		$("#latest_bids").append(content["latest_bids"]);
	});



	$('#au_submit').click(function(){


	  	// console.log('hey submit');

	  	var current_bid = $('#bid_amount').val();
	  	var auction_id = '{{$auction->id}}';
		var sub = '{{$auction->sub_category_id}}';

	  	var ajax_status=false;
	  		
	  	var ltst_bids='';
	  	var plchlder='';	
	  		
	  	if (auction_id>0 && current_bid>0) {

	  		//loader 
	  		$('#bid_loader').fadeIn({{AJAXLOADER_FADEIN_TIME}});
	  			

		  	$.ajax({
			    "url" : "{{URL_SAVE_LIVE_AUCTION_BID}}",
			    "type" : "POST",
			    "data" : {
			        "bid_auction_id" : '{{$auction->id}}',
					"bid_sub" : '{{$auction->sub_category_id}}',
			        "bid_amount" : current_bid,
			        "_token" : "{{csrf_token()}}"
			    },
			    "dataType":"json",
			    'success' : function(response) {  


			    	$('#bid_loader').fadeOut({{AJAXLOADER_FADEOUT_TIME}});

			        // console.log('Data: '+JSON.stringify(response));
			        // dta = JSON.stringify(response);
			        // console.log("STATUS OF BID "+response.status);


			        var bid_status = response.status;
			        var msg = response.msg;

			        if (bid_status==999) {
			        	// alert("Please Login to continue..or User is not authorized");
			        	alertify.error("Inicie sesión para continuar ... o el usuario no está autorizado");
	  					return;
		        	} else if (bid_status==99) {
		        		// alert("Bid amount is not valid");
		        		alertify.error("El monto de la oferta no es válido");
	  					return;
		        	} else if (bid_status==555) {
		        		// won auction, time is over, reached/> reserve price
		        		// alertify.log(msg);
		        		alertify.warning(msg);
	  					return;
	  				} else if (bid_status==9999) {
		        		// alert("Bidding time is not valid..can not pujar now");
		        		alertify.error("El tiempo de oferta no es válido ... no se puede realizar una oferta ahora");
	  					return;
		        	} else if (bid_status==0) {
		        		// alert("Auction record not found");
		        		alertify.error("No se encontró el registro de subasta");
	  					return;
		        	} else if (bid_status==11) {
		        		// alert("Bidding time is not valid..can not place bid now");
		        		alertify.error("El tiempo de oferta no es válido ... no se puede realizar una oferta ahora");
	  					return;
					} else if (bid_status==112) {
		        		// alert("Bidding time is not valid..can not place bid now");
		        		alertify.error("Lo sentimos, no tiene mas tiros");
	  					return;
		        	} else if (bid_status==1111) {
		        		// alert("Someone has already won/bought auction..can not place bid now");
		        		alertify.error("Alguien ya ganó / compró la subasta ... no puede hacer una oferta ahora");
	  					return;
		        	} else if (bid_status==111) {

		        		ajax_status = true;

		        		ltst_bids 	= response.latest_bids;
		        		plchlder 	= response.placeholder;

		        		//bid successfully placed
		        		$("#latest_bids").html('');
		        		$("#latest_bids").append(response.latest_bids);

		        		//placeholder
		        		$('input').val('');
		        		$('input').attr('placeholder',response.placeholder);

		        		socket.emit('au_bid', { 
						    	"amount" : current_bid,
						    	"auction_id" : '{{$auction->id}}',
								"sub" : '{{$auction->sub_category_id}}',
						    	"latest_bids": ltst_bids,
						    	"placeholder": plchlder
						    	
						});


		        	}
					location.reload();
				},
				'error' : function(request,error)
				{
				    // console.log("Request: "+JSON.stringify(request));
				}
				
			});


		  	/*if (ajax_status) {
			    socket.emit('au_bid', { 
			    	"amount" : current_bid,
			    	"auction_id" : '{{$auction->id}}'

			    	// "latest_bids": ltst_bids,
			    	// "placeholder": plchlder
			    	
			    });
			    console.log('after emit');
			}*/

		} else {

			alertify.error("Ingrese una oferta válida");
			return;

			/*alert("Please enter valid bid");
	  		return;*/
		}


	});

});
</script>


<script>
 
// Set the date we're counting down to
var countDownDate = new Date('<?php echo $end_time;?>');//new Date("Jun 26, 2018 15:37:25").getTime();



// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
   /* document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";*/

    document.getElementById("demo").innerHTML = hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EL TIEMPO DE OFERTA HA TERMINADO";
    }
}, 1000);
</script>


</body>
</html>
 


