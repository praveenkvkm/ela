	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-view-activity">
		<div class="modal-dialog modal-lg  modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="view_eval_activity_title" style="color: #f14ab6;">
								<span>ACTIVITY: </span>
							</h4>
							<br>
							<h4 class="modal-title" id="view_eval_student_name" style="color: #f14ab6;">
								
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="view_activity_subjects">
							</h5>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-modal-view-activity-close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs nav-tabs-media">
						<li id="li-video"><a data-toggle="tab" href="#tab-video" class="active show">Video</a></li>
						<li id="li-audio"><a data-toggle="tab" href="#tab-audio">Audio</a></li>
						<li id="li-docs"><a data-toggle="tab" href="#tab-docs">PDF</a></li>
						<li id="li-eval" style="display:none;"><a data-toggle="tab" href="#tab-eval" >Evaluations</a></li>
					</ul>

					<div class="tab-content mt-40">
					
						<div id="tab-video" class="tab-pane tab-pane-media fade active show ">
							<div class="video-wrap" >
								<video width="100%" controls id="videoActivity">
								</video>
								
								
							</div>
							<h3 class="modal_activity_title pt-30" id="modal_activity_title_video">
								
							</h3>
							<p class="modal_activity_description" id="modal_activity_description_video">
							
							</p>
						</div>
						<div id="tab-audio" class="tab-pane tab-pane-media fade">
							<h3 class="modal_activity_title" id="modal_activity_title_audio"></h3>
							<p class="modal_activity_description" id="modal_activity_description_audio">
							</p>
							
							<audio controls id="audioActivity">
							</audio>
							
							
						</div>
						<div id="tab-docs" class="tab-pane tab-pane-media fade">
							<h3 class="modal_activity_title" id="modal_activity_title_docs"></h3>
							<p class="modal_activity_description" id="modal_activity_description_docs">
							
							</p>
							<iframe id="docsActivity" width="99%" height="300px" class="doc">

							</iframe>
						</div>
						<div id="tab-eval" class="tab-pane tab-pane-media fade" style="display:none;">
							<div class="row">
								<div class="col-md-8">
									<h3 class="modal_activity_title" id=""></h3>
									<p class="modal_activity_description" id=""></p>
							
									<div class="table-responsive">
										<table class="table " id="table-marks">
											<thead class="bg-light">
												<tr>
													<th class="head-font" style="width:10rem">Sl.No.</th>
													<th class="head-font"  style="width:20rem">CRITERIA</th>
													<th class="head-font" style="width:20rem">GAINED MARK</th>
													<th class="head-font" style="width:20rem">BASE MARK</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot class="bg-light">
											</tfoot>
										</table>
									</div>
								</div>
								<div class="col-md-4">
									<h3 class="" id=""></h3>
									<p class="" id=""></p>
									<div class="table-responsive">
										<table class="table " id="table-comment">
											<thead class="bg-light">
												<tr>
													<th class="head-font" style="width:10rem">COMMENT</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot class="bg-light">
											</tfoot>
										</table>
									</div>
								</div>
								
							</div>
							<div class="row mt-4" >
								<div class="col-md-3">
									<div class="radio">
									  <label><input id="chk-eval-approved" type="radio" name="optradio" checked>Approved</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="radio">
									  <label><input id="chk-eval-rejected" type="radio" name="optradio" >Rejected</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
									  <input id="admin_comment" type="text" name="" placeholder="comments by admin" >
									</div>								
								</div>
								<div class="col-md-3">
									  <button type="button" id="btn-save-eval-approval">Save</button>
								</div>
							</div>
							
						</div>
					</div>

				</div>
				
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="">
								<span></span>
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="">
							</h5>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
