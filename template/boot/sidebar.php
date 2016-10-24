<?php
if (u())
{
?>
  <!-- fixed top navbar -->
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <!--navbar menu options: shown on desktop only -->
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li>
            <a href="../">
              <i class="fa fa-users"></i> Klanten
            </a>
          </li>
        </ul>
		 	 <ul class="nav navbar-nav navbar-right"> 
	  	  <?php
	  if (a())
	  {
		  
?>					
		  <li class="dropdown">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-ticket"></i>Admin Menu
			  <span class="caret"></span></a>
			  <ul class="dropdown-menu">					
				  <li><a href="../a/gebruikers"><i class="fa fa-user-secret"></i>Gebruikers</a></li>
				  <li><a href="../a/groepen"><i class="fa fa-user-plus"></i>Groepen</a></li>
				  <li class="divider"></li>
				  <li><a href="../a/versie"><i class="fa fa-check-square-o"></i>Versie Controle</a></li>
			  </ul>
		  </li>
			  <?php		
			  }
		  ?>
				 <li class="dropdown">
					 <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i><?php echo $_SESSION['naam'] ?>
					 <span class="caret"></span></a>
					 <ul class="dropdown-menu">
						 <li><a href="../pass"><i class="fa fa-key"></i>wachtwoord</a></li>
						 <li><a href="../logout"><i class="fa fa-sign-out"></i>Log Uit</a></li> 
					 </ul>
				 </li>
			 </ul>
      </div>          
    </div>
  </div>   
<?php
}
?>
<div class="container bootcards-container push-right">
	
    <!-- This is where you come in... -->
    <!-- I've added some sample data below so you can get a feel for the required markup -->
	
<div class="row">
	<?php
		if ($_SESSION[ERROR] != "")
	{	
	echo "<div class='alert alert-info' role='alert'>
		<a href='#' class='close' data-dismiss='alert'>&times;</a>
		$_SESSION[ERROR]
	</div>";
	$_SESSION[ERROR] ="";
}
?>