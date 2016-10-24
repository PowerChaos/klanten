<?
if (!u()){
?>

<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']?>/template/boot/css/login.css">
<!-- Login -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script src="//<?php echo $_SERVER['SERVER_NAME']?>/template/boot/js/login.js"></script>
<!-- login -->
	<div class="signin-form">

 <div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading"><?php
    echo $_SESSION[ERROR]?$_SESSION[ERROR]:"Klanten Database"; //show our sesion error above the login form
$_SESSION[ERROR]="";
	?></h2><hr />
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <input type="username" class="form-control" placeholder="Gebruiker" name="username" id="username" />
        <span id="check-username"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
        </div>
       
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Inloggen
   </button> 
        </div>  
      
      </form>

    </div>
    
</div>
<?php
}
if (u())
{
?>
			<div class="col-sm-6 bootcards-list" id="list" data-title="Klanten">
				<div class='panel panel-default'>					
					<div class='panel-body'>
						<div class='search-form'>
							<div class='row'>
								<div class='col-xs-12'>
									<div class='form-group'>
										<form class='form-horizontal' name='search' role='form' method='POST' onkeypress='return event.keyCode != 13;'>
											<div class='input-group col-sm-11'>
												<input id='name' name='name' type='text' class='form-control' placeholder='Zoek op Achternaam Telefoon gemeente of Klantnummer' autocomplete='off'/>
												<span class='input-group-btn'>
												<i class='fa fa-search'></i></span>
											</div>
										</form>
									</div> <!-- end form -->
								</div> <!-- end col -->
							</div> <!-- end row -->
							<div class='row'>
								<div class='col-xs-2 pull-left'>
									<a class='btn btn-danger btn-block rem' id='replace' name='rem' onclick='rem(this.id,"verwijder-klant");'>
										<i class='fa fa-trash-o'></i> 
										<span>Delete</span>
									</a>
								</div> <!-- end col -->
								<div class='col-xs-8'>
								</div> <!-- end col -->
								<div class='col-xs-2 pull-right'>
									<a class='btn btn-primary btn-block' data-toggle='modal' data-target='#modal' id='replace' name='add' onclick='edit("klant","toevoegen",this.id);'>
										<i class='fa fa-plus'></i> 
										<span>Add</span>
									</a>
								</div> <!-- end col -->
							</div> <!-- end row -->
						</div> <!-- end search -->
					</div>	<!-- end panel body -->					    			
					<div class='list-group'>
					<div id="klanten">
						</div>
							<div class='panel-footer'>
								<small class='pull-center'>OverZicht Klanten</small>
							</div>	<!-- end footer -->				
						</div> <!-- end group -->
					</div> <!-- end panel -->	
		</div>

<div class="col-sm-6 bootcards-cards" id="Details">
	
	<!--list klant info-->
	<div id="klantinfo">
	</div>	
	
	<!--list of products-->
	<div id="producten">
		
	</div>	
	
	
		
	</div>
<script>
	function rem(val,dat) {
		if (dat == "verwijder-klant" )
		{var result = confirm("Dit Zal alles verwijderen van klant ID "+val+" , ben je zeker ?");}										
		else
		{
			var result = "";
		}
		if (result) {
			//Logic to delete the item
			
			$.ajax({
				type: "POST",
				url: "../ajax/edit.php",
				data:'bewerk='+dat+'&id='+val,
				success: function(data){
					//alert(dat+" Succesvol uitgevoerd");
					window.location.reload();
				}
			});
		}
	}
	function edit(val,dat,id) {
		$.ajax({
			type: "POST",
			url: "../ajax/edit.php",
			data:'waarde='+val+'&groep='+dat+'&id='+id,
			success: function(data){
				//alert(data);
				//alert ("groep: " +dat+ " en waarde: " +val);
				$("#modal").modal('show');
				$("#modalcode").html(data);
				
			}
		});
	}
$(document).ready(function() {
	// Search Function
	//$("#klanten").hide();
	$( "#klanten" ).load( "../ajax/klanten.php", {
		query: "alles",
	});
	// Search
	function search() {
		var query_value = $('input#name').val();
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "../ajax/klanten.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("#klanten").html(html);
				}
			});
		}return false;    
	}
	
	$("input#name").on("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));
		
		// Set Search String
		var search_string = $(this).val();
		
		// Do Search
		if (search_string == '') {
			//$("#klanten").fadeOut(300);
			$( "#klanten" ).load( "../ajax/klanten.php", {
				query: "alles",
			});
			}else{
			$("#klanten").fadeIn(300);
			$(this).data('timer', setTimeout(search, 100));
		};
	});
} );	
</script>	
<?
}// Einde start sessie
?>

