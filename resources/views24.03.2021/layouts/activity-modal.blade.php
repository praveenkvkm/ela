	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-view-activity">
		<div class="modal-dialog modal-lg  modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="view_activity_title">
								<span></span>
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
					<button type="button">
						<span></span>
					</button>
				</div>
				
			</div>
		</div>
	</div>
