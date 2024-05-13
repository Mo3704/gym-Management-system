<?php
class Expense {	
   
	private $categoryTable = ' expense_category';
	private $expenseTable = ' expense_expense';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listExpense(){		
		if($_SESSION["userid"]) {
			$sqlQuery = "SELECT expense.id, expense.amount, expense.date, category.name
				FROM ".$this->expenseTable." AS expense 
				LEFT JOIN ".$this->categoryTable." AS category ON expense.category_id = category.id 
				WHERE expense.user_id = '".$_SESSION["userid"]."' ";			
				
			if(!empty($_POST["search"]["value"])){
				$sqlQuery .= ' AND (expense.id LIKE "%'.$_POST["search"]["value"].'%" ';
				$sqlQuery .= ' OR expense.amount LIKE "%'.$_POST["search"]["value"].'%" ';
				$sqlQuery .= ' OR expense.date LIKE "%'.$_POST["search"]["value"].'%" ';
				$sqlQuery .= ' OR category.name LIKE "%'.$_POST["search"]["value"].'%") ';							
			}
			
			if(!empty($_POST["order"])){
				$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			} else {
				$sqlQuery .= 'ORDER BY expense.date DESC ';
			}
			
			if($_POST["length"] != -1){
				$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}	
			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();	
			
			$stmtTotal = $this->conn->prepare($sqlQuery);
			$stmtTotal->execute();
			$allResult = $stmtTotal->get_result();
			$allRecords = $allResult->num_rows;
			
			$displayRecords = $result->num_rows;
			$records = array();	
			$count = 1;
			while ($expense = $result->fetch_assoc()) { 				
				$rows = array();			
				$rows[] = $count;
				$rows[] = ucfirst($expense['amount']);
				$rows[] = $expense['name'];	
				$rows[] = $expense['date'];			
				$rows[] = '<button type="button" name="update" id="'.$expense["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
				$rows[] = '<button type="button" name="delete" id="'.$expense["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
				$records[] = $rows;
				$count++;
			}
			
			$output = array(
				"draw"	=>	intval($_POST["draw"]),			
				"iTotalRecords"	=> 	$displayRecords,
				"iTotalDisplayRecords"	=>  $allRecords,
				"data"	=> 	$records
			);
			
			echo json_encode($output);
		}
	}	
	
	public function insert(){
		
		if($this->expense_category && $this->amount && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->expenseTable."(`amount`, `date`, `category_id`, `user_id`)
				VALUES(?, ?, ?, ?)");
		
			$this->amount = htmlspecialchars(strip_tags($this->amount));
			$this->expense_date = htmlspecialchars(strip_tags($this->expense_date));
			$this->expense_category = htmlspecialchars(strip_tags($this->expense_category));
			
			$stmt->bind_param("isii", $this->amount, $this->expense_date, $this->expense_category, $_SESSION["userid"]);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function update(){
		
		if($this->id && $this->expense_category && $this->amount && $_SESSION["userid"]) {
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->expenseTable." 
			SET amount = ?, date = ?, category_id = ?
			WHERE id = ?");
	 
			$this->amount = htmlspecialchars(strip_tags($this->amount));
			$this->expense_date = htmlspecialchars(strip_tags($this->expense_date));
			$this->expense_category = htmlspecialchars(strip_tags($this->expense_category));
								
			$stmt->bind_param("isii", $this->amount, $this->expense_date, $this->expense_category, $this->id);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->id && $_SESSION["userid"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->expenseTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	function getCategoryList(){		
		$stmt = $this->conn->prepare("
		SELECT id, name, status FROM ".$this->categoryTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}	
	
	public function getExpenseDetails(){
		if($this->income_id && $_SESSION["userid"]) {			
					
			$sqlQuery = "
			SELECT expense.id, expense.amount, expense.date, expense.category_id
			FROM ".$this->expenseTable." AS expense
			LEFT JOIN ".$this->categoryTable." AS category ON expense.category_id = category.id
			WHERE expense.id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->income_id);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($expense = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['id'] = $expense['id'];				
				$rows['amount'] = $expense['amount'];				
				$rows['date'] = $expense['date'];
				$rows['category_id'] = $expense['category_id'];				
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}	
	
	public function listCateogry(){		
		
		$sqlQuery = "SELECT id, name, status
			FROM ".$this->categoryTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' AND (id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';
							
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();	
		$count = 1;
		while ($category = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($category['name']);
			$rows[] = $category['status'];				
			$rows[] = '<button type="button" name="update" id="'.$category["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$category["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
			$records[] = $rows;
			$count++;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}
	
	public function insertCategory(){
		
		if($this->categoryName && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->categoryTable."(`name`, `status`)
				VALUES(?, ?)");
		
			$this->categoryName = htmlspecialchars(strip_tags($this->categoryName));
			$this->status = htmlspecialchars(strip_tags($this->status));
			
			$stmt->bind_param("ss", $this->categoryName, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function updateCategory(){
		
		if($this->id && $this->categoryName && $_SESSION["userid"]) {
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->categoryTable." 
			SET name = ?, status = ?
			WHERE id = ?");
	 
			$this->categoryName = htmlspecialchars(strip_tags($this->categoryName));
			$this->status = htmlspecialchars(strip_tags($this->status));
								
			$stmt->bind_param("ssi", $this->categoryName, $this->status, $this->id);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function getCategoryDetails(){
		if($this->id && $_SESSION["userid"]) {			
					
			$sqlQuery = "
			SELECT id, name, status
			FROM ".$this->categoryTable." WHERE id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($category = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['id'] = $category['id'];				
				$rows['name'] = $category['name'];				
				$rows['status'] = $category['status'];					
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}
	

	public function deleteCategory(){
		if($this->id && $_SESSION["userid"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->categoryTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){				
				return true;
			}
		}
	} 
	
}
?>