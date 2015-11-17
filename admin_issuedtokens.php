<?php
	$user = 'root';
	$password = '';
	try{
		$dbh = new PDO('mysql:host=localhost;dbname=NOC', $user, $password);
		$query = "";

		if (isset($_POST['pump_id'])){
			$pump_id = $_POST['pump_id'];
			$query = "SELECT * FROM UserTokens WHERE fk_PetrolPumpsID=$pump_id";
		} else {
			$query = "SELECT * FROM UserTokens";
		}
		// if not $pump_id select total
		// replace query with pdo prepare and execute
		$issued_tokens = $dbh->query($query);

		$petrol_pumps = $dbh->query("SELECT PetrolPumpsID, Name FROM PetrolPumps");
		
	}catch (PDOException $e) {
		print "Error!: ".$e->getMessage() . "<br/>";
		die();
	}
?>


<<!DOCTYPE html>
<html>

	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <title>Welcome | Nepal Oil Corporation</title>

	    <link href="http://www.nepaloil.com.np/css/reset.css" rel="stylesheet" type="text/css" />
	    <link href="http://www.nepaloil.com.np/css/style.css" rel="stylesheet" type="text/css" />
	    <link rel="stylesheet" href="http://www.nepaloil.com.np/css/font-awesome/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="http://www.nepaloil.com.np/css/breakingNews.css" />
	    <style type="text/css">
	    	table, tr, th, td{border: 2px solid black;}
	    	table{width: 100%;}
	    </style>
	</head>
	<body class="drop">
		<div id="wrapper">
			<div id="top-panel">
	            <span class="floatL">
	                Current Retail Selling Price based on Kathmandu (Inclusive VAT) &nbsp;[Effective from 6th Sept 2015 at 24:00 hrs]:</p>
	            </span>
	            <div class="price-scroll">
	                <marquee direction="left" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();" style="width:363px;">
	                    <small>Petrol(MS):NRs 104.00/L &bull; LP Gas:NRs 1400.00/cyl&nbsp;</small></p>
	                </marquee>
	                <span class="lang floatR">
	                    <a href="http://nepaloil.com.np/" title="English">English</a>  |
	                    <a href="http://nepaloil.com.np/np-new/" title="&#2344;&#2375;&#2346;&#2366;&#2354;&#2368; ">&#2344;&#2375;&#2346;&#2366;&#2354;&#2368; </a>
	                </span>
	            </div>
	        </div> <!-- end of top-panel -->

	        <div id="header">
	            <a href="http://www.nepaloil.com.np/" title="Home">
	                <div id="logo"></div>
	            </a>
	            <div id="header-right"><img src="http://www.nepaloil.com.np/images/flag.gif" width="52" height="56" class="floatR" />
	                <br/>
	                <div class="date floatR">Monday November 16, 2015</div>
	                <span class="search floatR">
	                    <form action="http://www.nepaloil.com.np/search/">
	                        <input type="text" class="search-gog" name="q">
	                        <input type="submit" class="button" value="Search"/>
	                    </form>
	                </span>
	            </div>
	        </div> <!-- end of header -->

	        <div id="menu">
	            <link rel="stylesheet" type="text/css" media="screen" href="http://www.nepaloil.com.np/js/superfish/css/superfish.css" />
	            <script type="text/javascript" src="http://www.nepaloil.com.np/js/superfish/js/superfish.js"></script>
	            <script type="text/javascript">
		            jQuery(document).ready(function() {
		                jQuery("ul.sf-menu").superfish({
		                    animation: {
		                        height: 'show'
		                    }, // slide-down effect without fade-in
		                    delay: 1200 // 1.2 second delay on mouseout
		                });
		            });
	            </script>
	            <ul class="sf-menu">
	                <li><a href="http://www.nepaloil.com.np/">Home</a></li>
	                <li><a href="http://www.nepaloil.com.np/about-us-1.html">About Us</a>
	                    <ul>
	                        <li><a href="#">Supply and Distribution</a>
	                            <ul>
	                                <li><a href="http://www.nepaloil.com.np/storage-facilities-21.html">Storage Facilities</a></li>
	                                <li><a href="http://www.nepaloil.com.np/import-and-sales-22.html"> Import and Sales</a></li>
	                                <li><a href="http://www.nepaloil.com.np/distribution-network-23.html">Distribution Network</a></li>
	                                <li><a href="http://www.nepaloil.com.np/information-about-lpg-sales-30.html">Information about LPG Sales</a></li>
	                                <li><a href="http://www.nepaloil.com.np/lpg-upliftment---august-2015-31.html">LPG Upliftment - August 2015</a></li>
	                            </ul>
	                        </li>
	                        <li><a href="http://www.nepaloil.com.np/shareholder-11.html">Shareholder</a></li>
	                        <li><a href="#">Regulation and Manual</a></li>
	                        <li><a href="http://www.nepaloil.com.np/quality-awareness-6.html">Quality Awareness</a></li>
	                    </ul>
	                </li>
	                <li><a href="#">Selling Price</a>
	                    <ul>
	                        <li><a href="http://www.nepaloil.com.np/selling-price-archive-16.html">Selling Price Archive</a></li>
	                        <li><a href="http://www.nepaloil.com.np/monthly-profit-and-loss-details/">Fortnightly Profit and Loss Details</a></li>
	                    </ul>
	                </li>
	                <li>
	                    <a href="#">Media Center</a>
	                    <ul>
	                        <li><a href="http://www.nepaloil.com.np/news-events/Events/2/">Events</a></li>
	                        <li><a href="http://www.nepaloil.com.np/news-events/News/1/">News</a></li>
	                        <li><a href="http://www.nepaloil.com.np/news-events/Notice/5/">Notice</a></li>
	                        <li><a href="http://www.nepaloil.com.np/news-events/Publication/4/">Publication</a></li>
	                        <li><a href="http://www.nepaloil.com.np/news-events/Tender/3/">Tender</a></li>
	                    </ul>
	                </li>
	                <li>
	                    <a href="#">Management and Staff</a>
	                    <ul>
	                        <li><a href="http://www.nepaloil.com.np/board/Board-of-Directors/1/">Board of Directors</a></li>
	                        <li><a href="http://www.nepaloil.com.np/board/Management-Team/2/">Management Team</a></li>
	                        <li><a href="http://www.nepaloil.com.np/board/Branch-Chief/3/">Branch Chief</a></li>
	                    </ul>
	                </li>
	                <li><a href="#">Career</a></li>
	                <li><a href="#">Miscellaneous</a>
	                    <ul>
	                        <li><a href="http://www.nepaloil.com.np/abbreviations-19.html">Abbreviations</a></li>
	                        <li><a href="http://www.nepaloil.com.np/conversion-factors-20.html">Conversion Factors</a></li>
	                    </ul>
	                </li>
	                <li><a href="http://www.nepaloil.com.np/contact-us-2.html">Contact Us</a></li>
	            </ul>
	        </div> <!-- end of menu -->
	        
	        <div id="content">
	        	<div id="content-left">
	        		<form method="POST">
	        			<select name="pump_id">
	        				<?php foreach ($petrol_pumps as $pump):?>
		        				<option value="<?=$pump["PetrolPumpsID"]?>"><?=$pump["Name"]?></option>
		        			<?php endforeach; ?>
	        			</select>
	        			<input type="submit" value="Filter" />
	        		</form>
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
	        					<td><?=$row['PetrolPump']?></td>
	        					<td><?=$row['UserName']?></td>
	        					<td><?=$row['PhoneNumber']?></td>
	        				</tr>
	        			<?php endforeach; ?>
	        		</table>
	        	</div><!-- end of content-left -->
	        	<div id="content-right">
	        		I am right.
	        	</div><!-- end of content-right -->

	        </div><!-- end of content -->


		</div>
	</body>
</html>