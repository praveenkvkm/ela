<style>
.tab-pane 
{
  max-height:450px;
  overflow-y: hidden;
}

.tab-pane::-webkit-scrollbar 
{
    width: 5px;
	background: #bbb5b5;
}

.inbox_chat::-webkit-scrollbar 
{
    width: 5px;
	background: #bbb5b5;
}

.tab-pane::-webkit-scrollbar-thumb 
{
    border-radius: 10px;
    background: #c3b5b5;
}

.inbox_chat::-webkit-scrollbar-thumb 
{
    border-radius: 10px;
    background: #c3b5b5;
}

.container{max-width:1170px; margin:auto;}
/*img{ max-width:100%;}*/
.chat_img > img 
{
	max-width:100%;
}
.incoming_msg{
    margin-left:15px;
}
.incoming_msg_img > img 
{
	max-width:100%;
}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 0px;
  width: 100%;
  border: 1px solid #ececec;
    border-radius: 10px;
    overflow: hidden;
}

 .sent_msg p {
  background: #009688 none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 15px 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
      padding: 10px;
      border: 1px solid #d4d4d4!important;
    border-radius: 0px 0px 10px 10px!important;
}
.input_msg_write input:focus{
    outline:none;
}

.type_msg {border-top:1px solid #e4e4e4;position: relative;}
.msg_send_btn {
  background: #77bf23 none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 10px;
  top: 7px;
  width: 33px;
}
.msg_send_btn:focus{
    outline:none;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
  background: #fff;
}

.input_msg_write input 
{
    background: #f1f1f1 none repeat scroll 0 0;
    border-radius: 0px;
}
.modal-content .modal-body .nav-tabs li a{
    font-weight:700;
}

</style>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');

$active_users =  app()->call([$cc, 'get_all_active_users']);
$stud_groups =  app()->call([$cc, 'get_stud_groups']);
$stud_grades=  app()->call([$cc, 'get_stud_grades']);



?>
	
	<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-messenger">
		<div class="modal-dialog  modal-dialog-centered" style="min-width:80%;">
			<div class="modal-content">
		
				<div class="modal-header">
					<div class="row">
						<div class="col-md-7">
							<h4 class="modal-title" id="view_activity_title">
							ELA COMMUNICATOR
							</h4>
						</div>
						<div class="col-md-5">
							<h5 class="modal-second-title" id="view_activity_subjects">
							</h5>
						</div>
					</div>
					<button type="button" id="btn-close-chat" class="close" data-dismiss="modal" aria-label="Close" id="btn-modal-view-activity-close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			
				<div class="modal-body" style="min-height: 500px;">
			
			
					<div>
						<div class="row">
							<div class="col-md-6">
							
							
							
								<div class="mesgs">
								  <div class="msg_history" id="msg_history">
								  
									
									
								  </div>
								  <div class="type_msg">
									<div class="input_msg_write">
									  <input id="message" type="text" class="write_msg" placeholder="Type a message" />
									  <button class="msg_send_btn" type="button" id="btn-send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
									</div>
								  </div>
								</div>
								
								
								
							</div>	
							
							<div class="col-md-6">
							
								<h2 style="font-size:18px;">Select Receivers</h2>

								<ul class="nav nav-tabs mt-20" style="border-bottom:none;">
									<li class="active"><a data-toggle="tab" href="#individuals">Individuals</a></li>
									<li><a data-toggle="tab" href="#groups">Groups</a></li>
									<li><a data-toggle="tab" href="#grades">Grades</a></li>
								</ul>

								<div class="tab-content">
									<div id="individuals" class="tab-pane show active">
										<input class="form-control" id="indInput" type="text" placeholder="Search.." >

										<div class="inbox_chat">
							  
											<br>
											<table class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Name</th>
													<th></th>
												  </tr>
												</thead>
												<tbody id="indTable">
												@foreach($active_users as $key=>$active_user) 
												  <tr>
													<td>{{$active_user->first_name . ' ' . $active_user->last_name  . ' | ' }} <span style="color:#d61e3e"> {{ $active_user->user_type }}</span></td>
													<td><input class="indCheck" id="indInput" type="checkbox" data-user_id_receiver="{{$active_user->id}}" ></td>
												  </tr>
												 @endforeach
												</tbody>
											</table>			
								
										</div>
						  
									</div>
									
									<div id="groups" class="tab-pane fade">
										
										<div class="inbox_chat">
							  
											<input class="form-control" id="grpInput" type="text" placeholder="Search..">
											<br>
											<table class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Group</th>
													<th></th>
												  </tr>
												</thead>
												<tbody id="grpTable">
												@foreach($stud_groups as $key=>$stud_group) 
												  <tr>
													<td>{{$stud_group->stud_group}}</td>
													<td><input class="grpCheck" id="" type="checkbox" data-group_id_receiver="{{$stud_group->id}}" ></td>
												  </tr>
												 @endforeach
												</tbody>
											</table>			
								
										</div>
									  
									</div>
									<div id="grades" class="tab-pane fade">
									
										
										<div class="inbox_chat">
							  
											<input class="form-control" id="grdInput" type="text" placeholder="Search..">
											<br>
											<table class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Grade</th>
													<th></th>
												  </tr>
												</thead>
												<tbody id="grdTable">
												@foreach($stud_grades as $key=>$stud_grade) 
												  <tr>
													<td>{{$stud_grade->stud_grade}}</td>
													<td><input class="grdCheck" id="" type="checkbox" data-grade_id_receiver="{{$stud_grade->id}}"></td>
												  </tr>
												 @endforeach
												</tbody>
											</table>			
								
										</div>
									  
									  
									</div>
									
								</div>	

							</div>
						</div>
					</div>			
				</div>
			
			</div> <!--modal content-->
		
		</div>
      
    </div>

<script>
$(document).ready(function(){
	
	//read_non_viewed__messages();
	
	my_user_id = "{{ Auth::guard('ela_user')->user()->id }}";
	
	
	 $("#indInput").on("keyup", function() 
	 {
		var value = $(this).val().toLowerCase();
		$("#indTable tr").filter(function() 
		{
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
  
  
	 $("#grpInput").on("keyup", function() 
	 {
		var value = $(this).val().toLowerCase();
		$("#grpTable tr").filter(function() 
		{
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
  
  
	 $("#grdInput").on("keyup", function() 
	 {
		var value = $(this).val().toLowerCase();
		$("#grdTable tr").filter(function() 
		{
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
  
	
	$(document).on('click', '#btn-send', function(event)
	{
		if($('#message').val())	
		{
			insert_message();
		}
		
	});
		
		
	$(document).on('click', '#btn-close-chat', function(event)
	{
			
		clearInterval(chat_timer);
		
	});
		
		
	$(document).on('click', '#a-open-chat', function(event)
	{
		read_all_messages_with_reply();
		$('#span-communications-count').hide();
		chat_timer = setInterval(function(){ read_and_mark_non_viewed_messages(); }, 5000);
	});
		

});

	function updateScroll()
	{		
		$("#msg_history").animate({
				        scrollTop:  40000
				   });
	}


	function insert_message()
	{
			
		var CSRF_TOKEN = '{{csrf_token()}}';
 
		url_var = APP_URL + '/insert_message';
				
		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['message'] = $('#message').val();
		
		var user_id_receiver = {};
		var group_id_receiver = {};	
		var grade_id_receiver = {};
		var recievers = 0;
		
		$('.indCheck:checked').each(function(index, elem) 
		{
			user_id_receiver[index] = $(this).data("user_id_receiver");
			recievers++;
		});	

		$('.grpCheck:checked').each(function(index, elem) 
		{
			group_id_receiver[index] = $(this).data("group_id_receiver");
			recievers++;
		});		
		
		$('.grdCheck:checked').each(function(index, elem) 
		{
			grade_id_receiver[index] = $(this).data("grade_id_receiver");
			recievers++;
		});		
		
		if(recievers)
		{
			
			$.ajax({
			   type:'post',
			   url: url_var,  
			   data: {data, user_id_receiver, group_id_receiver, grade_id_receiver},
			   async:false,
			   success:function(result_data)
				   {
					   
						 grp_string = '<div class="outgoing_msg">'+
						  '<div class="sent_msg">'+
							'<p>'+ $('#message').val() + '</p>'+
							'<span class="time_date"></span>' +
							'</div>'+
						'</div>';
											
						$('.msg_history').append(grp_string);
					   updateScroll();
						$('#message').val('');
						$('#message').focus();
						
					}
				});
			
		}
		else
		{
			alert('Please Select a Receiver.');
			
		}
			
			
	}


	function read_and_mark_non_viewed_messages()
	{	
		var CSRF_TOKEN = '{{csrf_token()}}';
		url_var = APP_URL + '/read_and_mark_non_viewed_messages';

		//var data ='user_id_receiver='+ user_id_receiver;
		var data ={};
		var xhttp=new XMLHttpRequest();			
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var msg = this.responseText;
				received_messages = msg;
				
				fill_non_viewed_messages();
			}
		  };
		
		xhttp.open("POST", url_var, false);
		xhttp.setRequestHeader("x-csrf-token", CSRF_TOKEN); 
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send(data);
	}


	function read_all_messages_with_reply()
	{	
		var CSRF_TOKEN = '{{csrf_token()}}';
		url_var = APP_URL + '/read_all_messages_with_reply';

		//var data ='user_id_receiver='+ user_id_receiver;
		var data ={};
		var xhttp=new XMLHttpRequest();			
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var msg = this.responseText;
				received_messages = msg;
				
				fill_all_messages_with_reply();
			}
		  };
		
		xhttp.open("POST", url_var, false);
		xhttp.setRequestHeader("x-csrf-token", CSRF_TOKEN); 
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send(data);
	}					
	
	
	function fill_non_viewed_messages()
	{	
		received_messages = JSON.parse(received_messages);
		cnt = received_messages.length;
		
		for( i = 0; i< cnt; i++ ) 
		{
			var date = new Date(received_messages[i].created_at);
			
			ist_time = date.getTime() + ( 5.5 * 60 * 60 * 1000 );
			var ist_date = new Date(ist_time); 
			
					grp_string = '<div class="incoming_msg" style="margin-bottom: 20px;">'+
						  '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>'+
						  '<div class="received_msg">'+
							'<div class="received_withd_msg">'+
							  '<p>'+ received_messages[i].message  +'</p>'+
							  '<span class="time_date">'+ received_messages[i].sender_first_name + ' ' + received_messages[i].sender_last_name + '  |  ' +  PKDateHHMnAmPm(ist_date) + '  |  ' +   PKDateDdMmYyyy(ist_date) + '</span>'+
							 '</div>'+
						  '</div>'+
						'</div>';
							
											
											
							
			$('.msg_history').append(grp_string);
			
			
		  
	   }
		//updateScroll();		   
	}	


 
	function fill_all_messages_with_reply()
	{	
		received_messages = JSON.parse(received_messages);
		cnt = received_messages.length;
		
		for( i = 0; i< cnt; i++ ) 
		{
			if(received_messages[i].user_id_receiver== my_user_id)
			{
				var date = new Date(received_messages[i].created_at);
			
				ist_time = date.getTime() + ( 5.5 * 60 * 60 * 1000 ); 
				var ist_date = new Date(ist_time); 
			
				grp_string = '<div class="incoming_msg" style="margin-bottom: 20px;">'+
					  '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>'+
					  '<div class="received_msg">'+
						'<div class="received_withd_msg">'+
						  '<p>'+ received_messages[i].message  +'</p>'+
						  '<span class="time_date">FROM. '+ received_messages[i].sender_first_name + ' ' + received_messages[i].sender_last_name + '  |  ' +  PKDateHHMnAmPm(ist_date) + '  |  ' +   PKDateDdMmYyyy(ist_date) + '</span>'+
						 '</div>'+
					  '</div>'+ 
					'</div>';
				$('.msg_history').append(grp_string);
			}
			else if(received_messages[i].user_id_sender== my_user_id)
			{
			
				 grp_string = '<div class="outgoing_msg">'+
				  '<div class="sent_msg">'+
					'<p>'+ received_messages[i].message + '</p>'+
					  '<span class="time_date">TO. '+ received_messages[i].receiver_first_name + ' ' + received_messages[i].receiver_last_name + '  |  ' +  PKDateHHMnAmPm(ist_date) + '  |  ' +   PKDateDdMmYyyy(ist_date) + '</span>'+
					'</div>'+
				'</div>';
									
				$('.msg_history').append(grp_string);
			
			
			}
		  
	   }
		updateScroll();	   
	}					
	
	
	
</script>
