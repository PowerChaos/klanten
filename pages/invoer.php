<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");

/*
Ruimte tussen verschillende post invoer functies
*/

//verwerking Data van pass.php
if ($_POST[info] == 'pass') //pass submit
{
	$hash = NEW PasswordStorage;
	$p2 =$hash->verify_password($_POST['oldpass'],$_SESSION['hash']);
if (($p2)&& $_POST['newpass'] == $_POST['newpass2'])
{
			$changepass = $db->prepare("UPDATE gebruikers SET wachtwoord=:hash WHERE id=:uid");
			$hashpass = $hash->create_hash($_POST["newpass"]);
			$changepass->execute(array(':hash' => $hashpass,':uid' => $_SESSION[id]));
			$_SESSION[relog] = "yes";			
}
else
{
$_SESSION[ERROR] = "Wachtwoord komt niet overeen<br>oud wachtwoord: $_POST[oldpass]<br>nieuw wachtwoord: $_POST[newpass] <br>Wachtwoord Herhaling: $_POST[newpass2]";	
}
if ($_SESSION[relog] =="")
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}//pass\" />";
}
else
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/\" />";	
}
} // einde verwerking pass.php

/*
Ruimte tussen verschillende post invoer functies
*/

 // Begin verwerking users.php
 
if ($_POST['users'] == 'rechten') //Rechten aanpassen
{
$waarde = $_POST['id'];
$data = $_POST['rechten'];
	if ($waarde > 1)
	{
	try{
$stmt = $db->prepare("UPDATE gebruikers SET rechten =:data WHERE id =:waarde ");
$stmt->execute(
array(
':waarde' => $waarde, 
':data' => $data 
 ));
	}
catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
}

switch ($data) {
    case "3":
        $data = "admin";
        break;
	case "2":
		$data = "staff";        
        break;
    case "b":
		$data = "Geblokeerd";
		break;
	default:
		$data = "gebruiker";
	}
$_SESSION[ERROR] = "Rechten zijn aangepast naar $data" ;
}
else
{
$_SESSION[ERROR] = "de rechten van id $waarde kan niet worden veranderd";
}

echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
}
 

/*
Ruimte tussen verschillende post invoer functies
*/

if ($_POST['users'] == 'hernoem') //Rechten aanpassen
{
$waarde = $_POST['id'];
$data = $_POST['naam'];
	try{
$stmt = $db->prepare("UPDATE gebruikers SET naam =:data WHERE id =:waarde ");
$stmt->execute(
array(
':waarde' => $waarde, 
':data' => $data 
 ));
	}
catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
}
$_SESSION[ERROR] = "naam is aangepast naar $data" ;
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
}
 

/*
Ruimte tussen verschillende post invoer functies
*/

if ($_POST['users'] == 'toevoegen') //Gebruiker toevoegen
{
$hash = NEW PasswordStorage;
$data = $_POST['wachtwoord'];
$hashpass = $hash->create_hash($data);
$naam = $_POST['naam'];
	try{	
$stmt = $db->prepare("INSERT INTO gebruikers (naam,wachtwoord) VALUES (:naam,:data)");
$stmt->execute(
array(
':naam' => $naam, 
':data' => $hashpass,
 ));
	}
catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
}
$_SESSION[ERROR] = "Gebruiker Toegevoegd met wachtwoord: <font color='red'>$data</font>" ;
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
}

/*
Ruimte tussen verschillende post invoer functies
*/

if ($_POST['users'] == 'wachtwoord') //Rechten aanpassen
{
$hash = NEW PasswordStorage;
$waarde = $_POST['id'];
$data = $_POST['wachtwoord'];
$hashpass = $hash->create_hash($data);
	try{
$stmt = $db->prepare("UPDATE gebruikers SET wachtwoord =:data WHERE id =:waarde ");
$stmt->execute(
array(
':waarde' => $waarde, 
':data' => $hashpass 
 ));
	}
catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
}
$_SESSION[ERROR] = "wachtwoord is aangepast naar $data" ;
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
}

/*
Ruimte tussen verschillende post invoer functies
*/

 // einde verwerking users.php 

/*
	Ruimte tussen verschillende post invoer functies
 */

//verwerking Data van admin/groep.php
if ($_POST['groep'] == 'gebruikers') //Gebruikers Toevoegen
{
	$id = $_POST['gid']; 
	$gebruikers = $_POST['gebruikers'];
	foreach($gebruikers as $a => $b)
	{
		try{
			$stmt = $db->prepare("SELECT user FROM groep WHERE id = :gid");
			$stmt->execute(array(':gid' => $id));
			$users = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($users['user']))
			{
				$str = arr($users['user']);
				sort($str);
				if (!in_array($gebruikers[$a], $str)) {
					$gebruikers[$a] = $users['user'].','.$gebruikers[$a];
				}
				else
				{
					$gebruikers[$a] = $users['user'];	
				}
			}
			$stmt = $stmt = $db->prepare("UPDATE groep SET user =:user WHERE id =:gid ");
			$stmt->execute(
			array(
			':gid' => $id, 
			':user' => $gebruikers[$a] 
			));
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
	}
	$_SESSION[ERROR] = "Gegevens Succesvol ingevoerd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}

/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['groep'] == 'eigenaars') //eigenaars toevoegen
{
	$id = $_POST['gid']; 
	$gebruikers = $_POST['gebruikers'];
	foreach($gebruikers as $a => $b)
	{
		try{
			$stmt = $db->prepare("SELECT * FROM gebruikers WHERE id = :gid");
			$stmt->execute(array(':gid' => $gebruikers[$a]));
			$users = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		if (!empty($users['gid']))
		{
			$_SESSION[ERROR] = "Gebruiker $users[naam] kan maar in 1 Groep zitten" ;
		}
		else
		{
			try{
				$stmt = $stmt = $db->prepare("UPDATE gebruikers SET groep =:gid WHERE id =:user ");
				$stmt->execute(
				array(
				':gid' => $id, 
				':user' => $gebruikers[$a] 
				));
			}
			catch(Exception $e) {
				echo '<h2><font color=red>';
				var_dump($e->getMessage());
				die ('</h2></font> ');
			}
			$_SESSION[ERROR] = "Gegevens Succesvol ingevoerd" ;
		}
	}
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}

/*
	Ruimte tussen verschillende post invoer functies
 */

if (($_POST['groep'] == 'toevoegen') && (empty($_POST['waarde']))) //eigenaars toevoegen
{
	$groep = $_POST['groepen'];
	foreach($groep as $a => $b)
	{
		try{
			$stmt = $stmt = $db->prepare("INSERT INTO groep (naam) VALUES (:naam)");
			$stmt->execute(
			array(
			':naam' => $groep[$a] 
			));
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
	}
	$_SESSION[ERROR] = "Groep Succesvol Toegevoegd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}


/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['groep'] == 'verwijder') //Groep Verwijdering
{
	$id = $_POST['id']; 
	
	try{
		$stmt = $db->prepare("DELETE FROM groep WHERE id = :id");
		$stmt->execute(array(':id' => $id));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}	
	$_SESSION[ERROR] = "Groep id $id Succesvol verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}

/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['delete'] == 'eigenaars') //eigenaar Verwijdering
{
	$id = $_POST['id'];
	$gid = $_POST['groep'];
	
	try{
		$stmt = $stmt = $db->prepare("UPDATE gebruikers SET groep =:gid WHERE id =:user ");
		$stmt->execute(
		array(
		':gid' => "", 
		':user' => $id 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Eigenaar $id is uit groep $gid verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}

/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['delete'] == 'gebruikers') //gebruiker Verwijdering
{
	$id = $_POST['id'];
	$gid = $_POST['groep'];
	
	try{
		$stmt = $db->prepare("SELECT * FROM groep WHERE id=:gid");
		$stmt->execute(array(':gid' => $gid));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}	
	
	$str = arr($result['user']);
	sort($str);
	if(($key = array_search($id, $str)) !== false) {
		unset($str[$key]);
	}
	$name = implode(",",$str);
	
	try{
		$stmt = $db->prepare("UPDATE groep SET user =:user WHERE id =:gid ");
		$stmt->execute(
		array(
		':gid' => $gid, 
		':user' => $name 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "gebruiker $id is uit groep $gid verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}


/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['groep'] == 'groepnaam') //eigenaars toevoegen
{
	$waarde = $_POST['waarde'];
	$data = $_POST['data'];
	try{
		$stmt = $stmt = $db->prepare("UPDATE groep SET naam =:data WHERE id =:waarde ");
		$stmt->execute(
		array(
		':waarde' => $waarde, 
		':data' => $data 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Groepsnaam is aangepast naar $data" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
}


/*
	Ruimte tussen verschillende post invoer functies
 */

// einde verwerking groep.php
 

/*
	Ruimte tussen verschillende post invoer functies
 */

 // verwerking ajax/edit.php
 
if ($_POST['groep'] == 'toevoegen') //toevoegen
{
	if ($_POST['waarde'] =='klant') //klanten
	{
	$naam = $_POST['naam'];
	$straat = $_POST['straat'];
	$nummer = $_POST['nummer'];
	$postcode = $_POST['postcode'];
	$gemeente = $_POST['gemeente'];
	$stad = $_POST['stad'];
	$land = $_POST['land'];
	$telefoon = $_POST['telefoon'];
	$email = $_POST['email'];
	try{	
		$stmt = $db->prepare("INSERT INTO klanten (naam,straat,nummer,postcode,gemeente,stad,land,telefoon,email) VALUES (:naam,:straat,:nummer,:postcode,:gemeente,:stad,:land,:telefoon,:email)");
		$stmt->execute(
		array(
		':naam' => $naam, 
		':straat' => $straat,
		':nummer' => $nummer, 
		':postcode' => $postcode,
		':gemeente' => $gemeente, 
		':stad' => $stad,
		':land' => $land, 
		':telefoon' => $telefoon,
		':email' => $email, 
		));
	$id = $db->lastInsertId();
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Nieuwe Klant Toegevoegt met ID $id" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/\" />";
} //einde klanten

	if ($_POST['waarde'] =='product') //producten
	{
		$naam = $_POST['naam'];
		$info = $_POST['info'];
		$klant = $_POST['id'];
		try{	
			$stmt = $db->prepare("INSERT INTO producten (naam,info,klant) VALUES (:naam,:info,:klant)");
			$stmt->execute(
			array(
			':naam' => $naam, 
			':info' => $info,
			':klant' => $klant, 
			));
			$id = $db->lastInsertId();
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		$_SESSION[ERROR] = "Nieuwe Product ( $naam ) Toegevoegt met ID $id" ;
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/$id\" />";
	} //einde producten

	if ($_POST['waarde'] =='info') //info
	{
		$naam = $_POST['naam'];
		$info = $_POST['info'];
		$product = $_POST['id'];
		try{	
			$stmt = $db->prepare("INSERT INTO details (naam,info,pid) VALUES (:naam,:info,:product)");
			$stmt->execute(
			array(
			':naam' => $naam, 
			':info' => $info,
			':product' => $product, 
			));
			$id = $db->lastInsertId();
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		$_SESSION[ERROR] = "Nieuwe info ( $naam ) Toegevoegt voor product ID $product" ;
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/$product\" />";
	} //einde info
	
} //einde Toevoegen

/*
	Ruimte tussen verschillende post invoer functies
 */

if ($_POST['groep'] == 'bewerk') //Bewerken Groep
{
if ($_POST['waarde'] =='klant') //klanten
{
	$naam = $_POST['naam'];
	$straat = $_POST['straat'];
	$nummer = $_POST['nummer'];
	$postcode = $_POST['postcode'];
	$gemeente = $_POST['gemeente'];
	$stad = $_POST['stad'];
	$land = $_POST['land'];
	$telefoon = $_POST['telefoon'];
	$email = $_POST['email'];
	$id = $_POST['id'];
	try{	
		$stmt = $db->prepare("UPDATE klanten SET naam=:naam,straat=:straat,nummer=:nummer,postcode=:postcode,gemeente=:gemeente,stad=:stad,land=:land,telefoon=:telefoon,email=:email WHERE id=:id");
		$stmt->execute(
		array(
		':naam' => $naam, 
		':straat' => $straat,
		':nummer' => $nummer, 
		':postcode' => $postcode,
		':gemeente' => $gemeente, 
		':stad' => $stad,
		':land' => $land, 
		':telefoon' => $telefoon,
		':email' => $email,
		':id' => $id,
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Klant met ID $id Bijgewerkt" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/\" />";
} //einde klanten

} //Eind bewerk Groep
 
//Geen Direct Acces
if (empty($_POST)) // Geen direct acces :D
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://{$_SERVER['SERVER_NAME']}/\" />";	
}
?>