$(document).ready(function(){	

	var expenseRecords = $('#expenseListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"expense_action.php",
			type:"POST",
			data:{action:'listExpense'},
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
	
	$('#addExpense').click(function(){
		$('#expenseModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#expenseModal").on("shown.bs.modal", function () {
			$('#expenseForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Add expense");					
			$('#action').val('addExpense');
			$('#save').val('Save');
		});
	});		
	
	$("#expenseListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getExpenseDetails';
		$.ajax({
			url:'expense_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#expenseModal").on("shown.bs.modal", function () { 
					$('#expenseForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#id').val(item['id']);						
						$('#expense_cat').val(item['category_id']);	
						$('#amount').val(item['amount']);
						$('#expense_date').val(item['date']);						
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Expense");
					$('#action').val('updateExpense');
					$('#save').val('Save');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#expenseModal").on('submit','#expenseForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"expense_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#expenseForm')[0].reset();
				$('#expenseModal').modal('hide');				
				$('#save').attr('disabled', false);
				expenseRecords.ajax.reload();
			}
		})
	});		

	$("#expenseListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteExpense";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"expense_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					expenseRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});