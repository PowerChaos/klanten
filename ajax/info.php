<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
	if ($_POST['id'])
	{
		// parameters from URL
	$details = $_POST['id'];
	try{
		$stmt = $db->prepare("SELECT * FROM producten WHERE id = :product ORDER BY id ASC ");
		$stmt->execute(array(':product' => $details));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt2 = $db->prepare("SELECT * FROM producten WHERE klant = :klant ORDER BY id ASC ");
		$stmt2->execute(array(':klant' => $result[klant]));
		$result2 = $stmt2->fetchall(PDO::FETCH_ASSOC);
		}//end try
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		if (!empty($result))
		{		
			if ($_POST['klant'])
		{
			$stmt3 = $db->prepare("SELECT * FROM klanten WHERE id = :info ORDER BY id ASC ");
			$stmt3->execute(array(':info' => $result[klant]));
			$result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
			$name = explode(" ",$result3[naam]);
			$lname = $name[0];
			$fname = $name[1];
			$table = "
			<div class='row'>
			<div class='col-sm-4'>
                  <i class='fa fa-3x fa-user pull-left'></i>
                  <h4 class='list-group-item-heading'>$lname</h4>
				  <p class='list-group-item-text'>$fname</p>
            </div>

                <div class='col-sm-4'>
                  <h4 class='list-group-item-heading'>$result3[straat] $result3[nummer]</h4>
				  <p class='list-group-item-text'>$result3[postcode] $result3[gemeente] ( $result3[stad] ) $result3[land]</p>
                </div>
				
			<div class='col-sm-4'>
			<h4 class='list-group-item-heading'>$result3[telefoon]</h4>
			<p class='list-group-item-text'>$result3[email]</p>
			</div>
			</div>
			";
		}
		else {
			$header = "			<div class='col-sm-6 bootcards-list' id='list' data-title='producten'>		
			<div class='panel panel-default'>					
			<div class='panel-heading clearfix'>
			<h3 class='panel-title pull-left'>OverZicht Producten</h3> 
		<a class='btn btn-success pull-right' href='#'  data-toggle='modal' data-target='#modal' id='$result[klant]' onclick='edit(\"product\",\"toevoegen\",this.id);'>
		<i class='fa fa-plus'></i>
	<span>Add</span></a>
</a>
			<a class='btn btn-danger pull-right rem' href='#' id='$result[klant]' name='rem' onclick='rem(this.id,\"verwijder-product\");'>
			<i class='fa fa-trash-o'></i>
			<span>Delete</span></a>
			</a>
</div>
<div class='list-group'>";
$footer = " 					</div><div class='panel-footer'>
			<small class='pull-center'>OverZicht Producten</small>
			</div>					
			</div>
			</div>
			</div>";	
			foreach($result2 as $info) {
			$active = ($info[id] == $details)? "active":"";
			$spin = $active?"fa-spin":"";
				$table .= "<a class='list-group-item $active' href='#' id='$info[id]' onclick='getproduct(this.id);' >
					 		<div class='row'>
								<div class='col-sm-6'>
									<i class='fa fa-3x fa-refresh pull-left $spin' id='spin'></i>
									<h4 class='list-group-item-heading'>$info[naam]</h4>
									<p class='list-group-item-text'>$info[info]</p>
								</div>
							</div>
							</a>";
				}	
		$java = "						<script type='text/javascript'>
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
			function rem(val,dat) {
			if (dat == 'verwijder-product' )
			{var result = confirm('Dit Zal Alles verwijderen van Product ID '+val+' , ben je zeker ?');}										
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
		$( '#klantinfo' ).load( '../ajax/details.php', {
		product: $details,
		});
		$('.rem').attr('id',$details);
		//highlight first list group option (if non active yet)
		if ( $('.list-group a.active').length === 0 ) {
		$('.list-group a').first().addClass('active');
		$('.list-group i').first().addClass('fa-spin');
		}
		//highlight selection
		$('a.list-group-item').on('click', function() {
		$('a.list-group-item').removeClass('active');
		$('a.list-group-item').find('#spin').removeClass('fa-spin');
		$(this).addClass('active');
		$(this).find('#spin').addClass('fa-spin');
		});
		})
		function getproduct(val) {
		$.ajax({
		type: 'POST',
		url: '../ajax/details.php',
		data:'product='+val,
		success: function(data){
		//alert(data);
		$('#klantinfo').html(data);
		$('.rem').attr('id',val);
		$('.add').attr('id',val);
		}
		});
		}
		</script>";
		}
		}
$table = ($table == "")? "<div class='alert alert-danger text-center'>Niets Gevonden</div>" : $table .= $java ;				
echo $header;
echo $table;
echo $footer;
	}			//end try
//end try
?>					