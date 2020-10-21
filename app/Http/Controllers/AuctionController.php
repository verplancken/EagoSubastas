<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Support\Jsonable;

use App\Category;
use App\SubCatogory;
use App\Auction;
use App\User;
use Session;

use App\Invitaciones;
use App\City;
use App\Favouriteauction;

use Carbon\Carbon;
use App\Bidding;
use App\AuctionBidder;
use App\Payment;
use App\AuctionImages;
use Auth;



class AuctionController extends Controller
{
    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function index(Request $request)
    {

        if (checkRole(getUserGrade(4))) {
            return redirect(URL_DASHBOARD);
        }
        $sub_categories=[];
        $selected_category=[];

        if (isset($request->category)) {

            $category_record = Category::getRecordWithSlug($request->category);

            if (count($category_record)) {

                $selected_category[] = $category_record->id;

                $sub_categories=[];

                if (isset($request->subcategory)) {

                    $subcategory_record = SubCatogory::getRecordWithSlug($request->subcategory);
                  
                    if (count($subcategory_record)) {

                        $sub_categories = SubCatogory::where('category_id',$category_record->id)
                                                        ->where('id',$subcategory_record->id)
                                                        ->where('status','=','Active')
                                                        ->pluck('id')
                                                        ->toArray();
                    }

                } else {

                    $sub_categories = SubCatogory::where('category_id',$category_record->id)
                                                ->where('status','=','Active')
                                                ->pluck('id')
                                                ->toArray();
                }
            }
          
        } else {
            //Sub Categories
            $sub_categories = $request->sub_categories;
        }
         

        $data['selected_category'] = $selected_category;                                
        $data['selected_sub_categories'] = $sub_categories;


    	$categories = Category::getAuctionPageCategories();
    	$data['categories']     = $categories;


        $cond = [
                    ['auctions.admin_status','=','approved'],
                    ['users.role_id','=',getRoleData('seller')],
                    ['users.approved','=',1],
                    ['categories.status','=','Active'],
                    ['sub_catogories.status','=','Active']
                ];



        //Item type = all_items=All Items,auction_items=Auctions,buynow_items=Buy Now
        $item_type = $request->item_type;

         //Auction Status = open=Live,new=Upcoming,closed=Past
        $auction_status=[];
        $auction_status = $request->auction_status;

        //Auction Date
        $auction_date = $request->auction_date;
        if ($auction_date!='') {
            $auction_date = date('Y-m-d',strtotime($auction_date));
        }
        
        

        //Is Featured
        $featured = $request->featured;

        //Selected Cities
        $selected_cities = $request->selected_cities;


        //Selected Sellers
        $sellers = $request->auction_sellers;

             if ($item_type != '' && count($auction_status) > 0) {


                 if ($item_type === 'auction_items') {
                     $cond[] = ['is_buynow', '!=', 1];

                 } elseif ($item_type === 'buynow_items') {
                     $cond[] = ['is_buynow', '=', 1];
                 }


                 /* $auctionstatus=[];
                  foreach ($auction_status as $status) {
                       array_push($auctionstatus, "$status");
                  }*/


                 if ($auction_date != '') {

                     $cond[] = ['auctions.start_date', '<=', $auction_date];
                     $cond[] = ['auctions.end_date', '>=', $auction_date];

                 } else {

                     if ((in_array('open', $auction_status) || in_array('new', $auction_status)) && !in_array('closed', $auction_status)) {
                         $cond[] = ['auctions.start_date', '<=', NOW()];
                         $cond[] = ['auctions.end_date', '>=', NOW()];

                         /* $cond[] = ['auctions.start_date','<=',DATE("Y-m-d")];
                          $cond[] = ['auctions.end_date','>=',DATE('Y-m-d')];*/
                     }
                 }

                 if ($featured == 'true') {
                     $cond[] = ['auctions.make_featured', '=', 1];
                 }


                 if (count($sub_categories)) {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);


                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }

                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }
                     }

                 } else {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }


                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);


                         }

                     }
                 }

             } elseif ($item_type != '' && count($auction_status) <= 0) {

                 if ($auction_date != '') {

                     $cond[] = ['auctions.start_date', '<=', $auction_date];
                     $cond[] = ['auctions.end_date', '>=', $auction_date];

                 } else {

                     $cond[] = ['auctions.start_date', '<=', NOW()];
                     $cond[] = ['auctions.end_date', '>=', NOW()];

                     /* $cond[] = ['auctions.start_date','<=',DATE('Y-m-d')];
                      $cond[] = ['auctions.end_date','>=',DATE('Y-m-d')];*/
                 }


                 if ($item_type === 'auction_items') {
                     $cond[] = ['is_buynow', '!=', 1];

                 } elseif ($item_type === 'buynow_items') {
                     $cond[] = ['is_buynow', '=', 1];
                 }

                 // $cond[] = ['auctions.auction_status','=','open'];


                 if ($featured == 'true') {
                     $cond[] = ['auctions.make_featured', '=', 1];
                 }

                 if (count($sub_categories)) {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.sub_category_id', $sub_catogories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.sub_category_id', $sub_catogories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }

                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.sub_category_id', $sub_catogories)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('auctions.sub_category_id', $sub_catogories)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         }

                     }

                 } else {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }


                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date'])
                                 ->where($cond)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }
                     }
                 }

             } elseif ($item_type == '' && count($auction_status) > 0) {

                 // dd($auction_status);
                 //live = auction_staus=open
                 //upcoming = auction_status=new
                 //past = auction_status=closed

                 //open
                 //new
                 //past
                 //open,new
                 //open,closed
                 //new,closed
                 //open,new,closed


                 if ($auction_date != '') {

                     $cond[] = ['auctions.start_date', '<=', $auction_date];
                     $cond[] = ['auctions.end_date', '>=', $auction_date];

                 } else {

                     if ((in_array('open', $auction_status) || in_array('new', $auction_status)) && !in_array('closed', $auction_status)) {

                         $cond[] = ['auctions.start_date', '<=', NOW()];
                         $cond[] = ['auctions.end_date', '>=', NOW()];

                         /*$cond[] = ['auctions.start_date','<=',DATE("Y-m-d")];
                         $cond[] = ['auctions.end_date','>=',DATE('Y-m-d')];*/

                     }
                 }


                 /* $auctionstatus=[];

                  foreach ($auction_status as $status) {
                      array_push($auctionstatus, "'$status'");
                  }*/

                 if ($featured == 'true') {
                     $cond[] = ['auctions.make_featured', '=', 1];
                 }


                 if (count($sub_categories)) {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);


                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         }

                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('auctions.sub_category_id', $sub_categories)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }

                     }

                 } else {

                     if (count($selected_cities)) {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.city_id', $selected_cities)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }


                     } else {

                         if (count($sellers)) {

                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->whereIn('users.id', $sellers)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                         } else {
                             $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                                 ->join('categories', 'auctions.category_id', 'categories.id')
                                 ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                                 ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                                     'auctions.description', 'auctions.image',
                                     'auctions.reserve_price', 'auctions.auction_status',
                                     'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                                 ->where($cond)
                                 ->whereIn('auctions.auction_status', $auction_status)
                                 ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                         }
                     }
                 }

             } else {


                 if (isset($request->category)) {

                     //Initial loading..
                     $cond[] = ['auctions.auction_status', '=', 'open'];


                     $cond[] = ['auctions.start_date', '<=', NOW()];
                     $cond[] = ['auctions.end_date', '>=', NOW()];

                     /*$cond[] = ['auctions.start_date','<=',DATE("Y-m-d")];
                     $cond[] = ['auctions.end_date','>=',DATE('Y-m-d')];*/


                     $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                         ->join('categories', 'auctions.category_id', 'categories.id')
                         ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                         ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                             'auctions.description', 'auctions.image',
                             'auctions.reserve_price', 'auctions.auction_status',
                             'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                         ->where($cond)
                         ->whereIn('auctions.sub_category_id', $sub_categories)
                         ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);
                     // dd($request->category_id);

                 } else {

                     //Carga inicial ..
                     $cond[] = ['auctions.auction_status', '=', 'open'];

                     $cond[] = ['auctions.start_date', '<=', NOW()];
                     $cond[] = ['auctions.end_date', '>=', NOW()];

                     /*$cond[] = ['auctions.start_date','<=',DATE("Y-m-d")];
                     $cond[] = ['auctions.end_date','>=',DATE('Y-m-d')];*/

                     $auctions = Auction::join('users', 'auctions.user_id', 'users.id')
                         ->join('categories', 'auctions.category_id', 'categories.id')
                         ->join('sub_catogories', 'auctions.sub_category_id', 'sub_catogories.id')
                         ->select(['auctions.id', 'auctions.title', 'auctions.slug',
                             'auctions.description', 'auctions.image',
                             'auctions.reserve_price', 'auctions.auction_status',
                             'auctions.start_date', 'auctions.end_date', 'auctions.sub_category_id'])
                         ->where($cond)
                         ->orderBy('auctions.id', 'desc')->paginate(PAGINATE_RECORDS);

                 }

             }



        $auctions->withPath(URL_HOME_AUCTIONS);
        
        
        $data['auctions'] = $auctions;
       // dd($auctions);
       $invitacion = DB::table('invitaciones')
        ->get();

        //dd($invitacion);
        $user = DB::table('users')
        ->first();



        //CUANDO EXISTEN DATOS EN auctionbidders
        $auctionbidders = AuctionBidder::select('auction_id', 'no_of_times', 'bidder_id')
                                        ->get();
                                 //dd($auctionbidders);
         $users   = \Auth::user();

        $auctionbidders = AuctionBidder::where('bidder_id', '=', $users->id)
                                    ->where('auction_id', '=', $auction->id)
                                     ->select('auction_id', 'no_of_times', 'bidder_id')
                                        ->get();


        $subcategoria = DB::table('sub_catogories')
                            ->first();


                   //dd($user);

        $lote = DB::table('sub_catogories')
                            ->get();

       //dd($lote);
       $cond2[] = ['auctionbidders.is_bidder_won','=','Yes'];
       $auctionbidders2 = DB::table('auctionbidders')
                     ->select(DB::raw('count(*) as bidder_count'))
                     ->where('bidder_id', '=', $users->id)
                     ->where('sub', '=', $auction->sub_category_id)
                     ->where($cond2)
                     ->get();


        $data['active_class']   = 'auctions';
        $data['layout']         = getLayout();
        $data['title']          = getPhrase('auctions');
        $data['breadcrumb']     = TRUE;
                         
        if ($request->ajax()) {

            return view('home.pages.auctions.ajax_auctions',['auctions' => $auctions])->render();
        }
        // Auction::paginate(3);
        return view('home.pages.auctions.auctions', $data, compact('invitacion', 'subcategoria', 'auctionbidders2', 'auctionbidders', 'auction'));
    }

    /**
     * [viewAuction description]
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function viewAuction($slug)
    {
        if (checkRole(getUserGrade(4))) {
            return redirect(URL_DASHBOARD);
        }

        $auction = Auction::getRecordWithSlug($slug);
        //dd($auction);

        if ($isValid = $this->isValidRecord($auction))
            return redirect($isValid);


        $data['auction'] = $auction;


        //bid payment - paid or not
        $bid_payment_record = $auction->getAuctionPayment();


        //buy now payment - paid or not
        $buy_now_payment_record = $auction->getBuyNowAuctionPayment();

        $bid_div = true;
        if (count($bid_payment_record) || count($buy_now_payment_record)) {
            $bid_div = false;
        }

        $data['bid_div'] = $bid_div;


        //oferta mínima, es incremento de oferta, incremento de oferta
        $bid_options = [];
        $today = date('d-m-Y');

        //si la última oferta está allí, entonces esa es la cantidad inicial en opciones
        $last_bid = Bidding::getLastBidRecord($auction->id);
        $data['last_bid'] = $last_bid;

        $last_bidcerrada = Bidding::getLastBidRecordCerrada($auction->id);
        $data['$last_bidcerrada'] = $last_bidcerrada;


        //live auction button show condition
        $live_auction = false;
        $live_auction_starts = false;

        if ($auction->live_auction_date && $bid_div) {

            if ($auction->admin_status == 'approved' && $auction->auction_status == 'open' && $auction->live_auction_date == $today) {

                $live_auction_start_time = strtotime($auction->live_auction_start_time);
                $live_auction_end_time = strtotime($auction->live_auction_end_time);

                if ($live_auction_start_time <= time() && $live_auction_end_time >= time()) {
                    $live_auction = true; //live auction happening currently

                } else if ($live_auction_start_time > time() && $live_auction_end_time > time()) {
                    $live_auction_starts = true;//live auction gonna start
                }
            }
        }

        $data['live_auction'] = $live_auction;
        $data['live_auction_starts'] = $live_auction_starts;

        //si alguien ya pagó el monto de la subasta o
        //si alguien ya compró
        //entonces la subasta normal y la subasta en vivo no se realizarán.


        if ($auction->visibilidad == 1){
            if ($auction->admin_status == 'approved' && $auction->auction_status == 'open' && $auction->start_date <= now() && $auction->end_date >= now()) {
                if ($auction->is_bid_increment && $auction->bid_increment > 0) {

                    $start = $auction->minimum_bid;

                    if (isset($last_bid) && $last_bid->bid_amount) {

                        if ($last_bid->bid_amount >= $start) {
                            $start = $last_bid->bid_amount + $auction->bid_increment;
                        }
                        // $start = $last_bid->bid_amount;
                    }


                    $increment = $auction->bid_increment;
                    $reserve_price = $auction->reserve_price;


                    if ($auction->minimum_bid > 0) {

                        // opciones: empezar desde la oferta mínima
                        // $bid_options[] = $start;
                        // dd($increment);
                        for ($i = $start; $i <= ($reserve_price + $start + $increment); $i = $i + $increment) {
                            $bid_options[$i] = $i;
                        }


                    } else {

                        //opciones - empezar desde la cantidad bid_increment
                        for ($i = $increment; $i <= ($reserve_price + $increment); $i = $i + $increment) {
                            $bid_options[$i] = $i;
                        }

                    }


                } else {

                    if ($auction->minimum_bid > 0) {
                        //texto: comience desde la oferta mínima
                    } else {
                        //text - start from 1
                    }

                }
            }
        $data['bid_options'] = $bid_options;

    }else{
            //*******************Subasta Cerrada*************
          if ($auction->admin_status=='approved' && $auction->auction_status=='open' && $auction->start_date<=now() && $auction->end_date>=now()) {
            if ($auction->is_bid_increment && $auction->bid_increment>0) {

                $start = $auction->minimum_bid;

                if (isset($last_bidcerrada) && $last_bidcerrada->bid_amount) {

                    if ($last_bidcerrada->bid_amount >= $start) {
                        $start = $last_bidcerrada->bid_amount+$auction->bid_increment;
                    }
                    // $start = $last_bid->bid_amount;
                }

                $increment = $auction->bid_increment;
                $reserve_price = $auction->reserve_price;

                if ($auction->minimum_bid>0) {

                    // opciones: empezar desde la oferta mínima
                    // $bid_options[] = $start;
                   // dd($increment);
                    for ($i=$start;$i<=($reserve_price+$start+$increment);$i=$i+$increment) {
                            $bid_options2[$i] = $i;
                    }


                } else {

                    //opciones - empezar desde la cantidad bid_increment
                    for ($i=$increment;$i<=($reserve_price+$increment);$i=$i+$increment) {
                        $bid_options2[$i] = $i;
                    }

                }


            } else {

                if ($auction->minimum_bid>0) {
                    //texto: comience desde la oferta mínima
                } else {
                    //text - start from 1
                }

            }
          }
        $data['bid_options2'] = $bid_options2;
}
        $data['seller'] = User::where('id',$auction->user_id)
                                ->where('role_id',getRoleData('seller'))
                                ->first();

        //historial de pujas
        //all bidders - name,last recent bid
        // $data['bidding_history'] = $auction->getAuctionBiddingHistory();

        //auctionbidders
        $auctionbidders = AuctionBidder::where('auction_id',$auction->id)
                                        ->select('auctionbidders.id')
                                        ->orderBy('auctionbidders.id','desc')
                                        ->get();

        if (count($auctionbidders)) {
          foreach ($auctionbidders as $ab) {

            $user_last_bid = Bidding::join('auctionbidders', 'bidding.ab_id', 'auctionbidders.id')
                                      ->join('users','auctionbidders.bidder_id','users.id')
                                      ->where('bidding.ab_id',$ab->id)
                                      ->select('users.name','bidding.bid_amount')
                                      ->orderBy('bidding.id','desc')
                                      ->limit(1)
                                      ->get();
            if (count($user_last_bid)) {
              $user_last_bid  = $user_last_bid[0];
              $ab->username   = $user_last_bid->name;
              $ab->bid_amount = $user_last_bid->bid_amount;

            }                          
          }
        }

        $data['bidding_history'] = $auctionbidders;

       
        //buynow condition
        $data['is_already_sold'] = 'No';
        if ($auction->is_buynow==1 && $auction->buy_now_price) {

          $buynow_payments = Payment::where('auction_id',$auction->id)
                                ->where('payment_for',PAYMENT_FOR_BUY_AUCTION)
                                ->where('payment_status',PAYMENT_STATUS_SUCCESS)
                                ->get();
          if (count($buynow_payments))                
          $data['is_already_sold'] = 'Yes';                      
        }


        //auction images
        $max_number_of_pictures = getSetting('max_number_of_pictures','auction_settings');
        $auction_images  = AuctionImages::where('auction_id',$auction->id)
                                          ->orderBy('id','desc')
                                          ->limit($max_number_of_pictures)
                                          ->get();

        $data['auction_images'] = $auction_images;


        
        $data['active_class']   = 'auctions';
        $data['layout']         = getLayout();
        $data['title']          = getPhrase('auction_details');
        $data['breadcrumb']     = TRUE;

        $invitacion = DB::table('invitaciones')
        ->get();
        //dd($invitacion);
        $user = DB::table('users')
        ->first();



        //CUANDO EXISTEN DATOS EN auctionbidders
        $auctionbidders = AuctionBidder::select('auction_id', 'no_of_times', 'bidder_id')
                                        ->get();
                                 //dd($auctionbidders);
         $users   = \Auth::user();

        $auctionbidders = AuctionBidder::where('bidder_id', '=', $users->id)
                                        ->where('auction_id', $auction->id)
                                         ->select('auction_id', 'no_of_times', 'bidder_id')
                                        ->get();
      //dd($auctionbidders);


        $subcategoria = DB::table('sub_catogories')
                            ->first();


                   //dd($user);

        $lote = DB::table('sub_catogories')
                            ->where('id',$auction->sub_category_id)
                            ->get();                  
  
       //dd($lote);
       $cond2[] = ['auctionbidders.is_bidder_won','=','Yes'];
       $auctionbidders2 = DB::table('auctionbidders')
                     ->select(DB::raw('count(*) as bidder_count'))
                     ->where('bidder_id', '=', $users->id)
                     ->where('sub', '=', $auction->sub_category_id)
                     ->where($cond2)
                     ->get();
      // dd($auctionbidders2);

                    $now = strtotime(date('Y-m-d H:i:s'));
                    $start_date = strtotime($auction->start_date);
                    $end_date   = strtotime($auction->end_date);

                       //comprobar la última puja reciente de la subasta
                        $auction_last_bid = Bidding::getAuctionLastBid($auction->id);

                                $record = AuctionBidder::where('id', $auction_last_bid->ab_id)
                                    ->first();
                                 //dd($record);

                        if ($end_date<=$now) {
                            $auction->auction_status = 'closed';
                            $auction->save();
                        }

                        if ($end_date<=$now) {
                            $record->is_bidder_won = 'Yes';
                            //dd($record);
                            $record->save();


                            //reached /> precio de reserva, muestra el ganador del tiempo de subasta ha terminado
                            $currency_code = getSetting('currency_code', 'site_settings');
                            $msg = $auction_last_bid->name . ' has ganado la subasta con la oferta más alta '. '$' . $auction_last_bid->bid_amount . 'mxn';

                            if ($users->id == $record->bidder_id) {
                                Session::flash('succes', $msg);
                            } else {
                                Session::flash('warning', 'Lo sentimos, no ganaste');
                            }
                        }

        return view('home.pages.auctions.auction-details', $data, compact('invitacion', 'auctionbidders', 'auctionbidders2', 'lote'));
    }


    public function liveAuction($slug)
    {
      $timezone = env('SYSTEM_TIMEZONE');
      if (!$timezone)
        $timezone = 'America/Mexico_City';

        date_default_timezone_set($timezone);

      // $current_time = date('M d Y H:i:s', strtotime(date('Y-m-d H:i:s')));
      // $end_time = date('M d Y H:i:s', strtotime('2018-06-26 18:05:10'));

       

        //check auction date, time
        //if not matches - display message
        //if any one won - same...
        
        if (checkRole(getUserGrade(4))) {
            return redirect(URL_DASHBOARD);
        }

        $auction = Auction::getRecordWithSlug($slug);

        if ($isValid = $this->isValidRecord($auction))
            return redirect($isValid);


        $data['auction'] = $auction;


        //pago de oferta - pagado o no
        $bid_payment_record = $auction->getAuctionPayment();
        

        //comprar ahora pago - pagado o no
        $buy_now_payment_record = $auction->getBuyNowAuctionPayment();
        
        $bid_div=true;
        if (count($bid_payment_record) || count($buy_now_payment_record)) {

          $bid_div = false;
          //si ya alguien compró o alguien pagó el monto de la subasta, no permita la subasta en vivo
          flash('info','Alguien ya ha ganado/compró esta subasta..','info');
          return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);

        }

        $data['bid_div'] = $bid_div;

        
        //oferta mínima, es incremento de oferta, incremento de oferta
        $bid_options=[];
        $today=date('Y-m-d');

        //si la última oferta está allí, entonces esa es la cantidad inicial en opciones
        $last_bid = Bidding::getLastBidRecord($auction->id);
        $data['last_bid'] = $last_bid;




        if ($auction->auction_status=='open' && $auction->start_date<=now() && $auction->end_date>=now()) {
            if ($auction->is_bid_increment && $auction->bid_increment>0) {
                    
                $start = $auction->minimum_bid;

                if (isset($last_bid) && $last_bid->bid_amount) {

                    if ($last_bid->bid_amount >= $start) {
                        $start = $last_bid->bid_amount+$auction->bid_increment;
                    }
                    // $start = $last_bid->bid_amount;
                }

                $increment = $auction->bid_increment;
                $reserve_price = $auction->reserve_price;

                if ($auction->minimum_bid>0) {

                    //options - start from minimum bid
                    // $bid_options[] = $start;
                    
                    for ($i=$start;$i<=($reserve_price+$increment);$i=$i+$increment) {
                        $bid_options[$i] = $i;
                    }
                   
                } else {

                    //opciones - empezar desde la cantidad bid_increment
                    for ($i=$increment;$i<=($reserve_price+$increment);$i=$i+$increment) {
                        $bid_options[$i] = $i;
                    }
                    
                }
                

            } else {

                if ($auction->minimum_bid>0) {
                    //texto: comience desde la oferta mínima
                } else {
                    //texto - empezar desde 1
                }

            }
        }
        $data['bid_options'] = $bid_options;

        $data['seller'] = User::where('id',$auction->user_id)
                                ->where('role_id',getRoleData('seller'))
                                ->first();

        //bidding history
        //get last 5 recent bids
        $data['live_biddings'] = $auction->getAuctionBiddingHistory(5);

        // $subca = SubCatogory::all()
        //                 ->first();
      //  dd($sub);

        //bidding - last record
        $bidding = Bidding::join('auctionbidders', 'bidding.ab_id', 'auctionbidders.id')
                          ->select('bidding.bid_amount')
                          ->where('auctionbidders.auction_id', $auction->id)
                          ->where('auctionbidders.sub', $auction->sub_category_id)
                          ->orderBy('bidding.id','desc')
                          ->limit(1)
                          ->get();
                          //dd($bidding);

        if (count($bidding)) {
          $bidding = $bidding[0];
          $data['bidding'] = $bidding;
        }                 




        //buynow condition
        $data['is_already_sold'] = 'No';
        if ($auction->is_buynow==1 && $auction->buy_now_price) {

          $buynow_payments = Payment::where('auction_id',$auction->id)
                                ->where('payment_for',PAYMENT_FOR_BUY_AUCTION)
                                ->where('payment_status',PAYMENT_STATUS_SUCCESS)
                                ->get();
          if (count($buynow_payments))                
          $data['is_already_sold'] = 'Yes';                      
        }


        //auction images
        $max_number_of_pictures = getSetting('max_number_of_pictures','auction_settings');
        $auction_images  = AuctionImages::where('auction_id',$auction->id)
                                          ->orderBy('id','desc')
                                          ->limit($max_number_of_pictures)
                                          ->get();

        $data['auction_images'] = $auction_images;





         //botón de subasta en vivo mostrar condición
        $live_auction=false;
        if ($auction->live_auction_date && $bid_div) {

            if ($auction->admin_status=='approved' && $auction->auction_status=='open' && $auction->live_auction_date==$today) {

              $live_auction_start_time = strtotime($auction->live_auction_start_time);
              $live_auction_end_time   = strtotime($auction->live_auction_end_time);

                if ($live_auction_start_time <= time() && $live_auction_end_time >= time()) {
                  $live_auction=true;
                }
              }
        }
        if (!$live_auction) {
          flash('info','El tiempo de oferta no es válido... no se puede realizar una oferta ahora', 'info');
          return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
        }


        //timer end time
        $end_time = date('M d Y H:i:s', strtotime($auction->live_auction_date.' '.$auction->live_auction_end_time));
        $data['end_time']       = $end_time;

        
        $data['active_class']   = 'auctions';
        $data['layout']         = getLayout();
        $data['title']          = getPhrase('live_auction').'::'.$auction->title;
        $data['breadcrumb']     = TRUE;

        $invitacion = DB::table('invitaciones')
        ->get();
        //dd($invitacion);

        //CUANDO EXISTEN DATOS EN auctionbidders
        $auctionbidders = AuctionBidder::where('auction_id',$auction->id)
                                        ->select('auction_id', 'no_of_times', 'bidder_id')
                                        ->get();
                                        
        $user = DB::table('users')
        ->first();

        $subcategoria = DB::table('sub_catogories')
                            ->first();

        // dd($subcat);


        $user   = \Auth::user();
                   //dd($user);

        $lote = DB::table('sub_catogories')
                            ->get();                  
 // dd($lote);
       //dd($lote);
       $cond2[] = ['auctionbidders.is_bidder_won','=','Yes'];
       $auctionbidders2 = DB::table('auctionbidders')
                     ->select(DB::raw('count(*) as bidder_count'))
                     ->where('bidder_id', '=', $user->id)
                     ->where('sub', '=', $auction->sub_category_id)
                     ->where($cond2)
                     ->get();
     // dd($auctionbidders);

        return view('home.pages.auctions.live-auction', $data, compact('invitacion', 'auctionbidders', 'auctionbidders2', 'lote'));
    }
    
    public function auctionInfo(Request $request)
    {
        return json_encode(array('auction_id'=>$request->auction_id));
    }


     /**
     * add to favourite auctions list
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function addToFavourite(Request $request)
    {
        if (checkRole(getUserGrade(4))) {

            $response['status'] = 0;
            $response['message'] = 'El usuario no tiene derechos para agregar favoritos';

            return json_encode($response);
        }

        $user   = \Auth::user();
      
        if ($isValid = $this->isValidRecord($user))
            return redirect($isValid);

        if ($user->role_id != getRoleData('bidder'))
            return redirect(URL_USERS_LOGIN);


        if ($redirect = $this->check_isdemo()) {

            $response['status']  = 0;
            $response['message'] = 'operaciones de crud deshabilitadas en la demostración';
            return json_encode($response);
        }

        $existed = Favouriteauction::where('user_id',$user->id)
                                    ->where('auction_id',$request->auction_id)
                                    ->first();

        if ($existed) {

            $response['status'] = 0;
            $response['message'] = 'subasta ya agregada a favoritos';

        } else {
       
            $record     = new Favouriteauction();
            $record->user_id    = $user->id;
            $record->auction_id = $request->auction_id;
          
            $record->save();

            $response['status'] = 1;
            $response['message'] ='subasta agregada a favoritos';
        }

        return json_encode($response);
    }

    /**
     * [saveBid description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
   public function saveBid(Request $request)
    {
        if (checkRole(getUserGrade(4))) {
            return redirect(URL_DASHBOARD);
        }

        $currentUser = \Auth::user();

        $bid_amount  = $request->bid_amount;
        $auction_id  = $request->bid_auction_id;
        $sub  = $request->sub;

        $save=FALSE;

        if ($currentUser) {

           if ($redirect = $this->check_isdemo()) {
              flash('info','operaciones de crud deshabilitadas en la demostración', 'info');
              return redirect($redirect);
            }

            if ($bid_amount && $auction_id) {


                //comprobar si el usuario es postor
                if ($currentUser->role_id!=getRoleData('bidder')) {
                    flash('error','por favor inicie sesión como postor para continuar', 'error');
                    return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                }


                //récord de subasta
                $auction_record = Auction::where('id',$auction_id)->where('sub_category_id',$sub)->get();
                if (count($auction_record))
                  $auction_record = $auction_record[0];

                //condición de subasta en vivo
                //si se realiza una subasta en vivo, la subasta regular no debería funcion
                $live_auction=false;
                $today = date('Y-m-d');
                if ($auction_record->live_auction_date) {

                    if ($auction_record->admin_status=='approved' && $auction_record->auction_status=='open' && $auction_record->live_auction_date==$today) {

                      $live_auction_start_time= strtotime($auction_record->live_auction_start_time);
                      $live_auction_end_time  = strtotime($auction_record->live_auction_end_time);

                        if ($live_auction_start_time<=time() && $live_auction_end_time>=time()) {
                            $live_auction=true;
                        }
                      }
                }
                if ($live_auction) {
                  flash('info','La subasta en vivo está sucediendo actualmente ... no se puede realizar una subasta regula', 'info');
                  return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction_record->slug);
                }






                //comprobar el inicio de la subasta, la fecha y hora de finalización, el estado de la subasta
                $auction = Auction::getAuctionRecord($auction_id);

                if (!empty($auction)) {

                    // verifique que alguien pagó el monto de la subasta / compró la subasta
                  // pago de oferta - pagado o no
                  $bid_payment_record = $auction->getAuctionPayment();

                  //comprar ahora pago - pagado o no pago - pagado o no
                  $buy_now_payment_record = $auction->getBuyNowAuctionPayment();

                  $bid_div=true;
                  if (count($bid_payment_record) || count($buy_now_payment_record)) {

                    $bid_div = false;

                    flash('info','Alguien ya ha ganado / comprado esta subasta.','info');
                    return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                  }





                    //fecha de inicio hora, fecha de finalización hora
                    $now = strtotime(date('Y-m-d H:i:s'));
                    $start_date = strtotime($auction->start_date);
                    $end_date   = strtotime($auction->end_date);

                    if ($start_date<=$now && $end_date>=$now) {

                        //comprobar la última oferta reciente
                        $last_bid = Bidding::getLastBidRecord($auction->id);
                        $last_bidcerrada = Bidding::getLastBidRecordCerrada($auction->id);


                        if (!empty($last_bid)) {
                            if ($auction->visibilidad == 1){ //Subasta Abierta

                                if ($bid_amount > $last_bid->bid_amount) {
                                    //guardar en la mesa
                                    $save = TRUE;
                                } else {
                                    //redireccionamiento: el monto de la oferta no es válido
                                    flash('error', 'el monto de la oferta no es válido', 'error');
                                    return redirect(URL_HOME_AUCTION_DETAILS . '/' . $auction->slug);
                                }

                            } else { //Subasta Cerrada

                                if ($bid_amount > $last_bidcerrada->bid_amount) {
                                    //guardar en la mesa
                                    $save = TRUE;
                                } else {
                                    //redireccionamiento: el monto de la oferta no es válido
                                    flash('error', 'el monto de la oferta no es válido', 'error');
                                    return redirect(URL_HOME_AUCTION_DETAILS . '/' . $auction->slug);
                                }

                            }

                        } elseif ($auction->minimum_bid>0) {

                            //si no es la última oferta reciente, verifique el monto mínimo de la subasta

                            //Primera puja
                            if ($bid_amount>=$auction->minimum_bid) {
                                //guardar en la tabla
                                $save=TRUE;
                            } else {
                                //redireccionamiento: el monto de la oferta no es válido
                                flash('error','el monto de la oferta no es válido', 'error');
                                return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                            }

                        } elseif (empty($last_bid) && $auction->minimum_bid<=0) {
                            //Primera puja
                            //guardar en la tabla
                            $save=TRUE;

                        } else {

                            return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                        }


                         $auctionbidder = AuctionBidder::where('auction_id',$auction_id)
                                                            ->where('sub',$sub)
                                                            ->where('bidder_id',$currentUser->id)
                                                            ->select(['id','no_of_times'])
                                                            ->first();

                            if(count($auctionbidder)){
                                if($auctionbidder->no_of_times < $auction->tiros){

                                    $save=TRUE;
                                    //dd($save);
                                } else {
                                    Session::flash('warning', 'Lo sentimos, no tienes mas tiros');
                                    flash('error','Lo sentimos, no tienes mas tiros', 'error');
                                    return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                                }
                            }


                        if ($save) {

                            $auctionbidder = AuctionBidder::where('auction_id',$auction_id)
                                                            ->where('sub',$sub)
                                                            ->where('bidder_id',$currentUser->id)
                                                            ->select(['id','no_of_times'])
                                                            ->first();
                            if (count($auctionbidder)) {

                                // si no es la primera vez, actualice no_of_times
                                $auctionbidder->no_of_times = $auctionbidder->no_of_times+1;
                                $auctionbidder->save();

                            } else {

                                // si es la primera vez - guardar registro
                                $auctionbidder = new AuctionBidder;

                                $auctionbidder->auction_id = $auction_id;
                                $auctionbidder->sub = $sub;
                                $auctionbidder->bidder_id  = $currentUser->id;
                                $auctionbidder->no_of_times= 1;
                                $auctionbidder->slug       = $auctionbidder::makeSlug(getHashCode());
                                $auctionbidder->save();
                            }     


                            //tabla de ofertas
                            $bidding = new Bidding;
                            $bidding->ab_id = $auctionbidder->id;
                            $bidding->bid_amount = $bid_amount;

                            $bidding->save();

                            flash('success','Oferto exitosamente', 'success');
                            return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);


                        }

                    } else {

                        flash('error','la fecha de la subasta no es válida', 'error');
                        return redirect(URL_HOME_AUCTIONS);
                    }
                } else {

                    flash('error','subasta no encontrada', 'error');
                    return redirect(URL_HOME_AUCTIONS);
                }        
                
            
            } else {
                flash('error','monto de la oferta no válido', 'error');
                return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
            }

            
        } else {
           
            flash('info','Por favor inicie sesión para continuar', 'info');
            return redirect(URL_USERS_LOGIN);
        }

    }

    /**
     * [isValidRecord description]
     * @param  [type]  $record [description]
     * @return boolean         [description]
     */
    public function isValidRecord($record)
    {
       if ($record === null) {
          flash('Ooops...!', "página no encontrada", 'error');
          return $this->getRedirectUrl();
       }

       return FALSE;
    }

    /**
     * [getRedirectUrl description]
     * @return [type] [description]
     */
    public function getRedirectUrl()
    {
      return URL_HOME_AUCTIONS;
    }


     /**
      * [check_isdemo description]
      * @return [type] [description]
      */
    public function check_isdemo()
    {
       if (env('DEMO_MODE'))
          return URL_HOME_AUCTIONS;
       else
          return false;
    }







    public function saveLiveBid(Request $request)
    {
        // dd($request);
        //comprobar inicio de sesión
        //comprobar la autenticación del usuario
        if (!checkRole(getUserGrade(2))) {
          //999 - Sin iniciar sesión
          return json_encode(array('status'=>999));
        }


        if (checkRole(getUserGrade(4))) {
            // return redirect(URL_DASHBOARD);
            //999-usuario no autorizado
             return json_encode(array('status'=>999));
        }



        $currentUser = \Auth::user();

        $bid_amount  = $request->bid_amount;
        $auction_id  = $request->bid_auction_id;
        $sub  = $request->bid_sub;

        $save=FALSE;

        if ($currentUser) {


           if ($redirect = $this->check_isdemo()) {
              // flash('info','crud_operations_disabled_in_demo', 'info');
              // return redirect($redirect);
              //9999-demo mode
              return json_encode(array('status'=>999));
           }

            if ($bid_amount && $auction_id) {

                //comprobar si el usuario es postor
                if ($currentUser->role_id!=getRoleData('bidder')) {
                    // flash('error','please_login_as_bidder_to_continue', 'error');
                    // return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                    //999-not authorized user
                    return json_encode(array('status'=>999));
                }
            

                //comprobar la fecha de la subasta, hora de inicio y finalización, estado de la subasta, estado de administrador
                // $auction = Auction::where('id',$auction_id)->first();//two columns have toinclude

                $auction = Auction::join('users','auctions.user_id','users.id')
                        ->join('categories','auctions.category_id','categories.id')
                        ->join('sub_catogories','auctions.sub_category_id','sub_catogories.id')
                        ->select(['auctions.*'])
                        ->where('auctions.admin_status','approved')
                        ->where('auctions.auction_status', '=', 'open')
                        ->where('users.role_id',getRoleData('seller'))
                        ->where('users.approved',1)
                        ->where('auctions.live_auction_date','=',DATE('Y-m-d'))
                        ->where('categories.status','Active')
                        ->where('sub_catogories.status','Active')
                        ->where('auctions.id',$auction_id)
                        ->first(); 
             
                // $auction = Auction::getLiveAuctionRecord($auction_id);//working
                //comprobar la fecha de inicio y finalización de la subasta
                //si es hora actual>= hora de inicio y hora_actual <= fecha_final guardar
                //De lo contrario, muestra que no está en vivo ahora.--misma condición anterior - método de subasta en vivo

                  if (!empty($auction)) {


                  //verifique que alguien pagó el monto de la subasta / compró la subasta
                  //bid payment - paid or not
                  $bid_payment_record = $auction->getAuctionPayment();
                  
                  //buy now payment - paid or not
                  $buy_now_payment_record = $auction->getBuyNowAuctionPayment();
                  
                  $bid_div=true;
                  if (count($bid_payment_record) || count($buy_now_payment_record))
                    $bid_div = false;

                      if (!$bid_div) {
                          /*flash('info','Some one has already won/bought this auction..','info');
                          return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);*/

                          //auction is already sold -
                         return json_encode(array('status'=>1111));
                      }





                     //condición de subasta en vivo
                      $live_auction=false;
                      $today = date('Y-m-d');
                      if ($auction->live_auction_date) {

                          if ($auction->admin_status=='approved' && $auction->auction_status=='open' && $auction->live_auction_date==$today) {

                            $live_auction_start_time = strtotime($auction->live_auction_start_time);
                            $live_auction_end_time   = strtotime($auction->live_auction_end_time);


                              //alcanzado el precio de reserva y el tiempo ha terminado
                              //mostrar ganador
                              $reserve_price = $auction->reserve_price;

                              //comprobar la última puja reciente de la subasta
                              $auction_last_bid = Bidding::getAuctionLastBid($auction->id);
                              if (!empty($auction_last_bid)) {

                                if ($bid_amount>$auction_last_bid->bid_amount) {
                                    //guardar en la mesa
                                    $save=TRUE;
                                } else {
                                     return json_encode(array('status'=>99));
                                }

                                if ($auction_last_bid->bid_amount >= $reserve_price) {
                                  //comprobar si el tiempo de la subasta ha terminado
                                  if ($live_auction_start_time <= time() && $live_auction_end_time >= time()) {
                                    $live_auction=true;
                                  }

                                   if (!$live_auction) {
                                        //reached /> precio de reserva, muestra el ganador del tiempo de subasta ha terminado
                                        $currency_code = getSetting('currency_code','site_settings');
                                        $msg = $auction_last_bid->name.' ha ganado la subasta con la oferta más alta '.$currency_code.$auction_last_bid->bid_amount;
                                         return json_encode(array('status'=>555,'msg'=>$msg));
                                   }

                                }
                              }

                              //precio de reserva no alcanzado
                              if ($live_auction_start_time <= time() && $live_auction_end_time >= time()) {
                                $live_auction=true;
                              }

                          }
                      }
                      if (!$live_auction) {
                        /*flash('info','Bidding time is not valid..can not place bid now', 'info');
                        return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);*/
                         return json_encode(array('status'=>11));//auction date/time is not matching
                      }

                    //start date time,end date time
                   /* $now = strtotime(date('Y-m-d H:i:s'));
                    $start_date = strtotime($auction->start_date);
                    $end_date   = strtotime($auction->end_date);*/

                    if ($live_auction && $bid_div) {



                        //comprobar la última oferta reciente
                        $last_bid = Bidding::getLastBidRecord($auction->id);


                        /**CONDICIONES DE LA OFERTA DE LA SUBASTA EN VIVO**/
                        $placeholder='';
                        $minimum_bid = $auction->minimum_bid;


                        //comprobar tipo_de_subasta
                        if ($auction->is_bid_increment && $auction->bid_increment>0) {
                          //si es incremental
                          if (!empty($last_bid)) {

                            $bid_increment = $auction->bid_increment;


                            if (($bid_amount > $last_bid->bid_amount) && ($bid_amount==($last_bid->bid_amount+$bid_increment))) {
                              //bid amount > importe de la última oferta realizada+
                              //bid amount == última oferta realizada + importe incremental
                              $save=TRUE;
                            } else {
                              $save=FALSE;
                            }

                          } else {
                              //puja por primera vez
                              if ($minimum_bid>0) {
                                //si se establece la oferta mínima
                                if ($bid_amount > $minimum_bid) {
                                  //if bid amount > la oferta mínima
                                  $save=TRUE;
                                } else {
                                  $save=FASLE;
                                }
                              } else {
                                //si no se establece la oferta mínima
                                $save=TRUE;
                              }
                          }


                        } else {
                          //si no hay incremento
                          
                            if (!empty($last_bid)) {
                                //segunda vez en adelante
                                if ($bid_amount > $last_bid->bid_amount) {
                                  //bid amount > última oferta realizada
                                  $save=TRUE;
                                } else {
                                  $save=FALSE;
                                }

                            } else {
                                //puja por primera vez
                                if ($minimum_bid>0) {
                                  //conjunto de oferta mínima
                                  //check bid_amount > minimum_bid
                                  if ($bid_amount > $minimum_bid) {
                                    //guardar
                                    $save=TRUE;
                                  } else {
                                    //no salvar
                                    $save=FALSE;
                                  }

                                } else {
                                  //sin oferta mínima
                                  //guardar
                                  $save=TRUE;
                                }
                            }
                        }
                        /**SUBASTA EN VIVO**/

                           $auctionbidder = AuctionBidder::where('auction_id',$auction_id)
                                                            ->where('sub',$sub)
                                                            ->where('bidder_id',$currentUser->id)
                                                            ->select(['id','no_of_times'])
                                                            ->first();

                            if(count($auctionbidder)){
                                if($auctionbidder->no_of_times < $auction->tiros){

                                    $save=TRUE;
                                    //dd($save);
                                } else {
                                     return json_encode(array('status'=>112));

                                }
                            }


                        
                        if ($save) {

                            $auctionbidder = AuctionBidder::where('auction_id',$auction_id)
                                                            ->where('bidder_id',$currentUser->id)
                                                            ->select(['id','no_of_times'])
                                                            ->first();
                            if (count($auctionbidder)) {

                                //si no es la primera vez--luego actualice no_of_times
                                $auctionbidder->no_of_times = $auctionbidder->no_of_times+1;
                                $auctionbidder->save();

                            } else {

                                //si es la primera vez--guardar registro
                                $auctionbidder = new AuctionBidder;

                                $auctionbidder->auction_id = $auction_id;
                                $auctionbidder->sub = $sub;
                                $auctionbidder->bidder_id  = $currentUser->id;
                                $auctionbidder->no_of_times= 1;
                                $auctionbidder->slug      = $auctionbidder::makeSlug(getHashCode());
                                $auctionbidder->save();
                            }     


                            //bidding table
                            $bidding = new Bidding;
                            $bidding->ab_id = $auctionbidder->id;
                            $bidding->bid_amount = $bid_amount;

                            $bidding->save();


                            //placeholder
                            $enter_amount = 'Ingrese monto';
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
                                $enter_amount .= '> '.$bidding->bid_amount;
                              elseif ($auction->minimum_bid>0)
                                $enter_amount .= '> '.$auction->minimum_bid;
                            }



                            //last 5 bids
                            $currency_code = getSetting('currency_code','site_settings');
                            
                            $latest_bids='';
                            $last_five_bids = $auction->getAuctionBiddingHistory(5);

                            if (count($last_five_bids)) {
                              $latest_bids ='<ul class="list-group">';

                              foreach ($last_five_bids as $lb) {

                                $latest_bids .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                                '.$lb->name.'
                                <span class="badge badge-primary badge-pill">'.$currency_code.$lb->bid_amount.'</span></li>';
                              }

                              $latest_bids .= '</ul>';
                            }

                            return json_encode(array('status'=>111,
                                                    'latest_bids'=>$latest_bids,
                                                    'placeholder'=>$enter_amount
                                                    ));//oferta realizada con éxito
                            //marcador de posición
                            //últimas 5 pujas
                            
                            // flash('success','bid_placed_successfully', 'success');
                            // return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);

                        } else {
                          return json_encode(array('status'=>99));//monto de la oferta no válido
                        }
                        
                    } else {

                      return json_encode(array('status'=>9999));//auction is not in live

                        // flash('error','auction_date_time_is_not_valid', 'error');
                        // return redirect(URL_HOME_AUCTIONS);
                    } 

                  } else {

                    // flash('error','auction_not_found', 'error');
                    // return redirect(URL_HOME_AUCTIONS);
                    return json_encode(array('status'=>0));//registro de subasta no encontrado
                }        
                
            
            } else {
                // flash('error','bid_amount_not_valid', 'error');
                // return redirect(URL_HOME_AUCTION_DETAILS.'/'.$auction->slug);
                //99-bid cantidad no válida
                return json_encode(array('status'=>99));//operación inválida
            }

            
        } else {
           
            // flash('info','please_login_to_continue', 'info');
            // return redirect(URL_USERS_LOGIN);
            //999-not authorized user
             return json_encode(array('status'=>999));
        }

    }




    public function liveAuctions(Request $request)
    {

        if (checkRole(getUserGrade(4))) {
            return redirect(URL_DASHBOARD);
        }

        //que se venden / monto de la subasta pagado -
        $payment_auctions=Payment::where('payment_status','=','success')
                                    ->pluck('auction_id')
                                    ->toArray();
       
        $auctions =  Auction::join('users','auctions.user_id','users.id')
                      ->join('categories','auctions.category_id','categories.id')
                      ->join('sub_catogories','auctions.sub_category_id','sub_catogories.id')
                      ->join('countries','users.country_id','countries.id')
                      ->join('states','users.state_id','states.id')
                      ->join('cities','users.city_id','cities.id')
                      ->select(['auctions.id','auctions.title','auctions.slug',
                                'auctions.description','auctions.image',
                                'auctions.reserve_price','auctions.auction_status',
                                'auctions.created_at','auctions.live_auction_date',
                                'auctions.live_auction_start_time',
                                'auctions.live_auction_end_time',
                                'users.slug as user_slug','users.username',
                                'countries.title as country','states.state','cities.city'])
                      ->where('auctions.admin_status','approved')
                      ->where('auctions.auction_status','open')
                      ->where('categories.status','Active')
                      ->where('sub_catogories.status','Active')
                      ->where('users.role_id',getRoleData('seller'))
                      ->where('users.approved',1)
                      ->whereNotIn('auctions.id',$payment_auctions)
                      ->whereDate ('auctions.live_auction_date','=',DATE('Y-m-d'))//correct
                      ->where(function ($query) {
                      $query->whereTime('auctions.live_auction_start_time', '<=', DATE('H:i:s'))
                            ->orWhereTime('auctions.live_auction_start_time', '>=', DATE('H:i:s'));
                      })//correct-happening now,gonna happen today
                      // ->whereTime('auctions.live_auction_start_time', '<=', DATE('H:i:s'))//correct
                      ->whereTime('auctions.live_auction_end_time', '>=', DATE('H:i:s'))//correct
                      /*->where('auctions.start_date','<=',NOW())
                      ->where('auctions.end_date','>=',NOW())*/
                      /*->where('auctions.start_date','<=',DATE('Y-m-d'))
                      ->where('auctions.end_date','>=',DATE('Y-m-d'))*/
                      /*->where(function ($query) {
                      $query->where('auctions.auction_status', '=', 'open')
                            ->orWhere('auctions.auction_status', '=', 'new');
                      })*/
                      ->orderBy('auctions.id','desc')
                      // ->orderByRaw('RAND()')->take(6)
                      ->get();

        
        $data['live_auctions'] = $auctions;
        
       

        $data['active_class']   = 'live_auctions';
        $data['layout']         = getLayout();
        $data['title']          = getPhrase('subastas en vivo');

        $invitacion = DB::table('invitaciones')
        ->get();
        //dd($invitacion);

        return view('home.pages.auctions.live_auctions', $data, compact('invitacion'));

    }
}