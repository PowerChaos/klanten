<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
	if ($_POST['query'])
	{
		// parameters from URL
	$details = ($_POST['query'] == "alles") ? "%" : "%".$_POST['query']."%" ;
	try{
		$stmt = $db->prepare("SELECT * FROM klanten WHERE CONCAT (naam,telefoon,postcode,gemeente,id) LIKE :name ORDER BY naam ASC LIMIT 10 ");
		$stmt->execute(array(':name' => $details));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		}//end try
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}		
			foreach($result as $info) {
				$name = explode(" ",$info[naam]);
				$lname = $name[0];
				$fname = $name[1];
				$table .= "<a class='list-group-item pjax' href='#' id='$info[id]' onclick='getproduct(this.id);'>
					 		<div class='row'>
								<div class='col-sm-6'>
									<i class='fa fa-3x fa-refresh pull-left' id='spin'></i>
									<h4 class='list-group-item-heading'>$lname</h4>
									<p class='list-group-item-text'>$fname</p>
								</div>
								<div class='col-sm-6'>
									<p class='list-group-item-text'>$info[postcode] $info[gemeente]</p>
									<p class='list-group-item-text'>$info[telefoon]</p>
								</div>
							</div>
							</a>";
				}
		$java = "						<script type='text/javascript'>
		$(document).ready(function() { 
		var ID = $('a.list-group-item:first').attr('id'); 
		$( '#producten' ).load( '../ajax/producten.php', {
		product: ID,
		});
		$( '#klantinfo' ).load( '../ajax/klanten.php', {
		info: ID,
		});
		$('.rem').attr('id',ID);
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
		url: '../ajax/producten.php',
		data:'product='+val,
		success: function(data){
		//alert(data);
		$('#producten').html(data);
		}
		});
		$.ajax({
		type: 'POST',
		url: '../ajax/klanten.php',
		data:'info='+val,
		success: function(info){
		//alert(data);
		$('#klantinfo').html(info);
		$('.rem').attr('id',val);
		}
		});
		}
		</script>";				
$table = ($table == "")? "<div class='alert alert-danger text-center'>Niets Gevonden</div>" : $table .= $java ;				
echo $table;

}//end Query
if ($_POST['info'])
{
$info = $_POST['info'];
	try{
		$stmt = $db->prepare("SELECT * FROM klanten WHERE id = :klant");
		$stmt->execute(array(':klant' => $info,
		));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}//end try
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
		$table .= "
	<div class='panel panel-default'>
	<div class='panel-heading clearfix'>
	<h3 class='panel-title pull-left'>Klant NR <b>$result[id]</b></h3>
	<a class='btn btn-primary pull-right' data-toggle='modal' data-target='#modal' id='$result[id]' onclick='edit(\"klant\",\"bewerk\",this.id);'>
	<i class='fa fa-pencil'></i><span>Edit</span>
	</a>
	</div>
		<div class='list-group'>
				<div class='list-group-item'>
                  <i class='fa fa-3x fa-user pull-left'></i>
                  <label>Naam</label>
                  <h4 class='list-group-item-heading'>$result[naam]</h4>
				  </div>
				  
                <div class='list-group-item'>
                  <label>Adress</label>
                  <h4 class='list-group-item-heading'>$result[straat] $result[nummer]</h4>
                </div>

                <div class='list-group-item'>
		<label>Gemeente</label>
		<h4 class='list-group-item-heading'>$result[postcode] $result[gemeente] ( $result[stad] )</h4>
		</div>
		
	<div class='list-group-item'>
	<label>Land</label>
	<h4 class='list-group-item-heading'>$result[land]</h4>
	</div>
		
		<div class='list-group-item'>
		<label>Contact</label>
		<h4 class='list-group-item-heading'>$result[telefoon]</h4>
		<h4 class='list-group-item-heading'>$result[email]</h4>
		</div>
		</div>
	<div class='panel-footer'>
	<small class='pull-center'>Klant informatie</small>
	</div>	
	</div>
		";
echo $table;
}
?>					