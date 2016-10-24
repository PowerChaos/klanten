<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
$waarde = $_POST['waarde'];
$groep = $_POST['groep'];
$id = $_POST['id'];

//verwijder klant
if ($_POST['bewerk'] == "verwijder-klant")
{
	$id = $_POST['id'];
	try{
		$stmt = $db->prepare("SELECT id FROM producten WHERE klant =:id ORDER BY klant");
		$stmt->execute(array(':id' => $id));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		$post = 0;
		$sub = 0;
		foreach($result as $info)
		{
			$stmt2 = $db->prepare("DELETE FROM details WHERE pid =:id ORDER BY id");
			$stmt2->execute(array(':id' => $info['id']));
			$post += $stmt2->rowCount();
			$stmt3 = $db->prepare("DELETE FROM producten WHERE klant =:id ORDER BY id");
			$stmt3->execute(array(':id' => $id));
			$sub += $stmt3->rowCount();
		}
		$stmt4 = $db->prepare("DELETE FROM klanten WHERE id =:id ORDER BY id");
		$stmt4->execute(array(':id' => $id));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
if(!isset($_SESSION)){session_start();}	
	$_SESSION[ERROR] = "Klant ID $id en $sub Producten en $post details successvol verwijderd";		
}
if ($_POST['bewerk'] == "verwijder-product")
{
	$id = $_POST['id'];
	try{
		$stmt = $db->prepare("SELECT id FROM producten WHERE id =:id ORDER BY id");
		$stmt->execute(array(':id' => $id));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		$post = 0;
		$sub = 0;
		foreach($result as $info)
		{
			$stmt2 = $db->prepare("DELETE FROM details WHERE pid =:id ORDER BY id");
			$stmt2->execute(array(':id' => $info['id']));
			$post += $stmt2->rowCount();
		}
		$stmt4 = $db->prepare("DELETE FROM producten WHERE id =:id ORDER BY id");
		$stmt4->execute(array(':id' => $id));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	if(!isset($_SESSION)){session_start();}
	$_SESSION[ERROR] = "Product ID $id en $post details successvol verwijderd";		
}

if ($_POST['bewerk'] == "verwijder-info")
{
	$id = $_POST['id'];
	try{
		$stmt = $db->prepare("DELETE FROM details WHERE id =:id ORDER BY id");
		$stmt->execute(array(':id' => $id));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	if(!isset($_SESSION)){session_start();}
	$_SESSION[ERROR] = "Details $id successvol verwijderd";		
}

if (!empty($waarde))
{
	if ($groep == 'toevoegen')
	{
		if ($waarde == 'klant')
		{
?>
<form action="../invoer" method="POST" class='text-center'>
<input type="hidden" name="groep" value="<?php echo $groep ?>">
<input type="hidden" name="waarde" value="<?php echo $waarde ?>">
<table border=1 class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>Naam</th>
	<th>Straat</th>
	<th>Nummer</th>
</tr>
<thead>
<tbody>
<tr>						
	<td>
	<input type="text" name="naam" id="naam">
	</td>
	<td>
		<input type="text" name="straat" id="straat">
	</td>
	<td>
		<input type="text" name="nummer" id="nummer">
	</td>
	</tr>
 </tbody>
 <thead>
	<tr>
		<th>Postcode</th>
		<th>Gemeente</th>
		<th>Stad</th>
	</tr>
<thead>
		<tbody>
			<tr>
				<td>
					<input type="text" name="postcode" id="postcode">
				</td>
				<td>
					<input type="text" name="gemeente" id="gemeente">
				</td>
				<td>
					<input type="text" name="stad" id="stad">
				</td>
			</tr>
			</tbody>
			<thead>
			<tr>
				<th>Land</th>
				<th>Telefoon</th>
				<th>Email</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<input type="text" name="land" id="land">
				</td>
				<td>
					<input type="text" name="telefoon" id="telefoon">
				</td>
				<td>
					<input type="text" name="email" id="email">
				</td>
				</tr>
			</tbody>
</table>
    <input type="submit" value="Voeg Toe" class="btn btn-success text-center">
</form>	
	
<?php	
		} //einde Klant toevoegen
	if ($waarde == 'product')
	{ 
?>
	<form action="../invoer" method="POST" class='text-center'>
		<input type="hidden" name="groep" value="<?php echo $groep ?>">
		<input type="hidden" name="waarde" value="<?php echo $waarde ?>">
		<input type="hidden" name="id" value="<?php echo $id ?>">
		<table border=1 class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Naam</th>
					<th>Info</th>
				</tr>
				<thead>
					<tbody>
						<tr>						
							<td>
								<input type="text" name="naam" id="naam">
							</td>
							<td>
								<input type="text" name="info" id="info">
							</td>
						</tr>
					</tbody>
						</table>
						<input type="submit" value="Voeg Toe" class="btn btn-success text-center">
					</form>		
	
	<?php
	} // einde product toeveogen
	
			if ($waarde == 'info')
			{ 
			?>
			<form action="../invoer" method="POST" class='text-center'>
				<input type="hidden" name="groep" value="<?php echo $groep ?>">
				<input type="hidden" name="waarde" value="<?php echo $waarde ?>">
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<table border=1 class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Naam</th>
							<th>Info</th>
						</tr>
						<thead>
							<tbody>
								<tr>						
									<td>
										<input type="text" name="naam" id="naam">
									</td>
									<td>
										<input type="text" name="info" id="info">
									</td>
								</tr>
							</tbody>
						</table>
						<input type="submit" value="Voeg Toe" class="btn btn-success text-center">
					</form>		
					
					<?php
					} // einde product toeveoge
	
	} //einde Toevoegen groep
	if ($_POST['groep'] == 'bewerk')
	{
					if ($_POST['waarde'] == 'klant')
					{
						try{
							$stmt = $db->prepare("SELECT * FROM klanten WHERE id = :klant");
							$stmt->execute(array(':klant' => $id));
							$result = $stmt->fetch(PDO::FETCH_ASSOC);
						}//end try
						catch(Exception $e) {
							echo '<h2><font color=red>';
							var_dump($e->getMessage());
							die ('</h2></font> ');
						}					
							?>
						<form action="../invoer" method="POST" class='text-center'>
						<input type="hidden" name="groep" value="<?php echo $groep ?>">
						<input type="hidden" name="waarde" value="<?php echo $waarde ?>">
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<table border=1 class="table table-striped table-bordered table-hover">
						<thead>
						<tr>
						<th>Naam</th>
						<th>Straat</th>
						<th>Nummer</th>
						</tr>
						<thead>
						<tbody>
						<tr>						
						<td>
						<input type="text" name="naam" id="naam" value="<?php echo $result['naam'] ?>">
						</td>
						<td>
						<input type="text" name="straat" id="straat" value="<?php echo $result['straat'] ?>">
						</td>
						<td>
						<input type="text" name="nummer" id="nummer" value="<?php echo $result['nummer'] ?>">
						</td>
						</tr>
						</tbody>
						<thead>
						<tr>
						<th>Postcode</th>
						<th>Gemeente</th>
						<th>Stad</th>
						</tr>
						<thead>
						<tbody>
						<tr>
						<td>
						<input type="text" name="postcode" id="postcode" value="<?php echo $result['postcode'] ?>">
						</td>
						<td>
						<input type="text" name="gemeente" id="gemeente" value="<?php echo $result['gemeente'] ?>">
						</td>
						<td>
						<input type="text" name="stad" id="stad" value="<?php echo $result['stad'] ?>">
						</td>
						</tr>
						</tbody>
						<thead>
						<tr>
						<th>Land</th>
						<th>Telefoon</th>
						<th>Email</th>
						</tr>
						</thead>
						<tbody>
						<tr>
						<td>
						<input type="text" name="land" id="land" value="<?php echo $result['land'] ?>">
						</td>
						<td>
						<input type="text" name="telefoon" id="telefoon" value="<?php echo $result['telefoon'] ?>">
						</td>
						<td>
						<input type="text" name="email" id="email" value="<?php echo $result['email'] ?>">
						</td>
						</tr>
						</tbody>
						</table>
						<div class='row'>
						<input type="submit" value="Bewerk" class="btn btn-warning text-center">
						</div>
							</form>		
	<?
					} //einde klant bewerk
	
	} //einde Bewerk groep				
	
	
	
	} //einde waarde check
?>