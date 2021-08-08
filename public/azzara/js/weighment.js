    
	$(document).ready(function()
	{
		timerVar = '';
		
		$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		$('.wgh_date').val(pk_today);
		

		
	});
	
	$(document).on('click', '.paginate_button', function()
	{
		$('.wgh_date').val(pk_today);
	});
	
	$(document).on('click', '#entry-table th', function()
	{
		$('.wgh_date').val(pk_today);
	});
	
	
	$(document).on('click', '.td-save', function()
	{
		if(confirm('Do you Save this Weight ?'))
			{

				goat_id = $(this).attr('value');
				wgh_date = $('#date_' + goat_id).val();
				goat_weight = $('#goat_weight_' + goat_id).val();
				
				update_weighment();
			}
	});
	
	
	$(document).on('keypress', '.goat_weight', function(e) {
		if(e.which == 13) {
			if(confirm('Do you Save this Weight ?'))
			{
				goat_id = $(this).data('goat_id');
				wgh_date = $('#date_' + goat_id).val();
				goat_weight = $('#goat_weight_' + goat_id).val();
				
				update_weighment();
			}
		}
	});	
	
	
	$(document).on('change', '.wgh_date', function()
	{

		goat_id = $(this).data('goat_id');
		wgh_date = $('#date_' + goat_id).val();
		
		var url_var ='get_weighment_by_date';
		var data = {};
		data['goat_id'] = goat_id;
		data['wgh_date'] = wgh_date;
		
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
					if(result_data.length)	   
					{
						$('#goat_weight_' + goat_id).val(result_data[0].goat_weight);
					}
					else
					{
						$('#goat_weight_' + goat_id).val(0);
					}
							
				}
			});
				
				
	});
	
	
	$(document).on('click', '.tr-goat', function()
	{

		goat_id = $(this).attr('value');
		
		$('#h-ledger').text('WEIGHMENT LEDGER - TAG.NO. ' + $('#tag_no_' + goat_id).html());
				
		var url_var ='get_weighment_ledger_by_goat_id';
		var data = {};
		data['goat_id'] = goat_id;
		
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

				
	});
	
	
	
	
	function blink_text() 
	{
		$('#p-edit-mode').fadeOut(500);
		$('#p-edit-mode').fadeIn(500);
	}	


	
	
	function update_weighment()
	{

		var url_var ='update_weighment';
		var data = {};
		data['goat_id'] = goat_id;
		data['wgh_date'] = wgh_date;
		data['goat_weight'] = goat_weight;
		
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


