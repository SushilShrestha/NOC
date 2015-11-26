<?php
	require("config.inc.php");
	require("reports.php");
	requires_admin_login();
	
	try{
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$query = "";
		$query_params = array();

		if (isset($_POST['distribution_id']) && $_POST['distribution_id'] != None){
			$distribution_id = $_POST['distribution_id'];
			$query = "SELECT * FROM Distribution INNER JOIN PetrolPumps 
						on Distribution.fk_PetrolPumpsID=PetrolPumps.PetrolPumpsID 
						WHERE AvailableDate=:adate ORDER BY AvailableDate, Name";
			
			$query_params[':adate'] = $distribution_id;
		} else {
			$query = "SELECT * FROM Distribution INNER JOIN PetrolPumps 
						on Distribution.fk_PetrolPumpsID=PetrolPumps.PetrolPumpsID 
						WHERE AvailableDate >= CURDATE() ORDER BY AvailableDate, Name";
		}

		$distribution_stmt = $db->prepare($query);	
		$distribution_stmt->execute($query_params);
		$distributions = $distribution_stmt->fetchAll();

		$distributions_dates = $db->query("SELECT DISTINCT(AvailableDate) FROM Distribution WHERE AvailableDate >= CURDATE()");
		
	}catch (PDOException $e) {
		print "Error!: ".$e->getMessage() . "<br/>";
		die();
	}
?>

<?php require("header.php") ?>

	        	<div id="content-left">
	        		<h1 style="font-size:20px;margin:10px;">Petroleum Distribution records
	        		<form method="POST" style="float:right;">
	        			<!-- Select Petrol Pump -->
	        			<select name="distribution_id">
	        				<option value="None">All Selected</option>
	        				<?php foreach ($distributions_dates as $adate):?>
		        				<option value="<?=$adate['AvailableDate']?>"><?=$adate['AvailableDate']?></option>
		        			<?php endforeach; ?>
	        			</select>
	        			<input type="submit" value="Filter" />
	        		</form>
	        		</h1>
	        		<hr />
	        		<div id="section-to-print" style="margin-top:20px">
		        		<table>
		        			<tr style="background:#006699;color:white">
		        				<td>Petrol Pump</td>
		        				<td>Capacity</td>
		        				<td>Date</td>
		        				<td>Location</td>
		        				<td>Sent Amount</td>
		        			</tr>
		        			<?php foreach ($distributions as $row): ?>
		        				<tr>
		        					<td><?=$row['Name']?></td>
		        					<td><?=$row['Capacity']?></td>
		        					<td><?=$row['AvailableDate']?></td>
		        					<td><?=$row['Location']?></td>
		        					<td><?=$row['SentAmount']?></td>
		        				</tr>
		        			<?php endforeach; ?>
		        		</table>
		        	</div><!-- end of section-to-print -->
	        	</div><!-- end of content-left -->
	        	<div id="content-right">
	        		
	        	</div><!-- end of content-right -->

<?php require("footer.php") ?>
	        