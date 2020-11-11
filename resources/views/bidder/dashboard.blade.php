@extends($layout)

@section('content')

@include('bidder.leftmenu')


    <!--Dashboard section -->


{{--    <div class="col-lg-8 col-md-8 col-sm-12 au-onboard">--}}


{{--            <a href="{{URL_HOME}}" class="au-middles justify-content-start"> {{getPhrase('home')}} &nbsp;<span> / {{$title}} </span></a>--}}
{{--            --}}{{-- <a href="{{URL_HOME}}" class="au-middles justify-content-start"> Inicio <span> / Dashboard </span></a> --}}
{{--             <div class="row au-left-side">--}}
{{--               <div class="col-lg-4 col-md-4 col-sm-4 au-primary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                   <h4 class="text-center">{{\Auth::User()->getBidderParicipatedAuctions()->count()}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('auctions')}}</p>  --}}
{{--                     <p class="text-center">Subastas</p>--}}
{{--                   <a href="{{URL_BIDDER_AUCTIONS}}" title="My Auctions">{{getPhrase('view')}}</a> --}}
{{--                     <a href="{{URL_BIDDER_AUCTIONS}}" title="My Auctions">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div> --}}
{{--                --}}
{{--                 <div class="col-lg-4 col-md-4 col-sm-4 au-primary au-secondary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                   <h4 class="text-center">{{\Auth::User()->getBidderFavAuctions()->count()}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('fav_auctions')}}</p>  --}}
{{--                     <p class="text-center">Subastas favoritas</p>--}}
{{--                   <a href="{{URL_USERS_FAV_AUCTIONS}}" title="Favourite Auctions">{{getPhrase('view')}}</a> --}}
{{--                     <a href="{{URL_USERS_FAV_AUCTIONS}}" title="Favourite Auctions">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div>  --}}

{{--                 <div class="col-lg-4 col-md-4 col-sm-4 au-primary au-quinary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                   <h4 class="text-center">{{\Auth::User()->getBidderWonAuctions()->count()}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('won_auctions')}}</p>  --}}
{{--                     <p class="text-center">subastas ganadas</p>--}}
{{--                   <a href="{{URL_BIDDER_AUCTIONS}}" title="View Auctions">{{getPhrase('view')}}</a> --}}
{{--                      <a href="{{URL_BIDDER_AUCTIONS}}" title="View Auctions">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div>  --}}

{{--                 <div class="col-lg-4 col-md-4 col-sm-4 au-primary au-senary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                   <h4 class="text-center">{{\Auth::User()->getBidderPayments()->count()}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('payments')}}</p>  --}}
{{--                      <p class="text-center">pagos</p>--}}
{{--                   <a href="{{URL_BIDDER_PAYMENTS}}" title="payments">{{getPhrase('view')}}</a> --}}
{{--                     <a href="{{URL_BIDDER_PAYMENTS}}" title="payments">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div> --}}


{{--                 <div class="col-lg-4 col-md-4 col-sm-4 au-primary au-ternary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                   <h4 class="text-center">{{\Auth::User()->unreadNotifications()->count()}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('notifications')}}</p>  --}}
{{--                     <p class="text-center">notificaciones</p>--}}
{{--                   <a href="{{URL_USER_NOTIFICATIONS}}" title="Notifications">{{getPhrase('view')}}</a> --}}
{{--                     <a href="{{URL_USER_NOTIFICATIONS}}" title="Notifications">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div>  --}}
{{--                --}}
{{--                 <div class="col-lg-4 col-md-4 col-sm-4 au-primary au-quaternary">--}}
{{--                 <div class="au-card-franky">--}}
{{--                  @php ($unread = App\MessengerTopic::countUnread())--}}
{{--                   <h4 class="text-center">{{$unread}}</h4> --}}
{{--                   <p class="text-center">{{getPhrase('messages')}}</p>  --}}
{{--                     <p class="text-center">Mensajes</p>--}}
{{--                   <a href="{{URL_MESSENGER}}" title="Messages">{{getPhrase('view')}}</a> --}}
{{--                      <a href="{{URL_MESSENGER}}" title="Messages">Ver</a>--}}
{{--                 </div>     --}}
{{--                </div>  --}}

{{--              </div>   --}}
{{--            </div> --}}

{{--              </div>--}}
{{--      </div>   --}}
{{--    </section>--}}
    <!--Dashboard section-->
@endsection
