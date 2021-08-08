@include('layouts.ela-header')

<body>
@include('admin.layouts.ela-admin-topbar')
<script>
$(document).ready(function(){
	
	student_id = '{{$id}}' ;

	
	$(function() {
			$.ajaxSetup({
				headers: 
				{
				  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
		
				
		$(document).on('change', '#student_id', function() 
		{
			
				student_id = $(this).val();
				get_student_full_detail_by_id();
				
		});	
		
			$('#student_id').val(student_id);
			$('#student_id').trigger('change');

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
		
		
		
	function get_student_full_detail_by_id()
	{
		var CSRF_TOKEN = '{{csrf_token()}}';
		
		var	url_var = APP_URL + '/get_student_full_detail_by_id';

		var data = {};
		data['_token'] = CSRF_TOKEN;
		data['student_id'] = student_id;
				
		$.ajax({
		   type:'post',
		   url: url_var,
		   data: data,
		   async:false,
		   success:function(result_data)
			   {
				   fill_student_edit_detail(result_data);
				   				    
				}
			});
			
	}
		
		
	function fill_student_edit_detail(selected_student)
	{	
	//alert(selected_student[0].school_sub_district);
		 $('#stud_name').text(selected_student[0].first_name);
		 $('#stud_reg_number').text(selected_student[0].stud_reg_number);
		 $('#stud_grade').text(selected_student[0].stud_grade);
		 $('#gender').text(selected_student[0].gender);
		 $('#stud_dob').text(PKDateDdMmYyyy((selected_student[0].stud_dob).substring(0, 10)));
		 $('#standard').text(selected_student[0].standard);
		 $('#medium').text(selected_student[0].medium);
		 $('#school_name').text(selected_student[0].school_name);
		 $('#school_address').text(selected_student[0].school_address);
		 $('#school_manage_category').text(selected_student[0].school_manage_category);
		 
		 $('#school_sub_district').text(selected_student[0].school_sub_district);
		 $('#school_edu_district').text(selected_student[0].school_edu_district);
		 $('#school_district').text(selected_student[0].school_district);
		
		 $('#father_name').text(selected_student[0].father_name);
		 $('#father_phone').text(selected_student[0].father_phone);
		 $('#father_emp_ctg').text(selected_student[0].guardian_employer);
		 $('#mother_name').text(selected_student[0].mother_name);
		 $('#mother_phone').text(selected_student[0].mother_phone);
		 $('#edit_guardian_name').text(selected_student[0].guardian_name);
		 $('#edit_guardian_phone').text(selected_student[0].guardian_phone);
		 
		 $('#house_address').text(selected_student[0].house_address);
		 $('#house_panchayath').text(selected_student[0].house_panchayath);
		 $('#house_block').text(selected_student[0].house_block);
		 $('#house_district').text(selected_student[0].house_district);
		 $('#house_pin').text(selected_student[0].house_pin);
		 
		 $('#stud_blood_group').text(selected_student[0].stud_blood_group);
		 $('#stud_height').text(selected_student[0].stud_height);
		 $('#stud_weight').text(selected_student[0].stud_weight);
		 $('#stud_physical_status').text(selected_student[0].stud_physical_status);
		 $('#stud_disease').text(selected_student[0].stud_disease);
		 $('#stud_disease_details').text(selected_student[0].stud_disease_details);
		 $('#whatsapp_1').text(selected_student[0].whatsapp_1);
		 $('#whatsapp_2').text(selected_student[0].whatsapp_2);
		 $('#email_id').text(selected_student[0].email_id);
		 
		  
	}
		
		
});
</script>
<?php
$cc = app()->make('App\Http\Controllers\CommonController');
$students =  app()->call([$cc, 'get_approved_students']);
?>
    <main class="main students-login pt-60 pb-60" id="target">
        <!----------body content place here----------->
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <select class="form-control" id="student_id">
							@foreach($students as $key=>$student) 
							  <option value="{{$student->ela_user_id}}">{{$student->first_name . ' ' . $student->last_name}}</option>
							@endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2 ml-auto">
                    <a id="a-print" class="dropdown-item btn btn-secondary text-center" onclick="takeScreenShot('page-print',  'student-detail')" href="#"><i class="fa fa-print" aria-hidden="true"></i> Pdf</a>
                </div>
            </div>
            
        </div>

        <div id="page-print" class="container" style="max-width: 794px;width: 100%; padding-right:100px;">
            <h1 class="pb-20">Student <span style="color:red">Details</span></h1>
            <table class="table table-striped " style="word-wrap: break-word; table-layout:fixed; width: 100%;">
                <tbody>
                    <thead>
                        <tr>
                            <th scope="col" ><b>Student Name :</b></th>
                            <th scope="col" colspan="3" id="stud_name">Anandhu</th>
                        </tr>
                    </thead>
                    <tr>
                        <td style="color: black!important;"><b>Registration No. :</b></td>
                        <td style="color: black!important;" id="stud_reg_number" >St111</td>
                        <td style="color: black!important;"><b>ELA School Grade :</b></td>
                        <td style="color: black!important;" id="stud_grade">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Gender :</b></td>
                        <td id="gender">Male</td>
                        <td><b>Date of Birth :</b></td>
                        <td id="stud_dob">23-12-2020</td>
                    </tr>
                    <tr>
                        <td><b>Class :</b></td>
                        <td id="standard">3</td>
                        <td><b>Medium of instruction :</b></td>
                        <td id="medium">Malayalam</td>
                    </tr>
                    <tr>
                        <td><b>Syllabus :</b></td>
                        <td id="medium">State</td>
                        <td><b>Name of the school :</b></td>
                        <td id="school_name">JMHS</td>
                    </tr>
                    <tr>
                        <td><b>School Address :</b></td>
                        <td id="school_address">St111</td>
                        <td><b>School Management :</b></td>
                        <td id="school_manage_category">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>School Sub. District :</b></td>
                        <td id="school_sub_district">St111</td>
                        <td><b>School Edl. District :</b></td>
                        <td id="school_edu_district">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>School Rev. District :</b></td>
                        <td id="school_district">St111</td>
                        <td><b>Name of Father :</b></td>
                        <td id="father_name">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Father Phn No :</b></td>
                        <td id="father_phone">St111</td>
                        <td><b>Name of Mother :</b></td>
                        <td id="mother_name">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Mother Phn No :</b></td>
                        <td id="mother_phone">+91 9567835679</td>
                        <td><b>Name of Guardian :</b></td>
                        <td id="guardian_name">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Employer (Father) :</b></td>
                        <td id="father_emp_ctg">St111</td>
                        <td><b>Home Address :</b></td>
                        <td id="house_address">Home ,Puthuppaly <br> Kottayam</td>
                    </tr>
                    <tr>
                        <td><b>Panchayath :</b></td>
                        <td id="house_panchayath">St111</td>
                        <td><b>Block :</b></td>
                        <td id="house_block">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>District :</b></td>
                        <td id="house_district">St111</td>
                        <td><b>PIN Code :</b></td>
                        <td id="house_pin">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Blood Group :</b></td>
                        <td id="stud_blood_group">St111</td>
                        <td><b>Height ( CMs ) :</b></td>
                        <td id="stud_height">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Weight ( Kg ) :</b></td>
                        <td id="stud_weight">St111</td>
                        <td><b>Physical Status :</b></td>
                        <td id="stud_physical_status">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Have any Chronic Diseases :</b></td>
                        <td id="stud_disease">St111</td>
                        <td><b>Disease Details :</b></td>
                        <td id="stud_disease_details">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>WhatsApp 1 :</b></td>
                        <td id="whatsapp_1">St111</td>
                        <td><b>WhatsApp 2 :</b></td>
                        <td id="whatsapp_2">4ELA</td>
                    </tr>
                    <tr>
                        <td><b>Email ID :</b></td>
                        <td id="email_id">St111</td>
                        <td></td>
                        <td id=""></td>
                    </tr>
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