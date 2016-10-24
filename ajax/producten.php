<?php
	if ($_POST['product'])
	{
		// parameters from URL
	$details = $_POST['product'];
	require(getenv("DOCUMENT_ROOT")."/functions/database.php");
	try{
		$stmt = $db->prepare("SELECT * FROM producten WHERE klant = :klant");
		$stmt->execute(array(':klant' => $details));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		}//end try
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		$head = "
		<div class='panel panel-default'>
		<div class='panel-heading clearfix'>
		<h3 class='panel-title pull-left'>OverZicht Producten</h3>
		<div class='btn-group pull-right'>
		<a class='btn btn-primary' data-toggle='modal' data-target='#modal' id='$details' onclick='edit(\"product\",\"toevoegen\",this.id);'>
		<i class='fa fa-plus'></i>
		<span>Add</span>
		</a>
		</div>							
		</div>					
		<div class='list-group'>
		";
			foreach($result as $info) {
				$table .= "
				<a class='list-group-item' href='$info[id]'>
				<i class='fa fa-3x fa-list pull-left' aria-hidden='true'></i>
				<h4 class='list-group-item-heading'>$info[naam]</h4>
				<p class='list-group-item-text'>$info[info]</p>
				</a>
				";
				}
$foot =" </div>
		<div class='panel-footer'>
		<small class='pull-center'>OverZicht Producten</small>
		</div>				
		</div>";
		
$table = ($table == "")? "<div class='alert alert-danger text-center'>Niets Gevonden</div>" : $table ;				
echo $head;
echo $table;
echo $foot;
				//end try
}//end try
?>					