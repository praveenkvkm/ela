<?php

use Carbon\Carbon;

$nc = app()->make('App\Http\Controllers\NotificationController');

$non_viewed_notifications = app()->call([$nc, 'get_non_viewed_notifications']);
$count_non_viewed_notifications = count($non_viewed_notifications);

$req = new \Illuminate\Http\Request();
$non_viewed_messages = app('App\Http\Controllers\MessengerController')->read_non_viewed_messages($req);

?>
	<nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
             
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
			<!--
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
			-->
                <li class="nav-item pt-1">
                    <!--<a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>-->
					
					<a id="a-open-chat" class="nav-link text-dark" href="#" data-toggle="modal" data-target="#modal-messenger" style="position: relative!important;">
						<img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" />
						@if(count($non_viewed_messages))
							<span class="no" id="span-communications-count" style="font-size:12px;padding-top:1px;">{{count($non_viewed_messages)}}</span>
						@endif
					</a>
					
                </li>
				
				@if(!$count_non_viewed_notifications)
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
				@else
                <li class="nav-item pt-1 dropdown">
                    <a class="nav-link dropdown-toggle text-dark" id="a-notifications" href="#" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" />
                        <span class="no" id="span-notifications-count">{{$count_non_viewed_notifications }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="a-notifications">
						@foreach($non_viewed_notifications as $key=>$non_viewed_notification) 
                        <a class="dropdown-item room-reminder" href="#" data-reminder_id="{{ $non_viewed_notification->id }}" data-reminder_room_id="{{ $non_viewed_notification->id }}">
                            <p class="mb-0"><b>Sender: </b></p>
                            <p class="mb-0"><b>{{ $non_viewed_notification->sender_first_name .' ' . $non_viewed_notification->sender_last_name  }} </b></p>
                            <p class="mb-0"><b>({{ $non_viewed_notification->user_type }} )</b></p>
                            <p class="mb-0">{{ 'On: '. \Carbon\Carbon::parse($non_viewed_notification->created_at)->format('d/m/Y')}}</p>
                            <p class="mb-0">{{ $non_viewed_notification->message}}</p>
                        </a>
						@endforeach
                    </div>
                </li>
				@endif
				
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{asset(Session::get('profile_pic_path'))}}" width="30">
					</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<!--
                        <a id="a-open-chat" class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-messenger">Chat</a>
                        <div class="dropdown-divider"></div>
					-->
                        <a class="dropdown-item" href="{{url('/elauserlogout')}}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
