<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
	if ($_POST['product'])
	{
		// parameters from URL
	$details = $_POST['product'];
	try{
		$stmt = $db->prepare("SELECT * FROM details WHERE pid = :product ORDER BY lid ASC ");
		$stmt->execute(array(':product' => $details));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		}//end try
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		
		$header = "		
		<div class='panel panel-default'>					
		<div class='panel-heading clearfix'>
		<h3 class='panel-title pull-left'>Product Info</h3> 
		<a class='btn btn-success pull-right add' href='#'  data-toggle='modal' data-target='#modal' id='$details' onclick='edit(\"info\",\"toevoegen\",this.id);'>
		<i class='fa fa-plus'></i>
		<span>Add</span></a>
		</a>
		<a class='btn btn-danger pull-right rem2' href='#' id='{$result[0][id]}' name='rem2' onclick='rem2(this.id,\"verwijder-info\");'>
		<i class='fa fa-trash-o'></i>
		<span>Delete</span></a>
		</a>
		</div>
		<div class='list-group info'>";
		$footer = " 					</div><div class='panel-footer'>
		<small class='pull-center'>OverZicht Info</small>
		</div>					
		</div>
		</div>
		</div>";	
		foreach($result as $info) {
			$table .= "<a class='list-group-item info' href='#' onclick='select(\"$info[id]\");'>
			<div class='row'>
			<div class='col-sm-6'>
			<i class='fa fa-3x fa-mail pull-left'></i>
			<h4 class='list-group-item-heading'>$info[naam]</h4>
			<p class='list-group-item-text'>$info[info]</p>
			</div>
			</div>
			</a>";
		}	
		$java = "						<script type='text/javascript'>
		
		function select(val) {
		$('.rem2').attr('id',val);
		}
		function edit(val,dat,id) {
		$.ajax({
		type: 'POST',
		url: '../ajax/edit.php',
		data:'waarde='+val+'&groep='+dat+'&id='+id,
		success: function(data){
		//alert(data);
		//alert ('groep: ' +dat+ ' en waarde: ' +val);
		$('#modal').modal('show');
		$('#modalcode').html(data);
		
		}
		});
		}
		function rem2(val,dat) {
		if (dat == 'verwijder-info' )
		{var result = confirm('Dit Zal Info ID '+val+' Verwijderen, ben je zeker ?');}										
		else
		{
		var result = '';
		}
		if (result) {
		//Logic to delete the item
		
		$.ajax({
		type: 'POST',
		url: '../ajax/edit.php',
		data:'bewerk='+dat+'&id='+val,
		success: function(data){
		//alert(dat+' Succesvol uitgevoerd');
		//window.location.assign('https://klanten.manuprojects.eu')
		window.location.reload();
		}
		});
		}
		}
		$(document).ready(function() {
		//highlight first list group option (if non active yet)
		if ( $('.list-group.info a.active').length === 0 ) {
		$('.list-group.info a').first().addClass('active');
		$('.list-group.info i').first().addClass('fa-spin');
		}
		//highlight selection
		$('a.list-group-item.info').on('click', function() {
		$('a.list-group-item.info').removeClass('active');
		$(this).addClass('active');
		});
		})
		</script>";
	}		
$table = ($table == "")? "<div class='alert alert-danger text-center'>Niets Gevonden</div>" : $table .= $java;				
echo $header;
echo $table;
echo $footer;
			//end try
//end try
?>					