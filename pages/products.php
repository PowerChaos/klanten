<?php
if (u())
{
?>

<div class="col-sm-12 bootcards-list" id="list" data-title="Companies">		
	<div class="panel panel-default">					
		<div class="panel-heading clearfix">
			<h3 class="panel-title text-center">Geselecteerde Klant</h3> 
		</div>
		<div class="list-group">
			<div id="info">
			</div>
			<div class="panel-footer">
				<small class="pull-center">Geselecteerde Klant</small>
			</div>					
		</div>
	</div>
</div>




					<div id="producten">
						</div>


<div class="col-sm-6 bootcards-cards" id="listDetails">
<!--list of contacts-->
			<div class="list-group" id="klantinfo">
				
			</div>	
</div>	
<script>
	$(document).ready(function() {
		// Search Function
		//$("#klanten").hide();
		$( "#info" ).load( "../ajax/info.php", {
			id: <?php echo "$_GET[id]" ?>,
			klant : "klant",
		});
		$( "#producten" ).load( "../ajax/info.php", {
			id: <?php echo "$_GET[id]" ?>,
		});
	} );	
</script>		
<?
}// Einde start sessie
?>