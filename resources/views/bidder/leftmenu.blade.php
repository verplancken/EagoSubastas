@inject('request', 'Illuminate\Http\Request')


<?php

if (isset($active_class))
$active_class = $active_class;
else
$active_class='';

$user = Auth::user();

?>

 <section class="au-dashboard">
      <div class="container">

            <h2 class="text-center"><strong>Datos de Perfil</strong></h2>

        <div class="row">
              <div class="col-12">
                 <div class="media au-media-profile">
                         <img class="mr-3" src="{{getProfilePath($user->image)}}" alt="Profile Image" class="img-fluid">
                         <div class="media-body">
                           <h5 class="mt-0">{{$user->name}}</h5>
                            <p class="mt-0">{{$user->email}}</p>
                           <!-- <p>User Login: 28/02/2018 16:50:55</p> -->
                          </div>
                            <a class="mr-5" href="{{URL_LOGOUT}}" title="Logout">
                              <div class="link"><i class="fa fa-sign-out"></i>Cerrar Sesion</div>
                            </a>

                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Instrucciones3">
                                 <i class="fa fa-question" aria-hidden="true">Ayuda</i>
                            </button>
                     </div>
              </div>
          </div>

        <div class="row ">
            <div class="col-6 au-primary">
                             <div class="au-card-franky" style="background-color: #ff6000;">
                               <h4 class="text-center"><i class="fa fa-globe"></i></h4>
                                 <p class="text-center">Cuenta</p>
                                 <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="background-color: #b74803;">Ver</a>

                                    <div class="collapse" id="collapseExample">
                                      <div class="card card-body">
                                          <div class="row">
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_USERS_EDIT}}/{{$user->slug}}#contendor" title="Perfil">Perfil</a></div>
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_USER_BILLING_ADDRESS}}#contendor" title="Datos de Facturacion">Datos de Facturacion</a></div>
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_USER_SHIPPING_ADDRESS}}#contendor" title="Dirección de Envío">Dirección de Envío</a></div>
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_USERS_CHANGE_PASSWORD}}{{$user->slug}}#contendor" title="Cambia la contraseña">Cambia la contraseña</a></div>
                                          </div>
                                      </div>
                                    </div>
                             </div>
                         </div>

            <div class="col-6 au-primary">
                             <div class="au-card-franky" style="background-color: #FF052C;">
                               <h4 class="text-center"><i class="fa fa-envelope"></i> </h4>
                                 <p class="text-center">Mensajes</p>
                                  <a  data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample" style="background-color: #a0051e;">Ver</a>

                                    <div class="collapse" id="collapseExample2">
                                      <div class="card card-body">
                                          <div class="row">
                                             @php ($unread = App\MessengerTopic::countUnread())

                                              @if($unread > 0)
                                                  {{ ($unread > 0 ? '('.$unread.')' : '') }}
                                                @endif
                                              @if($unread > 0)
                                                  {{ ($unread > 0 ? '('.$unread.')' : '') }}
                                                @endif
                                              @php($unread_inbox = App\MessengerTopic::unreadInboxCount())
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_MESSENGER_INBOX}}#contendor" title="Bandeja de entrada ">Bandeja de entrada {{ ($unread > 0 ? '('.$unread.')' : '') }} </a></div>
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_MESSENGER_OUTBOX}}#contendor" title="Bandeja de salida">Bandeja de salida</a></div>
                                              <div class="col-12"><a class="bg-light text-dark" href="{{URL_MESSENGER_ADD}}#contendor" title="Crear">Crear</a></div>
                                          </div>
                                      </div>
                                    </div>
                             </div>
                         </div>
        </div>

        <hr>

        <h2 class="text-center"><strong>Datos de Subastas</strong></h2>

        <div class="row ">

            <div class="col-4 au-primary au-primary">
                <div class="au-card-franky">
                    <h4 class="text-center">{{\Auth::User()->getBidderParicipatedAuctions()->count()}}</h4>
                    <p class="text-center">Subastas Participadas</p>
                    <a href="{{URL_BIDDER_AUCTIONS}}#contenedor" title=" Subastas Participadas">Ver</a>
                </div>
            </div>

            <div class="col-4 au-primary au-primary au-quinary">
                <div class="au-card-franky">
                    <h4 class="text-center">{{\Auth::User()->getBidderWonAuctions()->count()}}</h4>
                    <p class="text-center">subastas ganadas</p>
                    <a href="{{URL_BIDDER_AUCTIONS}}#contenedor" title="subastas ganada">Ver</a>
                </div>
            </div>

            <div class="col-4 au-primary au-secondary">
                <div class="au-card-franky">
                    <h4 class="text-center"><i class="fa fa-gavel"></i> </h4>
                    <p class="text-center">Subastas Activas</p>
                    <a href="{{URL_HOME_AUCTIONS}}#contenedor" title="Subastas Activas">Ver</a>
                </div>
            </div>

        </div>

        <div class="row ">

            <div class="col-4 au-primary au-primary au-senary">
                <div class="au-card-franky">
                    <h4 class="text-center">{{\Auth::User()->getBidderPayments()->count()}}</h4>
                    <p class="text-center">pagos</p>
                    <a href="{{URL_BIDDER_PAYMENTS}}#contenedor" title="payments">Ver</a>
                </div>
            </div>

            <div class="col-4 au-primary au-primary au-ternary">
                <div class="au-card-franky">
                    <h4 class="text-center">{{\Auth::User()->unreadNotifications()->count()}}</h4>
                    <p class="text-center">notificaciones</p>
                    <a href="{{URL_USER_NOTIFICATIONS}}#contenedor" title="notificaciones">Ver</a>
                </div>
            </div>

            <div class="col-4 au-primary au-secondary au-quaternary">
                <div class="au-card-franky">
                    @php ($unread = App\MessengerTopic::countUnread())
                    <h4 class="text-center">{{$unread}}</h4>
                    <p class="text-center">Mensajes</p>
                    <a href="{{URL_MESSENGER}}#contendor" title="Mensajes">Ver</a>
                </div>
            </div>

        </div>

      </div>

        <div class="modal" id="Instrucciones3" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Dashboard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img class="d-block w-100" src="{{asset('public/images/dashboard.png')}}">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Aceptar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

</section>
