$(document).ready(function(){	

	var incomeRecords = $('#incomeListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"income_action.php",
			type:"POST",
			data:{action:'listIncome'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addIncome').click(function(){
		$('#incomeModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#incomeModal").on("shown.bs.modal", function () {
			$('#incomeForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Income");					
			$('#action').val('addIncome');
			$('#save').val('Save');
		});
	});		
	
	$("#incomeListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getIncomeDetails';
		$.ajax({
			url:'income_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#incomeModal").on("shown.bs.modal", function () { 
					$('#incomeForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#id').val(item['id']);						
						$('#income_cat').val(item['category_id']);	
						$('#amount').val(item['amount']);
						$('#income_date').val(item['date']);						
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Income");
					$('#action').val('updateIncome');
					$('#save').val('Save');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#incomeModal").on('submit','#incomeForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"income_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#incomeForm')[0].reset();
				$('#incomeModal').modal('hide');				
				$('#save').attr('disabled', false);
				incomeRecords.ajax.reload();
			}
		})
	});		

	$("#incomeListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteIncome";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"income_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					incomeRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});