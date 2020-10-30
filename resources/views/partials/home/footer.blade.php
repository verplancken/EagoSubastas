<?php 
$aboutus=null;
$record = \App\ContentPage::select('page_text')->limit(1)->orderBy('id','asc')->get();
if ($record)
    $aboutus = $record[0]->page_text;


$pages = \App\ContentPage::select('title','slug')->limit(6)->orderBy('id','asc')->get();



$networks = \App\Settings::getSettingRecord('social_networks');
 
?>

 <!--Footer Section-->
    <footer class="au-footer" style="padding: 0px">
        <div class="container">
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-12 au-details">--}}
{{--                    <p>Detalles de contacto</p>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">--}}
{{--                    <div class="media au-icon-media"> <i class="pe-7s-map"></i>--}}
{{--                        <div class="media-body au-media-body">--}}
{{--                            <h4 class="au-card-title">Visítanos</h4>--}}
{{--                            <p class="au-card-text">Dirección del sitio, configuración del sitio</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">--}}
{{--                    <div class="media au-icon-media"> <i class="pe-7s-mail-open-file"></i>--}}
{{--                        <div class="media-body au-media-body">--}}
{{--                            <h4 class="au-card-title">Email</h4>--}}
{{--                            <p class="au-card-text">Email de contacto, configuración del sitio</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">--}}
{{--                    <div class="media au-icon-media"> <i class="pe-7s-phone"></i>--}}
{{--                        <div class="media-body au-media-body">--}}
{{--                            <h4 class="au-card-title">llámanos</h4>--}}
{{--                            <p class="au-card-text">teléfono del sitio, configuración del sitio</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!--footer body section-->
{{--            <div class="row au-footer-areas">--}}
{{--                <div class="col-lg-4 col-md-12 col-sm-12 au-body-footer">--}}

{{--                    <h4>Nosotros</h4>--}}
{{--                    <p> {!! str_limit($aboutus,200,'...') !!} </p>--}}


{{--                    @if ($networks->facebook->value)--}}
{{--                    <a href="{{$networks->facebook->value}}" target="_blank"> <i class="fa fa-facebook-f"></i> </a>--}}
{{--                    @endif--}}

{{--                    @if ($networks->google_plus->value)--}}
{{--                    <a href="{{$networks->google_plus->value}}" target="_blank"> <i class="fa fa-google"></i> </a>--}}
{{--                    @endif--}}

{{--                    @if ($networks->twitter->value)--}}
{{--                    <a href="{{$networks->twitter->value}}" target="_blank"> <i class="fa fa-twitter"></i> </a>--}}
{{--                    @endif--}}

{{--                    @if ($networks->instagram->value)--}}
{{--                    <a href="{{$networks->instagram->value}}" target="_blank"> <i class="fa fa-instagram"></i> </a>--}}
{{--                    @endif--}}

{{--                    @if ($networks->linkedin->value)--}}
{{--                    <a href="{{$networks->linkedin->value}}" target="_blank"> <i class="fa fa-linkedin"></i> </a>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6 col-sm-12 au-body-footer">--}}
{{--                    <h4> {{getPhrase('useful_links')}} </h4>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">--}}
{{--                            <ul class="au-links">--}}
{{--                                <li><a href="{{URL_CONTACT_US}}">Contactanos</a></li>--}}
{{--                                <li><a href="{{URL_HOME_AUCTIONS}}">próximas subastas</a></li>--}}
{{--                                <li><a href="{{URL_HOME_AUCTIONS}}">subastas cerca de usted</a></li>--}}
{{--                                 <li><a href="{{URL_HOME_AUCTIONS}}">subastas pasadas</a></li>--}}
{{--                                 <li><a href="{{URL_FAQS}}">preguntas frecuentes</a></li>--}}
{{--                                @if (!Auth::check())--}}
{{--                                    <li><a href="{{URL_USERS_LOGIN}}">Login</a></li>--}}
{{--                                @endif--}}
{{--                            </ul>--}}
{{--                        </div>--}}

{{--                        @if ($pages)--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">--}}
{{--                            <ul class="au-links">--}}
{{--                                @foreach ($pages as $page)--}}

{{--                               <li><a href="{{PREFIX}}{{$page->slug}}" title="{{$page->title}}">{{$page->title}}</a></li>--}}

{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6 col-sm-12 au-body-footer">--}}
{{--                    <h4>{{getPhrase('news_letter')}}</h4>--}}
{{--                    <p>{{getPhrase('signup_for_new_auction_updates')}}</p>--}}


{{--                        <div class="au-subscribe">--}}
{{--                            <input required type="email" ng-model="subscriber_email" class="form-control" placeholder="{{getPhrase('enter_email_address')}}" />--}}
{{--                            <button type="button" class="btn btn-default login-bttn" ng-click="saveSubscriber(subscriber_email)">{{getPhrase('subscribe')}}</button>--}}
{{--                        </div>--}}

{{--                </div>--}}
{{--            </div>--}}
            <!--FOOTER SUB SECTION-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 au-sub-footer mb-2">
                    <div class="d-flex justify-content-between">
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/derechos-de-autor" target="_blank">Derechos de autor</a> </p>
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/terminos-y-condiciones" target="_blank">Terminos y Condiciones</a> </p>
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/politica-de-privacidad" target="_blank">Politica de privacidad</a></p>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 au-sub-footer mt-2 mb-5">
                    <div class="d-flex justify-content-end">
                    @if ($networks->facebook->value)
                    <a class="ml-3" href="{{$networks->facebook->value}}" target="_blank"> <i class="fa fa-facebook-f"></i> </a>
                    @endif

                    @if ($networks->google_plus->value)
                    <a class="ml-3" href="{{$networks->google_plus->value}}" target="_blank"> <i class="fa fa-google"></i> </a>
                    @endif

                    @if ($networks->twitter->value)
                    <a class="ml-3" href="{{$networks->twitter->value}}" target="_blank"> <i class="fa fa-twitter"></i> </a>
                    @endif

                    @if ($networks->instagram->value)
                    <a class="ml-3" href="{{$networks->instagram->value}}" target="_blank"> <i class="fa fa-instagram"></i> </a>
                    @endif

                    @if ($networks->linkedin->value)
                    <a class="ml-3" href="{{$networks->linkedin->value}}" target="_blank"> <i class="fa fa-linkedin"></i> </a>
                    @endif
                    </div>
                </div>
            </div>
            <!--footer body section-->
        </div>
        <a href="#" class="btn-primary back-to-top show mt-2" title="Move to top"><i class="pe-7s-angle-up pe-2x"></i>sasa</a>
    </footer>
    <!--Footer Section-->


    


@section('footer_scripts')
@include('common.validations')
@include('common.alertify')

@include('home.pages.auctions.auctions-js-script')
@stop 
