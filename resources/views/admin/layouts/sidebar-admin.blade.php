<style>
.sidebar .nav>.nav-item a:focus i, .sidebar .nav>.nav-item a:hover i, .sidebar .nav>.nav-item a:focus p, .sidebar .nav>.nav-item a:hover p 
{
    color: #28a745!important;
}

</style>
	<!-- Sidebar -->
		<div class="sidebar">
			
			<div class="sidebar-background"></div>
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<!--
						<div class="avatar-sm float-left mr-2">
							<img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
						</div>
						-->
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									
									<span class="user-level">{{ Auth::guard('ela_user')->user()->first_name}}</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<!--
									<li>
										<a href="#profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Edit Profile</span>
										</a>
									</li>
									-->
									<li>
										<a href="{{url('/elauserlogout')}}">
											<span class="link-collapse">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					
					<ul class="nav">
						<li id="item-dashboard" class="nav-item">
							<a href="{{url('admin/dashboard')}}">
								<i class="fas fa-home"></i>
								<p>DASHBOARD</p>
								<!--<span class="badge badge-count">5</span>-->
							</a>
						</li>
						<!--
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Components</h4>
						</li>
						-->
						<li class="nav-item">
							<a id="item-stud-group" href="{{url('admin/stud-group')}}">
								<i class="fas fa-desktop"></i>
								<p>ADD GROUPS</p>
							</a>
							<a id="item-stud-group" href="{{url('admin/stud-grade')}}">
								<i class="fas fa-desktop"></i>
								<p>ADD GRADES</p>
							</a>
							<a id="item-goat-entry" href="{{url('admin/add-mentor')}}">
								<i class="fas fa-desktop"></i>
								<p>ADD MENTORS</p>
								<!--<span class="caret"></span>-->
							</a>
							<!--
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="../components/avatars.html">
											<span class="sub-item">Avatars</span>
										</a>
									</li>
									<li>
										<a href="../components/buttons.html">
											<span class="sub-item">Buttons</span>
										</a>
									</li>
								</ul>
							</div>
							-->
							<a id="item-add-student" href="{{url('admin/add-student')}}">
								<i class="fas fa-desktop"></i>
								<p>ADD STUDENTS</p>
							</a>
							<a id="item-stud-in-group" href="{{url('admin/stud-in-group')}}">
								<i class="fas fa-desktop"></i>
								<p>ADD STUD IN GROUPS</p>
							</a>
							<a id="item-weighment-entry" href="{{url('admin/activity/dashboard')}}">
								<i class="fas fa-desktop"></i>
								<p>CREATE ACTIVITY</p>
							</a>
							<!--
							<a id="item-goat-register" href="{{url('/goat-register')}}">
								<i class="fas fa-desktop"></i>
								<p>GOAT REGISTER</p>
							</a>
							
							<a id="item-goat-list" href="{{url('/goat-list')}}">
								<i class="fas fa-desktop"></i>
								<p>GOAT LIST</p>
							</a>
							<a id="item-stock-register" href="{{url('/stock-register')}}">
								<i class="fas fa-desktop"></i>
								<p>STOCK CHART</p>
							</a>
							<a id="item-blocks" href="{{url('/blocks')}}">
								<i class="fas fa-desktop"></i>
								<p>BLOCKS</p>
							</a>
						</li>
						-->
						
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

