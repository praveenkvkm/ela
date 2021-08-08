    
	$(document).ready(function()
	{
		work = "A";
		work_kid = 'A';
		kid_gender = '';
		breading_id = 0;
		mother_id = 0;
		buck_id = 0;
		kid_id = 0;
		
		mated = 0;
		mate_date = null;
		confirmed = 0;
		confirmed_date = null;
		delivered = 0;
		delivery_date = null;
		delivery_type = 0;
		gravida = 0;
		male_kids = 0;
		female_kids = 0;
		dead_kids = 0;
		total_kids = 0;
		end_entry = 0;
		end_entry_date = null;
			
		timerVar = '';
		
		mother_category_id = 0;
		buck_category_id = 0;
		
		
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		

		
	});
	
	function blink_text() 
	{
		$('#p-edit-mode').fadeOut(500);
		$('#p-edit-mode').fadeIn(500);
	}	
	
	function empty_all_fields() 
	{
		$('#buck_id').val(0);
		
		$("#mated").prop("checked", false);
		$('#mated').attr('disabled', true);
		$('#mate_date').val('');
		$('#mate_date').attr('disabled', true);
		
		$("#confirmed").prop("checked", false);
		$('#confirmed').attr('disabled', true);
		$("#confirmed_date").val('');
		$('#confirmed_date').attr('disabled', true);
		
		$("#delivered").prop("checked", false);
		$('#delivered').attr('disabled', true);
		$("#delivery_date").val('');
		$('#delivery_date').attr('disabled', true);
		$('#delivery_type').val(0);
		$('#gravida').val('');
		
		$('#male_kids').val('');
		$('#female_kids').val('');
		$('#dead_kids').val('');
		$('#total_kids').val('');
		
		$("#end_entry").prop("checked", false);
		$('#end_entry').attr('disabled', true);
		$("#end_entry_date").val('');
		$('#end_entry_date').attr('disabled', true);
	}	
	 
	 
	function enable_deserved_fields() 
	{
		
		if($('#mother_id').val())
		{
			$('#a-weighment').attr('disabled', false);
			$('#a-weighment').attr('data-target', '#weighmentModal');
		}
		else
		{
			$('#a-weighment').attr('disabled', true);
			$('#a-weighment').attr('data-target', '');
		}
		
		 
		if($('#mother_id').val()!=0 && $('#buck_id').val()!=0)
		{
			$("#mated").attr("disabled", false);
			$('#mate_date').attr("disabled", false);
		}
		else
		{
			$("#mated").attr("disabled", true);
			$('#mate_date').attr("disabled", true);
		}
		
		
		
		if($('#mated').is(":checked"))
		{
			$("#confirmed").attr("disabled", false);
			$("#confirmed_date").attr("disabled", false);
		}
		else
		{
			$('#mate_date').val('');
			$("#confirmed").attr("disabled", true);
			$("#confirmed_date").attr("disabled", true);
		}
		
		
		if($('#confirmed').is(":checked"))
		{
			$("#delivered").attr("disabled", false);
			$("#delivery_date").attr("disabled", false);
		}
		else
		{
			$('#confirmed_date').val('');
			$("#delivered").attr("disabled", true);
			$("#delivery_date").attr("disabled", true);
		}
		
		/*
		if($('#delivered').is(":checked"))
		{
			$('#delivery_date').val(pk_today);
			$('#gravida').val(gravida);
			$("#end_entry").attr("disabled", false);
			$("#end_entry_date").attr("disabled", false);
			
			$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '#kidsModal');
		}
		else
		{ 
			$('#delivery_date').val('');
			$('#gravida').val('');
			$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '');
			$('#delivery_date').val('');
			$("#end_entry").attr("disabled", true);
			$("#end_entry_date").attr("disabled", true);
			
		}
		*/
		
		if($('#delivered').is(":checked"))
		{
			
			$("#delivery_date").attr("disabled", false);
			$('#delivery_date').val(pk_today);
			$('#gravida').val(gravida);
			$("#lbl-gravida").removeClass("disabled");
			$('#delivery_type').attr("disabled", false);
			$("#lbl-delivery_type").removeClass("disabled");
			$("#lbl-male_kids").removeClass("disabled");
			$("#lbl-female_kids").removeClass("disabled");
			$("#lbl-dead_kids").removeClass("disabled");
			$('#dead_kids').attr("disabled", false);
			$("#lbl-total_kids").removeClass("disabled");
			$("#lbl-end_entry").removeClass("disabled");
			
			$("#end_entry").attr("disabled", false);
			//$("#end_entry_date").attr("disabled", false);
			
			$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '#kidsModal');
		}
		else
		{
			$("#delivery_date").attr("disabled", true);
			
				$('#delivery_date').val('');
				$("#end_entry").attr("disabled", true);
				$("#end_entry_date").attr("disabled", true);
				$('#gravida').val('');
				$("#lbl-gravida").addClass("disabled");
				$('#delivery_type').attr("disabled", true);
				$("#lbl-delivery_type").addClass("disabled");
				$("#lbl-male_kids").addClass("disabled");
				$("#lbl-female_kids").addClass("disabled");
				$("#lbl-dead_kids").addClass("disabled");
				$('#dead_kids').attr("disabled", true);
				$("#lbl-total_kids").addClass("disabled");
				$("#lbl-end_entry").addClass("disabled");
				
				$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '');
			
		}
		
		

	}	
	
	$(document).on('change', '#mother_id, #buck_id', function(event)
	{
			
		if($('#mother_id').val()!=0 && $('#buck_id').val()!=0)
		{
			$("#mated").attr("disabled", false);
			$("#lbl-mated").removeClass("disabled")
		}
		else
		{
			$("#mated").attr("disabled", true);
			$("#lbl-mated").addClass("disabled")
		}
		
		
	});
	
	
	$(document).on('change', '#buck_id', function()
	{
		buck_category_id = $(this).find(':selected').data('category_id');
	});
	
	
	$(document).on('change', '#mother_id', function()
	{
		
		mother_category_id = $(this).find(':selected').data('category_id');
		
		empty_all_fields();
		mother_id = $(this).val();
		var url_var ='get_breading_by_mother_id';
		var data = {};
		data['mother_id'] = mother_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
				  
				   if(result.length)
					   {
							
							work="E";
							breading_id = result[0].id;
							$('#mother_id').val(result[0].mother_id);
							$('#buck_id').val(result[0].buck_id);
							
							if(result[0].mated==1)
							{
								$("#mated").prop("checked", true);
								$('#mate_date').val((result[0].mate_date).substring(0, 10));
							}
							else
							{
								$("#mated").prop("checked", false);
								$( "#mate_date" ).val('');
							}
							
							if(result[0].confirmed==1)
							{
								$("#confirmed").prop("checked", true);
								$('#confirmed_date').val((result[0].confirmed_date).substring(0, 10));
							}
							else
							{
								$("#confirmed").prop("checked", false);
								$( "#confirmed_date" ).val('');
							}
							
							if(result[0].delivered==1)
							{
								$("#delivered").prop("checked", true);
								$('#delivery_date').val((result[0].delivery_date).substring(0, 10));
								$('#delivery_type').val(result[0].delivery_type);
								$('#gravida').val(result[0].gravida);
								
							}
							else
							{
								$("#delivered").prop("checked", false);
								$( "#delivery_date" ).val('');
								$('#gravida').val('');
								gravida = result[0].gravida;

							}
							
							$('#male_kids').val(result[0].male_kids);
							$('#female_kids').val(result[0].female_kids);
							$('#dead_kids').val(result[0].dead_kids);
							$('#total_kids').val(result[0].total_kids);
							
							if(result[0].end_entry==1)
							{
								$("#end_entry").prop("checked", true);
								$('#end_entry_date').val((result[0].end_entry_date).substring(0, 10));
							}
							else
							{
								$("#end_entry").prop("checked", false);
								$( "#end_entry_date" ).val('');
							}
							
							enable_deserved_fields();
					   }
				   else
					   {
							work="A";
						   alert('No breading exists at present.');
					   }
						

				}
			});
			
		
		
	});
	
	
	$(document).on('change', '#mated', function(event)
	{
		
		if($(this).is(":checked"))
		{
			$('#mate_date').val(pk_today);
			$("#mate_date").attr("disabled", false);
			$("#confirmed").attr("disabled", false);
			$("#lbl-confirmed").removeClass("disabled")
			$("#mated").removeClass("disabled");
			
		}
		else
		{
			$("#mate_date").attr("disabled", true);
			if($('#confirmed').is(":checked"))
			{
				alert("First you should uncheck 'Confirm'");
				 $(this).prop("checked", true);
				$("#mate_date").attr("disabled", false);
			}
			else
			{
				$('#mate_date').val('');
				$("#confirmed").attr("disabled", true);
				$("#lbl-confirmed").addClass("disabled")
				$("#confirmed_date").attr("disabled", true);
			}
		}
		
	});
	
	
	$(document).on('change', '#confirmed', function()
	{
		if($(this).is(":checked"))
		{
			$("#confirmed_date").attr("disabled", false);
			$('#confirmed_date').val(pk_today);
			$("#delivered").attr("disabled", false);
			$("#lbl-delivered").removeClass("disabled")
		}
		else
		{
			$("#confirmed_date").attr("disabled", true);
			
			if($('#delivered').is(":checked"))
			{
				alert("First you should uncheck 'Delivery Date'");
				 $(this).prop("checked", true);
				$("#confirmed_date").attr("disabled", false);
			}
			else
			{
				$('#confirmed_date').val('');
				$("#delivered").attr("disabled", true);
				$("#lbl-delivered").addClass("disabled")
				$("#delivery_date").attr("disabled", true);
			}
			
		}
		
	});
	
	
	$(document).on('change', '#delivered', function()
	{
		if($(this).is(":checked"))
		{
			
			$("#delivery_date").attr("disabled", false);
			$('#delivery_date').val(pk_today);
			$('#gravida').val(gravida);
			$("#lbl-gravida").removeClass("disabled");
			$('#delivery_type').attr("disabled", false);
			$("#lbl-delivery_type").removeClass("disabled");
			$("#lbl-male_kids").removeClass("disabled");
			$("#lbl-female_kids").removeClass("disabled");
			$("#lbl-dead_kids").removeClass("disabled");
			$('#dead_kids').attr("disabled", false);
			$("#lbl-total_kids").removeClass("disabled");
			$("#lbl-end_entry").removeClass("disabled");
			
			$("#end_entry").attr("disabled", false);
			//$("#end_entry_date").attr("disabled", false);
			
			$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '#kidsModal');
		}
		else
		{
			$("#delivery_date").attr("disabled", true);
			
			if($('#total_kids').val() > 0)
			{
				alert("Make kids total zero to Uncheck Delivery");
				 $(this).prop("checked", true);
				$("#delivery_date").attr("disabled", false);
			}
			else if($('#end_entry').is(":checked"))
			{
				alert("First you should uncheck 'End Entry'");
				 $(this).prop("checked", true);
			}
			else
			{
				$('#delivery_date').val('');
				$("#end_entry").attr("disabled", true);
				$("#end_entry_date").attr("disabled", true);
				$('#gravida').val('');
				$("#lbl-gravida").addClass("disabled");
				$('#delivery_type').attr("disabled", true);
				$("#lbl-delivery_type").addClass("disabled");
				$("#lbl-male_kids").addClass("disabled");
				$("#lbl-female_kids").addClass("disabled");
				$("#lbl-dead_kids").addClass("disabled");
				$('#dead_kids').attr("disabled", true);
				$("#lbl-total_kids").addClass("disabled");
				$("#lbl-end_entry").addClass("disabled");
				
				$('#btn-add-male-kids, #btn-add-female-kids').attr('data-target', '');
			}
			
		}
		
	});
	
	
	$(document).on('change', '#end_entry', function()
	{
		if($(this).is(":checked"))
		{
			$('#end_entry_date').val(pk_today);
			$("#end_entry_date").attr("disabled", false);
		}
		else
		{
			$('#end_entry_date').val('');
			$("#end_entry_date").attr("disabled", true);
		}
		
	});
	
	
	$(document).on('click', '#btn-add-male-kids', function()
	{
		empty_kid_fields();
		kid_gender = 1;
		$('#kids-modal-title').text('NEW MALE KIDS ENTRY');
		
		var url_var ='get_male_kids_by_breader_id';
		var data = {};
		data['breading_id'] = breading_id;
		
		$.ajax({
		   type:'post', 
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
					
					$('#kid_id').empty();
					$('#kid_id').append('<option value="0">' + 'New Kid' + '</option>');
					for (var i = 0; i <= result.length; i++) 
						{
							$('#kid_id').append('<option value="' + result[i].id + '">' + result[i].goat_name + '</option>');
						}				
						
				}
				
			});
			

	});
	
	
	$(document).on('click', '#btn-add-female-kids', function()
	{
		empty_kid_fields();
		kid_gender = 2;
		$('#kids-modal-title').text('NEW FEMALE KIDS ENTRY');
		
		var url_var ='get_female_kids_by_breader_id';
		var data = {};
		data['breading_id'] = breading_id;
		
		$.ajax({
		   type:'post', 
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
					
					$('#kid_id').empty();
					$('#kid_id').append('<option value="0">' + 'New Kid' + '</option>');
					for (var i = 0; i <= result.length; i++) 
						{
							$('#kid_id').append('<option value="' + result[i].id + '">' + result[i].goat_name + '</option>');
						}				
						
				}
				
			});
			
		
		
	});


	$(document).on('click', '#btn-delete-kid', function()
	{
		if(work_kid == 'E')

		{
	
			var url_var ='delete_kid_by_id';
			var data = {};
			data['id'] = kid_id;
			
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					   if (result == 0)
						   {
							   alert('Tag Number Already Exists.');
								
						   }
						else
							{
								$('#male_kids').val(result[0].male_kids);
								$('#female_kids').val(result[0].female_kids);
								$('#dead_kids').val(result[0].dead_kids);
								$('#total_kids').val(result[0].total_kids);
								alert('Updated.');
							}
					}
				});
			
		}

	});


	$(document).on('click', '#btn-update-kid', function()
	{
		if(work_kid == 'A')
		{			
			
			if(!$('#tag_no').val())
			{
				alert('Please enter Tag No.');
			}
			else
			{
				if(!$('#goat_name').val())
				{
					alert('Please enter Name.');
				}
				else
				{
					insert_kid();
				}
			}
			
			
		}
		else if(work_kid == 'E')

		{
			/*
			clearInterval(timerVar);
			$('#p-edit-mode').fadeOut();
			*/
			
			if(!$('#tag_no').val())
			{
				alert('Please enter Tag No.');
			}
			else
			{
				if(!$('#goat_name').val())
				{
					alert('Please enter Name.');
				}
				else
				{
					update_kid();
				}
			}
			
		}
		
	});
	
	
	
	$(document).on('click', '#btn-save', function()
	{
				
		
		if(work == 'A')
		{
			
			if($('#mother_id').val()==0)
			{
				alert('Please select the Mother');
			}
			else
			{
				mother_id = $('#mother_id').val();
				
				if($('#buck_id').val()==0)
				{
					alert('Please select the Buck');
				}
				else
				{
					buck_id = $('#buck_id').val();
					if($('#mated').is(":checked"))
					{
						mated = 1;
						mate_date = $('#mate_date').val();
						insert_breading();
					}
					else
					{
						alert('Please click and choose Mating Date.');
					}
					
				}
					
				
			}
		}	
		else if(work == 'E')
		{
			
			if($('#mother_id').val()==0)
			{
				alert('Please select the Mother');
			}
			else
			{
				mother_id = $('#mother_id').val();
				
				if($('#buck_id').val()==0)
				{
					alert('Please select the Buck');
				}
				else
				{
					buck_id = $('#buck_id').val();
					if($('#mated').is(":checked"))
					{
						mated = 1;
						mate_date = $('#mate_date').val();
						update_breading();
					}
					else
					{
						alert('Please click and choose Mating Date.');
					}
					
				}
					
				
			}
		}	
	
	});
	
	
	$(document).on('click', '#a-weighment', function(e)
	{
		if(mother_id)
		{
			$('#h-ledger').text('WEIGHMENT LEDGER - TAG.NO. ' + $('#mother_id :selected').text());
					
			var url_var ='get_weighment_ledger_by_goat_id';
			var data = {};
			data['goat_id'] = mother_id;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result_data)
				   {
					   
						$("#ledger-table tbody").empty();
						
					   for (i = 0; i < result_data.length; i++) 
					   {
							dt = PKDateDdMmYyyy((result_data[i].wgh_date).substring(0, 10));
							diff_days =0;
							diff_weight = 0;
							row_color = 'red';
							font_weight = '';
							
							if(i != 0)
							{
								
								diff_days = PKDateDiff((result_data[i-1].wgh_date), (result_data[i].wgh_date));
								
								diff_weight = result_data[i].goat_weight - result_data[i-1].goat_weight;
								
								if( diff_weight >= 1.5)
								{
									if( diff_days <= 31 )
									{
										row_color = 'green';
										font_weight = 'bold';
									}
									else
									{
										row_color = 'red';
										font_weight = 'normal';
									}
								}
								else
								{
									row_color = 'red';
									font_weight = 'normal';
								}
								
							}

						   
							 var tr_ledger = '<tr style="color:' + row_color + '; cursor:pointer; font-weight:' + font_weight + ';">' +
								'<td class="text-center" style="cursor:pointer">' + ( i+1) + '</td>' +
								'<td class="text-center" style="color:' + row_color + '; cursor:pointer" value="">' + dt + '</td>'+ 
								'<td class="text-center" style="color:' + row_color + '; cursor:pointer" value="">' + result_data[i].goat_weight + '</td>' +
								'<td class="text-center" style="color:' + row_color + '; cursor:pointer" value="">' + diff_days + '</td>' +
								'<td class="text-center" style="color:' + row_color + '; cursor:pointer; font-weight:bold;" value="">' + diff_weight.toFixed(2) + '</td>' +
							'</tr>';
						   
						   $("#ledger-table tbody").append(tr_ledger);
						   
					   }
					   
					   
								
					}
				});
		}
				
	});
		
	
	function insert_breading()
	{

		var url_var ='insert_breading';
		var data = {};
		
		data['mother_id'] = mother_id;
		data['buck_id'] = buck_id;
		data['mated'] = mated;
		data['mate_date'] = mate_date;
		
		if($('#confirmed').is(":checked"))
		{
			data['confirmed'] = 1;
			data['confirmed_date'] = $('#confirmed_date').val();
		}
		else
		{
			data['confirmed'] = confirmed;
			data['confirmed_date'] = confirmed_date;
		}
		
		if($('#delivered').is(":checked"))
		{
			data['delivered'] = 1;
			data['delivery_date'] = $('#delivery_date').val();
			data['delivery_type'] = $('#delivery_type').val();
			data['gravida'] = $('#gravida').val();
			data['male_kids'] = $('#male_kids').val();
			data['female_kids'] = $('#female_kids').val();
			data['dead_kids'] = $('#dead_kids').val();
			data['total_kids'] = $('#total_kids').val();
		}
		else
		{
			data['delivered'] = delivered;
			data['delivery_date'] = delivery_date;
			data['delivery_type'] = delivery_type;
			data['gravida'] = gravida;
			data['male_kids'] = male_kids;
			data['female_kids'] = female_kids;
			data['dead_kids'] = dead_kids;
			data['total_kids'] = total_kids;
		}
		
		if($('#end_entry').is(":checked"))
		{
			data['end_entry'] = 1;
			data['end_entry_date'] = $('#end_entry_date').val();
		}
		else
		{
			data['end_entry'] = end_entry;
			data['end_entry_date'] = end_entry_date;
		}
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if (result_data == 1)
					   {
						   
							alert('Updated.');
					   }
					else
						{
							alert('Tag Number Already Exists.');
						}
				}
			});
			
	}


	function update_breading()
	{

		var url_var ='update_breading';
		var data = {};
		
		data['mother_id'] = mother_id;
		data['buck_id'] = buck_id;
		data['mated'] = mated;
		data['mate_date'] = mate_date;
		
		if($('#confirmed').is(":checked"))
		{
			data['confirmed'] = 1;
			data['confirmed_date'] = $('#confirmed_date').val();
		}
		else
		{
			data['confirmed'] = confirmed;
			data['confirmed_date'] = confirmed_date;
		}
		
		if($('#delivered').is(":checked"))
		{
			data['delivered'] = 1;
			data['delivery_date'] = $('#delivery_date').val();
			data['delivery_type'] = $('#delivery_type').val();
			data['gravida'] = $('#gravida').val();
			data['male_kids'] = $('#male_kids').val();
			data['female_kids'] = $('#female_kids').val();
			data['dead_kids'] = $('#dead_kids').val();
			data['total_kids'] = $('#total_kids').val();
		}
		else
		{
			data['delivered'] = delivered;
			data['delivery_date'] = delivery_date;
			data['delivery_type'] = delivery_type;
			data['gravida'] = gravida;
			data['male_kids'] = male_kids;
			data['female_kids'] = female_kids;
			data['dead_kids'] = dead_kids;
			data['total_kids'] = total_kids;
		}
		
		if($('#end_entry').is(":checked"))
		{
			data['end_entry'] = 1;
			data['end_entry_date'] = $('#end_entry_date').val();
		}
		else
		{
			data['end_entry'] = end_entry;
			data['end_entry_date'] = end_entry_date;
		}
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					alert('Updated.');
				}
			});
			
	}
	
	
	
	$(document).on('click', '.td-edit', function()
	{
		work="E";
		
		edit_id = $(this).attr('value');
		var url_var ='get_goat_by_id';
		var data = {};
		data['id'] = edit_id;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
				   if(result[0].inward_type ==1)
					   {
						    $('#inward_type_deli').attr('checked', false);
							$('#inward_type_prh').attr('checked', true);
					   }
				   else if(result[0].inward_type ==2)
					   {
							$('#inward_type_prh').attr('checked', false);
							$('#inward_type_deli').attr('checked', true);
					   }
						
					$('#prh_date').val((result[0].prh_date).substring(0, 10));
					$('#dob_date').val((result[0].dob_date).substring(0, 10));
					$('#srl_no').val(result[0].srl_no);
					$('#tag_no').val(result[0].tag_no);
					$('#gender').val(result[0].gender);
					$('#goat_name').val(result[0].goat_name);
					$('#block_id').val(result[0].block_id);
					$('#mother_id').val(result[0].mother_id);
					$('#buck_id').val(result[0].buck_id);
					$('#color_id').val(result[0].color_id);
					$('#goat_cost').val(result[0].goat_cost);
					
					

				}
			});
			
		
		
	});
	
	
	function insert_kid()
	{
		alert(mother_category_id);
		alert(buck_category_id);
 				
		var url_var ='insert_kid';
		var data = {};
		data['breading_id'] = breading_id;
		data['dob_date'] = $('#delivery_date').val();
		data['tag_no'] = $('#tag_no').val();
		data['gender'] = kid_gender;
		data['goat_name'] = $('#goat_name').val();
		data['block_id'] = $('#block_id option:selected').val();
		data['mother_id'] = $('#mother_id option:selected').val();
		data['buck_id'] = $('#buck_id option:selected').val();
		data['color_id'] = $('#color_id option:selected').val();
		
		if(mother_category_id == buck_category_id)
		{
				data['category_id'] = mother_category_id;
		}
		else
		{
				data['category_id'] = 3;
		}
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
				   if (result == 0)
					   {
						   alert('Tag Number Already Exists.');
							
					   }
					else
						{
							$('#male_kids').val(result[0].male_kids);
							$('#female_kids').val(result[0].female_kids);
							$('#dead_kids').val(result[0].dead_kids);
							$('#total_kids').val(result[0].total_kids);
							alert('Updated.');
						}
				}
			});
			
	}
	


	function update_kid()
	{
		
		var url_var ='update_kid';
		var data = {};
		data['id'] = kid_id;
		data['dob_date'] = $('#delivery_date').val();
		data['tag_no'] = $('#tag_no').val();
		data['gender'] = kid_gender;
		data['goat_name'] = $('#goat_name').val();
		data['block_id'] = $('#block_id option:selected').val();
		data['mother_id'] = $('#mother_id option:selected').val();
		data['buck_id'] = $('#buck_id option:selected').val();
		data['color_id'] = $('#color_id option:selected').val();
		
		if(mother_category_id == buck_category_id)
		{
				data['category_id'] = mother_category_id;
		}
		else
		{
				data['category_id'] = 3;
		}
		
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if (result_data == 1)
					   {
						   
							alert('Updated.');
					   }
					else
						{
							alert('Tag Number Already Exists.');
						}
				}
			});
			
	}
	
	function empty_kid_fields() 
	{
		$('#tag_no').val('');
		$('#goat_name').val('');
		$('#block_id').val(0);
		$('#color_id').val(0);
	}	
	
	
	$(document).on('change', '#kid_id', function()
	{
		kid_id = $(this).val();
		
		if( kid_id ==0 )   
		{
			work_kid = "A";
			$('#btn-delete-kid').css('display', 'none');
			empty_kid_fields();
		}
		else
		{
			work_kid = "E";
			$('#btn-delete-kid').css('display', 'block');
			var url_var ='get_kid_by_id';
			var data = {};
			data['id'] = kid_id;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					  
					   if(result.length)
						   {
								$('#tag_no').val(result[0].tag_no);
								$('#goat_name').val(result[0].goat_name);
								$('#block_id').val(result[0].block_id);
								$('#color_id').val(result[0].color_id);
						   }
						   
				   }
			});
		}
		
	});