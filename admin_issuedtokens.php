<?php
	require("config.inc.php");
	require("reports.php");
	requires_admin_login();
	
	try{
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		$query = "";
		$query_params = array();

		if (isset($_POST['pump_id']) && $_POST['pump_id'] != None){
			$pump_id = $_POST['pump_id'];
			
			$query = "SELECT * FROM UserTokens INNER JOIN PetrolPumps
						on UserTokens.fk_PetrolPumpsID=PetrolPumps.PetrolPumpsID
						WHERE fk_PetrolPumpsID=:pump_id ORDER BY Name";
			
			$query_params[':pump_id'] = $pump_id;
		} else {
			$query = "SELECT * FROM UserTokens INNER JOIN PetrolPumps 
						on UserTokens.fk_PetrolPumpsID=PetrolPumps.PetrolPumpsID ORDER BY Name";
		}

		if (isset($_POST['numTokens']) && $_POST['numTokens']){
			$num_tokens = $_POST['numTokens'];
			$query = $query." LIMIT 0, :limit";
			$query_params[':limit'] = intval($num_tokens);

			$issued_tokens_stmt = $db->prepare($query);	
			// $issued_tokens_stmt->bindParam(":limit", 100, PDO::PARAM_INT);
		} else {
			$issued_tokens_stmt = $db->prepare($query);	
		}

		$issued_tokens_stmt->execute($query_params);
		$issued_tokens = $issued_tokens_stmt->fetchAll();

		$petrol_pumps = $db->query("SELECT PetrolPumpsID, Name FROM PetrolPumps");

		$summary = $db->query("SELECT Name, COUNT(Name) AS count FROM UserTokens INNER JOIN PetrolPumps
								on UserTokens.fk_PetrolPumpsID=PetrolPumps.PetrolPumpsID GROUP BY Name");
		
	}catch (PDOException $e) {
		print "Error!: ".$e->getMessage() . "<br/>";
		die();
	}
?>

<?php require("header.php") ?>

	        	<div id="content-left">
	        		<h1 style="font-size:20px;margin:10px;">Issued Tokens
	        		<form method="POST" style="float:right;">
	        			<!-- Select Petrol Pump -->
	        			<select name="pump_id">
	        				<option value="None">None Selected</option>
	        				<?php foreach ($petrol_pumps as $pump):?>
		        				<option value="<?=$pump["PetrolPumpsID"]?>"><?=$pump["Name"]?></option>
		        			<?php endforeach; ?>
	        			</select>
	        			<input type="number" name="numTokens" placeholder="num of tokens"/>
	        			<input type="submit" value="Filter" />
	        		</form>
	        		</h1>
	        		<hr />
	        		<div id="section-to-print" style="margin-top:20px">
		        		<table>
		        			<tr>
		        				<td>UserTokensID</td>
		        				<td>BillBookID</td>
		        				<td>Token</td>
		        				<td>PetrolPump</td>
		        				<td>UserName</td>
		        				<td>PhoneNumber</td>
		        			</tr>
		        			<?php foreach ($issued_tokens as $row): ?>
		        				<tr>
		        					<td><?=$row['UserTokensID']?></td>
		        					<td><?=$row['BillBookID']?></td>
		        					<td><?=$row['Token']?></td>
		        					<td><?=$row['Name']?></td>
		        					<td><?=$row['UserName']?></td>
		        					<td><?=$row['PhoneNumber']?></td>
		        				</tr>
		        			<?php endforeach; ?>
		        		</table>
		        	</div><!-- end of section-to-print -->
	        	</div><!-- end of content-left -->
	        	<div id="content-right">
	        		<div class="messageModule">
	        			<h3>Summary</h3>
	        			<div class="messageWrapper">
	        				<table>
	        					<tr style="background:#006699;color:white">
	        						<td>Petrol Pump</td>
	        						<td>Tokens Issued</td>
	        					</tr>
	        					<?php foreach ($summary as $row): ?>
	        					<tr>
	        						<td><?=$row['Name']?></td>
	        						<td><?=$row['count']?></td>
	        					</tr>
	        					<?php endforeach ?>
	        				</table>
	        			</div>
	        		</div>
	        	</div><!-- end of content-right -->

<?php require("footer.php") ?>
	        