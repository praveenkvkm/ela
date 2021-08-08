    
	$(document).ready(function()
	{
		work = "A";
			
		timerVar = '';
		
		all_blocks = [];
		
		selected_goat_id =0;
					
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
		$('#block_name').val('');
	}	
	 
	
	$(document).on('click', '#btn-add-blocks', function()
	{
					work = "A";

		empty_kid_fields();
		$('#kids-modal-title').text('NEW BLOCK ENTRY');
		
		var url_var ='get_all_blocks';
		var data = {};
		
		$.ajax({
		   type:'post', 
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
					
					$('#block_id').empty();
					$('#block_id').append('<option value="0">' + 'New Block' + '</option>');
					for (var i = 0; i <= result.length; i++) 
						{
							$('#block_id').append('<option value="' + result[i].id + '">' + result[i].block_name + '</option>');
						}				
						
				}
				
			});
			

	});
	
	
	$(document).on('change', '#block_id', function()
	{
		block_id = $(this).val();
		
		if( block_id ==0 )   
		{
			work = "A";
			$('#btn-delete-block').css('display', 'none');
			empty_kid_fields();
		}
		else
		{
			work = "E";
			$('#btn-delete-block').css('display', 'block');
			var url_var ='get_block_by_id';
			var data = {};
			data['id'] = block_id;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					  
					   if(result.length)
						   {
								$('#block_name').val(result[0].block_name);
						   }
						   
				   }
			});
		}
		
	});	
	
	
	$(document).on('click', '#btn-update-block', function()
	{
		if(work == 'A')
		{			
			
			if(!$('#block_name').val())
			{
				alert('Please enter Block Name.');
			}
			else
			{
					insert_block();
			}
			
			
		}
		else if(work == 'E')
		{
			/*
			clearInterval(timerVar);
			$('#p-edit-mode').fadeOut();
			*/
			if(!$('#block_name').val())
			{
				alert('Please enter Block Name.');
			}
			else
			{
					update_block();
			}
			
			
		}
		
	});
	
	


	$(document).on('click', '#btn-delete-block', function()
	{
		if(work == 'E')

		{
	
			var url_var ='delete_block_by_id';
			var data = {};
			data['id'] = block_id;
			
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					   if (result == 0)
						   {
							   alert('Goats Exists in this Block.');
								
						   }
						else
							{
								alert('Deleted.');
							}
					}
				});
			
		}

	});


	$(document).on('click', '#btn-switch-to-addition', function()
	{
		
		var url_var ='get_all_blocks';
		var data = {};
		
		$.ajax({
		   type:'post', 
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result)
			   {
					all_blocks = result;
						//alert(all_blocks[0].id);
				}
				
			});
			
			
			
			

	});

		
	
	function insert_block()
	{

		var url_var ='insert_block';
		var data = {};
		
		data['block_name'] = $('#block_name').val();
						
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   if (result_data == 1)
					   {
						   
							alert('Block Added.');
					   }
					else
						{
							alert('Block Name Already Exists.');
						}
				}
			});
			
	}


	function update_block()
	{

		var url_var ='update_block';
		var data = {};
		
		data['block_name'] = $('#block_name').val();
		
		data['id'] = block_id;
						
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
							alert('Block Name Already Exists.');
						}
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
	
	
	$(document).on('focus', '.selected_block_id',  function () 
	{
		previous = this.value;
		//alert(previous);
	}).on('change', '.selected_block_id', function(e) 
	{
			selected_block_id = $(this).val();
			selected_goat_id = $(this).data('goat_id');
			
		if(confirm('Are you sure to Save Block Change ?'))
		{
		
			var url_var ='update_block_change';
			var data = {};
			data['block_id'] = selected_block_id;
			data['goat_id'] = selected_goat_id;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					  alert('Updated.');
						   
				   }
			});
		}
		else
		{
			 
			$('#selected_block_' + selected_goat_id).empty();
			
			for (var i = 0; i < all_blocks.length; i++) 
				{
					$('#selected_block_' + selected_goat_id).append('<option value="' + all_blocks[i].id + '">' + all_blocks[i].block_name + '</option>');
				}	

				$(this).find('option[value="'+ previous  +'"]').attr("selected",true);
			 
		}
		
		
		
	});	
	
	/*
	$(document).on('change', '.selected_block_id', function(e)
	{
		if(confirm('Are you sure to Save Block Change ?'))
		{
			selected_block_id = $(this).val();
			selected_goat_id = $(this).data('goat_id');
		
			var url_var ='update_block_change';
			var data = {};
			data['block_id'] = selected_block_id;
			data['goat_id'] = selected_goat_id;
			
			$.ajax({
			   type:'post',
			   url: url_var,
			   data: data,
			   async:false,
			   success:function(result)
				   {
					  alert('Updated.');
						   
				   }
			});
		}
		else
		{
			$(this).val()
			event.preventDefault();
		}
	});	
*/
