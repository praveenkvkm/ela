<?php

use Carbon\Carbon;

$sc = app()->make('App\Http\Controllers\StudentController');

$mentor_room_reminders_to_students = app()->call([$sc, 'get_mentor_room_reminders_to_students']);
$count_mentor_room_reminders_to_students = count($mentor_room_reminders_to_students);


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
				
				@if(!$count_mentor_room_reminders_to_students)
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
				@else
                <li class="nav-item pt-1 dropdown">
                    <a class="nav-link dropdown-toggle text-dark" id="a-notifications" href="#" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" />
                        <span class="no" id="span-notifications-count">{{$count_mentor_room_reminders_to_students }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="a-notifications">
						@foreach($mentor_room_reminders_to_students as $key=>$mentor_room_reminder) 
                        <a class="dropdown-item room-reminder" href="#" data-reminder_id="{{ $mentor_room_reminder->reminder_id }}" data-reminder_room_id="{{ $mentor_room_reminder->room_id }}">
                            <b>Reminder By {{ $mentor_room_reminder->mentor_first_name   }}</b>
                            <p class="mb-0">{{ 'On: '. \Carbon\Carbon::parse($mentor_room_reminder->reminder_date)->format('d/m/Y')}}</p>
                            <p class="mb-0">{{ $mentor_room_reminder->reminder_text}}</p>
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
