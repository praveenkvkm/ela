@include('layouts.ela-header')
<?php
	$activity_master = $return_data['activity_master'];
	$act_acs_videos = $return_data['act_acs_videos'];
	$act_acs_audios = $return_data['act_acs_audios'];
	$act_acs_docs = $return_data['act_acs_docs'];
?>
<body>
    <nav class="navbar navbar-expand navbar-white navbar-dark bg-blue">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="{{asset('public/ela-assets/images/elaschool.png')}}" width="120"></a>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/2.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link text-dark" href="#"><img src="{{asset('public/ela-assets/images/1.jpg')}}" width="24" /></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle profile-avatar" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/ela-assets/images/avatar.jpg')}}" width="30"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main class="main students-login">
        <div class="jumbotron">
            <div class="container">
                <div class="row pb-0">
                    <div class="col-12 d-flex">

                        <div class="col-md-5">
                            <h3 class="font-weight-bold main-fo orange">{{$activity_master[0]->activity_title}}</h3>
                            <p class="sub-text">By Alexandre Dumas</p>
                        </div>
                        <div class="col-md-7 d-flex p-0">
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Subject</p>
                                <p class="pt-1">Physics</p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Max Marks</p>
                                <p class="pt-1">150</p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Date Created</p>
                                <p class="pt-1">18 August 2020</p>
                            </div>
                            <div class="col-3">
                                <p class="sub-text m-0 pt-2">Due Date</p>
                                <p class="pt-1 orange">09 September 2020</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!----------body content place here----------->

        <div class="container">
            <div class="row three-boxes">
                <div class="col-md-8">
                    <ul class="nav nav-tabs margin-minus">
                        <li><a data-toggle="tab" href="#menu1" class="active show">Video</a></li>
                        <li><a data-toggle="tab" href="#menu2">Audio</a></li>
                        <li><a data-toggle="tab" href="#menu3">PDF</a></li>
                    </ul>

                    <div class="tab-content pl-0 pr-0 mt-60">
                        <div id="menu1" class="tab-pane fade  active show">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="video-wrap">
                                        <video width="100%" controls >
											<source src="{{url('/public').($act_acs_videos[0]->acs_file_path ) .  $act_acs_videos[0]->acs_file_name }}" type="video/mp4">
                                            <source src="{{url('/public').($act_acs_videos[0]->acs_file_path ) .  $act_acs_videos[0]->acs_file_name }}" type="video/ogg">
                                        </video>
										
										
                                    </div>
                                    <h3 class="pt-30">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    </h3>
                                    <p>
                                        Nam consectetur quam id erat pretium, ut tincidunt diam imperdiet. In ac tincidunt turpis.
                                        Nulla consequat tortor a porta viverra.
                                    </p>
                                    <p>
                                        Sed ut purus euismod, auctor neque ac, vestibulum libero. Vivamus sagittis lectus nec ultricies ultrices. Etiam rutrum porttitor vulputate. In nulla urna, molestie id sapien sit amet, porta sollicitudin purus. Donec laoreet magna ut tellus maximus suscipit. Aenean nec tincidunt dui, vel euismod magna.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <h3>Audio</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
							<audio controls>
								  <source src="{{url('/public').($act_acs_audios[0]->acs_file_path ) .  $act_acs_audios[0]->acs_file_name }}" type="audio/ogg">
								  <source src="{{url('/public').($act_acs_audios[0]->acs_file_path ) .  $act_acs_audios[0]->acs_file_name }}" type="audio/mpeg">
									Your browser does not support the audio element.
							</audio>

                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <h3>Documents</h3>
                            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							<iframe width="99%" height="300px" class="doc" src="{{url('/public').($act_acs_docs[0]->acs_file_path ) .  $act_acs_docs[0]->acs_file_name }}"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity p-50">
                        <h3><img src="images/download.png')}}" /> Download this Activity</h3>
                        <hr>
                        <form>
                            <div class="form-group mb-30">
                                <div class="custom-file">
                                    <input type="file" name="files[]" multiple class="custom-file-input form-control" id="customFile">
                                    <label class="custom-file-label" for="customFile">Upload your Activity</label>
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Add Notes Here"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row pt-30 pb-90">
                <div class="col-md-12">
                    <h2 class="pb-15">Upcoming Activities</h2>
                    <div class="card">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td colspan="2">
                                        <p class="dark-blue font-weight-bold">French for Beginners</p>
                                        <p class="sub-text2">By Alexandre Dumas</p>
                                    </td>
                                    <td class="orage">09 September 2020</td>
                                    <td class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        Active</td>
                                    <td>VIII</td>
                                    <td><button type="button" class="btn btn-primary">Launch</button></td>
                                    <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td colspan="2">
                                        <p class="dark-blue font-weight-bold">Essay on French Revolution</p>
                                        <p class="sub-text2">By Alexandre Dumas</p>
                                    </td>
                                    <td>09 September 2020</td>
                                    <td class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        Active</td>
                                    <td>VIII</td>
                                    <td><button type="button" class="btn btn-primary">Launch</button></td>
                                    <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td colspan="2">
                                        <p class="dark-blue font-weight-bold">Algebra and its equations</p>
                                        <p class="sub-text2">By Alexandre Dumas</p>
                                    </td>
                                    <td>09 September 2020</td>
                                    <td class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        Active</td>
                                    <td>VIII</td>
                                    <td><button type="button" class="btn btn-primary">Launch</button></td>
                                    <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!----------body content place end here----------->
    </main>
    <footer class="container-fluid bg-dard-blue">
        <div class="container pt-5 pb-5 text-light">
            <div class="row">
                <div class="col-md-12">
                    <p>© Effective Teachers 2020. All rights reserved.</p>
                    <img class="ml-auto logo" src="{{asset('public/ela-assets/images/logo-light.png')}}" width="40" height="25">
                </div>

            </div>
        </div>
    </footer>

	@include('layouts.ela-footer')

</body>

</html>