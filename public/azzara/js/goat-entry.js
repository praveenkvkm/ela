    
	$(document).ready(function()
	{
		inward_type = 1;
		work = "A";
		edit_id = 0;
		timerVar = '';
		$('#tag_no').focus();
		
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		$('#prh_date').val(pk_today);
		$('#dob_date').val(pk_today);
		

		
	});
	
	
	function blink_text() 
	{
		$('#p-edit-mode').fadeOut(500);
		$('#p-edit-mode').fadeIn(500);
	}	


	$(document).on('click', '#btn-save', function()
	{
		if(work == 'A')
		{
			/*
			if($('#inward_type_prh').is(":checked"))
			{
				inward_type = 1;
			}
			else
			{
				inward_type = 2;
			}
			*/
			
			if(!$('#tag_no').val())
			{
				alert('Please enter Tag No.');
			}
			else
			{
				if(confirm("Are you sure to add this goat ?"))
				{
					insert_goat();
				}
			}
		}
		else
		{
			
			/*
			if($('#inward_type_prh').is(":checked"))
			{
				inward_type = 1;
			}
			else
			{
				inward_type = 2;
			}
			*/
			
			if(!$('#tag_no').val())
			{
				alert('Please enter Tag No.');
			}
			else
			{
				if(confirm("Are you sure to Save ?"))
				{
					update_goat();
				}
				
			}
			
		}
			
	});
	
	/*
	$(document).on('click', '#btn-edit', function()
	{
		var url_var ='get_all_goats';
		var data = {};
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   {
					   
						$("#goats-table tbody").empty();
						tr_ledger ='';
						
					   for (i = 0; i < result_data.length; i++)
					   {
						   							
							var tr_ledger = '<tr>' +
									'<td style="display:none"></td>'+
									'<td>' + ( i+1) + '</td>'+
									'<td>' + result_data[i].tag_no + '</td>'+
									'<td>' + result_data[i].goat_name + '</td>'+
									'<td>' + result_data[i].block_name + '</td>'+
									'<td class="text-center td-edit" style="color:#40d040; cursor:pointer" value="' + result_data[i].id + '"  data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></td>'+
									'<td class="text-center td-delete" style="color:red; cursor:pointer" value="' + result_data[i].id + '"><i class="fas fa-times-circle"></i></td>'+
								'</tr>';
							
						   
						   $("#goats-table tbody").append(tr_ledger);

					   }
					   
						      $('#goats-table').DataTable();
								
					}
				}
			});
			
	});
	*/
	
	$(document).on('click', '#btn-switch-to-addition', function()
	{
		set_add_mode();
	});
	
	
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
				   /*
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
					*/
					
					
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
					$('#gravida').val(result[0].gravida);
					$('#category_id').val(result[0].category_id);
				}
			});
			
		$('#btn-switch-to-addition').show();
		timerVar = setInterval(blink_text, 1000);
		
	});
	
	
	function empty_all_fields() 
	{
		$('#prh_date').val(pk_today);
		$('#dob_date').val(pk_today);
		$('#tag_no').val('');
		$('#gender').val(1);
		$( "#goat_name" ).val('');
		$('#block_id').val(0);
		$('#mother_id').val(0);
		$('#buck_id').val(0);
		$('#color_id').val(0);
		$('#goat_cost').val('');
		$('#gravida').val('');
		$('#category_id').val(0);

	}	
	
	
	function set_next_srl_no()
	{

		var url_var ='get_next_srl_no';
		var data = {};
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					$('#srl_no').val(result_data);
				}
			});
			
	}

	
	function insert_goat()
	{

		var url_var ='insert_goat';
		var data = {};
		data['inward_type'] = inward_type;
		data['prh_date'] = $('#prh_date').val();
		data['dob_date'] = $('#dob_date').val();
		data['srl_no'] = $('#srl_no').val();
		data['tag_no'] = $('#tag_no').val();
		data['gender'] = $('#gender option:selected').val();
		data['goat_name'] = $('#goat_name').val();
		data['block_id'] = $('#block_id option:selected').val();
		data['mother_id'] = $('#mother_id option:selected').val();
		data['buck_id'] = $('#buck_id option:selected').val();
		data['color_id'] = $('#color_id option:selected').val();
		data['goat_cost'] = $('#goat_cost').val();
		data['gravida'] = $('#gravida').val();
		data['category_id'] = $('#category_id option:selected').val();
		
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
							location.reload(true);
							//set_add_mode();
					   }
					else
						{
							alert('Tag Number Already Exists.');
						}
				}
			});
			
	}


	function update_goat()
	{

		var url_var ='update_goat';
		var data = {};
		data['id'] = edit_id;
		data['inward_type'] = inward_type;
		data['prh_date'] = $('#prh_date').val();
		data['dob_date'] = $('#dob_date').val();
		data['srl_no'] = $('#srl_no').val();
		data['tag_no'] = $('#tag_no').val();
		data['gender'] = $('#gender option:selected').val();
		data['goat_name'] = $('#goat_name').val();
		data['block_id'] = $('#block_id option:selected').val();
		data['mother_id'] = $('#mother_id option:selected').val();
		data['buck_id'] = $('#buck_id option:selected').val();
		data['color_id'] = $('#color_id option:selected').val();
		data['goat_cost'] = $('#goat_cost').val();
		data['gravida'] = $('#gravida').val();
		data['category_id'] = $('#category_id option:selected').val();
		
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
							location.reload(true);
							//set_add_mode();
					   }
					else
						{
							alert('Tag Number Already Exists.');
						}
				}
			});
			
	}
	
	function set_add_mode()
	{
		work="A";
		empty_all_fields();
		$('#btn-switch-to-addition').hide();
		set_next_srl_no();
		
		clearInterval(timerVar);
		$('#p-edit-mode').fadeOut();
		
		$('#tag_no').focus();
		
	}
