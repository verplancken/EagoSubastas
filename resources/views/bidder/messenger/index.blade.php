@extends($layout)

@section('content')

@include('bidder.leftmenu')

    <!--Dashboard section -->


    <div class="col-12 au-onboard" id="contendor">
            <h2>Mensajes</h2>

            {{-- <a href="{{URL_HOME}}" class="au-middles justify-content-start"> {{getPhrase('home')}} &nbsp;<span> / {{$title}} </span></a> --}}

             <div class="row au-left-side">

                 <div class="col-md-12">
            <div class="list-group messages">
                @forelse($topics as $topic)
                    <div class="row msg-item">
                        <div class="col-md-8">
                            <a href="{{ route('messenger.show', [$topic->id]) }}" class="{{$topic->unread()?'unread':false}}">
                                {{ $topic->otherPerson()->email }}
                            </a>

                            <p><a href="{{ route('messenger.show', [$topic->id]) }}" class="{{$topic->unread()?'unread':false}}">
                                {{ $topic->subject }}
                                </a></p>
                        </div>
                        <div class="col-md-4 text-right time">{{ $topic->sent_at->diffForHumans() }}</div>

                    </div>
                @empty
                    <div class="row msg-item">
                       <h4 class="no-msg">
                      No hay mensajes
                        </h4>
                    </div>
                @endforelse
            </div>
        </div>




              </div>

            </div>

              </div>
      </div>
    </section>
    <!--Dashboard section-->

@endsection


