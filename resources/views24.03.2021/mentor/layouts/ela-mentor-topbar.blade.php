<?php

$profile_pic_path = url('/public') . '/' . Auth::guard('ela_user')->user()->prof_pic_path . Auth::guard('ela_user')->user()->prof_pic_file ;

$req = new \Illuminate\Http\Request();
$non_viewed_messages = app('App\Http\Controllers\MessengerController')->read_non_viewed_messages($req);
?>
	<nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
             
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
				<!--
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{asset($profile_pic_path)}}" width="30">
					</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<!--
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
						-->
                        <a class="dropdown-item" href="{{url('/elauserlogout')}}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
