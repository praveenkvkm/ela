@include('layouts.ela-header')

<body>
@include('admin.layouts.ela-admin-topbar')
<script>
$(document).ready(function(){
	stud_grade_id = 0;
	
	$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
		
		$(document).on('change', '#stud_grade_id', function() 
		{
			
				stud_grade_id = $(this).val();
				get_students_by_stud_grade_id();
				
		});	
		
		
		
		window.takeScreenShot = function(elm_id, file_name) 
		{
			html2canvas(document.getElementById(elm_id), 
			{
				onrendered: function (canvas) 
				{
					//document.body.appendChild(canvas);
					//var doc = new jsPDF("p", "mm", "a4");
					var imgData = canvas.toDataURL('image/png');
					//console.log('Report Image URL: '+imgData);
					//var doc = new jsPDF('p', 'mm', [420, 500]);
					var doc = new jsPDF('p', 'mm', 'a4');
					doc.addImage(imgData, 'PNG', 10, 10);
					doc.save(file_name +'.pdf');
				}
			});
		}
		
		
	function get_students_by_stud_grade_id()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_students_by_stud_grade_id';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['stud_grade_id'] = stud_grade_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   
					cnt = result_data.length;
					
					$('#table-students tbody').empty();
					
					for( i = 0; i< cnt; i++ ) 
					{
						
										
                    row_string = '<tr >'+
                        '<td style="color: black!important;">'+ (i+1) + '</td>'+
                        '<td style="color: black!important;">' + result_data[i].stud_reg_number + '</td>'+
                        '<td style="color: black!important;">' + result_data[i].first_name + ' ' + result_data[i].last_name + '</td>'+
                        '<td style="color: black!important;">' + result_data[i].stud_grade + '</td>'+
                    '</tr>';
										
						$('#table-students tbody').append(row_string);
						
						
					  
				   }
				   
				   
				   
				    
				}
			});
			
	}
		
		
		
});
</script>
<style>
</style>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$students =  app()->call([$cc, 'get_approved_students']);
$stud_grades =  app()->call([$cc, 'get_stud_grades']);
?>
    <main class="main students-login pt-60 pb-60" id="target">

        <!----------body content place here----------->
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <select class="form-control" id="stud_grade_id">
                          <option value="0">Sort</option>
							@foreach($stud_grades as $key=>$stud_grade) 
							  <option value="{{$stud_grade->id}}">{{$stud_grade->stud_grade}}</option>
							@endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2 ml-auto">
                    <a id="a-print" class="dropdown-item btn btn-secondary text-center" onclick="takeScreenShot('page-print',  'student-list')" href="#"><i class="fa fa-print" aria-hidden="true"></i> Pdf</a>
                </div>
            </div>
            
        </div>
        
        <div id="page-print" class="container" style="max-width: 794px;width: 100%; padding-right:100px;">
            <h1 class="pb-20">Students <span style="color:red">List</span></h1>
            <table id="table-students" class="table table-striped " style="word-wrap: break-word; table-layout:fixed; width: 100%;">
                    <thead> 
                        <tr>
                            <th>Srl.No</th>
                            <th>Register No.</th>
                            <th>Student Name</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                <tbody>
					@foreach($students as $key=>$student) 
                    <tr >
                        <td style="color: black!important;">{{$key + 1}}</td>
                        <td style="color: black!important;">{{$student->stud_reg_number }}</td>
                        <td style="color: black!important;">{{$student->first_name . ' ' . $student->last_name }}</td>
                        <td style="color: black!important;">{{$student->stud_grade }}</td>
                    </tr>
					@endforeach
                </tbody>
            </table>

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