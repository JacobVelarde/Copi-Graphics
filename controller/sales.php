<!DOCTYPE html>
<?php 
	require_once('db_connect.php');
	$Connection= new DBConnect();
?>
<html>
	<head>
		<meta charset="UTF-8">
		<style type="text/css">
			#headCon{
				background: #4DB6AC;
				margin: 0 auto;
				width: 50%;
				color: white;
				border-radius: 10px;
				padding: 10px 10px;
			}
			#tableSale{
				margin: 0 auto;
				width: 80%;
				border-radius: 10px;
				box-shadow: 5px -5px 7px 7px #78909C;
				margin-top: 20px;
			}
			tr, th, td{
				border-radius: 5px;
				padding: 5px 10px 5px 10px;
			}
			#titles{
				background: #0D47A1;
				color: white;
			}
			#content{
				background: #BBDEFB;
			}
		</style>
		<script type="text/javascript">
			


			function myFunction(opcion) {				
 				 if(opcion=="uno"){
 				 	document.getElementById('seeDate').style.display = 'block'
 				 	document.getElementById('seeCus').style.display = 'none';
 				 }else{
 				 	document.getElementById('seeDate').style.display = 'none';
 				 	document.getElementById('seeCus').style.display = 'block';
 				 }
			}
		</script>
	</head>
	<body>
		Ver ventas por:
		<input id="uno" type="radio" name="sale" value="date" onclick="if(this.checked){myFunction('uno')}">Fecha
		<input id="dos" type="radio" name="sale" value="customer" onclick="if(this.checked){myFunction('dos')}">Cliente
		<div id="seeDate" style='display:none;'>
			<form action="sales.php" method="POST">
				Seleccione fecha:
					<select name="dateSelect">
						<?php $D=$Connection->getDates();
							  for($i=0; $i < count($D); $i++){?>
								<option value="<?php echo $D[$i]; ?>"><?php echo $D[$i]; ?></option>
						<?php }?>
					</select>
				<input type="submit" value="Consultar">
			</form>
		</div>
		<div id="seeCus" style='display:none;'>
			<form action="sales.php" method="POST">
				Seleccione cliente:
					<select name="cusSelect">
						<?php $C=$Connection->getCustomers();
							  for($i=0; $i < count($C); $i++){
							  	$token=explode("%", $C[$i]);
						?>
								<option value="<?php echo $token[0]; ?>"><?php echo $token[1]; ?></option>
						<?php }?>
					</select>
					<input type="submit" value="Consultar">
			</form>
		</div>
		<?php 
			if(isset($_POST['dateSelect'])){
				$DS=$Connection->getDateSales($_POST['dateSelect']);
				$BS=$Connection->bestSellerAndTotalSaleDate($_POST['dateSelect'], 1);
				$totalSaleD=$Connection->bestSellerAndTotalSaleDate($_POST['dateSelect'], 0);
		?>
				<div id="headCon">
					<h3>Fecha: <?php echo $_POST['dateSelect']; ?></h3>
					<h4>Servicio más solicitado: <?php echo $BS; ?></h4>
					<h4>Total venta: $<?php echo $totalSaleD; ?></h4>
				</div>	
				<table id="tableSale" border="1">
					<tr id="titles">
						<th>ID Servicio</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Importe</th>
						<th>Descuento</th>
					</tr>
				<?php 
					for($i=0; $i < count($DS); $i++){
						$tokenDS=explode("%", $DS[$i]);
				?>
						<tr id="content">
							<th><?php echo $tokenDS[0]; ?></th>
							<th><?php echo $tokenDS[1]; ?></th>
							<th><?php echo $tokenDS[2]; ?></th>
							<th><?php echo $tokenDS[3]; ?></th>
							<th><?php echo $tokenDS[4]; ?></th>
							<th><?php echo $tokenDS[5]; ?></th>
						</tr>
	
		<?php
				}
			}else if(isset($_POST['cusSelect'])){
				$CS=$Connection->getCustomerSale($_POST['cusSelect']);
				$BSCus=$Connection->bestSellerAndTotalSaleCus($_POST['cusSelect'], 1);
				$totalSaleC=$Connection->bestSellerAndTotalSaleCus($_POST['cusSelect'], 0);
				$Cus=explode("%", $CS[0]);
		?>
				<div id="headCon">
					<h3>Cliente: <?php echo $Cus[0]; ?></h3>
					<h4>Servicio más solicitado: <?php echo $BSCus; ?></h4>
					<h4>Consumo total: $<?php echo $totalSaleC; ?></h4>
				</div>	
				<table id="tableSale" border="1">
					<tr id="titles">
						<th>ID Servicio</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Importe</th>
						<th>Descuento</th>
					</tr>
				<?php 
					for($i=0; $i < count($CS); $i++){
						$tokenCS=explode("%", $CS[$i]);
				?>
						<tr id="content">
							<th><?php echo $tokenCS[1]; ?></th>
							<th><?php echo $tokenCS[2]; ?></th>
							<th><?php echo $tokenCS[3]; ?></th>
							<th><?php echo $tokenCS[4]; ?></th>
							<th><?php echo $tokenCS[5]; ?></th>
							<th><?php echo $tokenCS[6]; ?></th>
						</tr>
	
		<?php
				}
			}
		?>
	</body>
</html>