$(document).ready(function(){	

	$('#viewReport').click(function(){
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();
		//console.log("==fromDate=="+fromDate+"==toDate="+toDate);
		var action = 'getReports';
		$.ajax({
			url:'report_action.php',
			method:"POST",
			data:{fromDate:fromDate, toDate:toDate, action:action},
			dataType:"json",
			success:function(respData){				
				var reportHTML = '';
				var totalExpense = 0;
				$('#reportTable').hide();
				$('#noRecords').hide();
				respData.data.forEach(function(item){	
					reportHTML+= '<tr>';
					reportHTML+= '<td>$'+item['amount']+'</td>';
					reportHTML+= '<td>'+item['date']+'</td>';
					reportHTML+= '<td>'+item['category']+'</td>';	
					reportHTML+= '</tr>';
					totalExpense = totalExpense + parseInt(item['amount']);
					$('#reportTable').show();
				});
				$('#listReports').html(reportHTML);
				$('#detailSection').hide();
				$('#totalIncome').text("");
				$('#totalExpense').text("");
				$('#totalSaving').text("");
				respData.income.forEach(function(income){	
					$('#totalIncome').text("$"+income['total']);
					$('#totalExpense').text("$"+totalExpense);
					var finalTotal = income['total'] - totalExpense;
					$('#totalSaving').text("$"+finalTotal);
					$('#detailSection').show();
				});
				
				if(!totalExpense) {
					$('#noRecords').html("<strong>No record found!</strong>").show();
				}
			}
		});
	});	

	
	
});