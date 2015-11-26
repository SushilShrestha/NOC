<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
require("config.inc.php");
require("reports.php");
requires_admin_login();

$petrol_pumps = $db->query("SELECT PetrolPumpsID, Name FROM PetrolPumps");
$response = false;

//if posted data is not empty
if (!empty($_POST)) {
    //If the username or password is empty when the user submits
    //the form, the page will die.
    //Using die isn't a very good practice, you may want to look into
    //displaying an error message within the form instead.  
    //We could also do front-end form validation from within our Android App,
    //but it is good to have a have the back-end code do a double check.
    if (empty($_POST['PumpID']) || empty($_POST['SentAmount']) 
        || empty($_POST['Date'])) {
        
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please Enter All the data";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    
    //If we have made it here without dying, then we are in the clear to 
    //create a new user.  Let's setup our new query to create a user.  
    //Again, to protect against sql injects, user tokens such as :user and :pass
    $query = "INSERT INTO Distribution ( fk_PetrolPumpsID,SentAmount,AvailableDate)
     VALUES ( :pumpid, :sentamount, :avldate) ";
    
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
        ':pumpid' => $_POST['PumpID'],
        ':sentamount' => $_POST['SentAmount'],
        ':avldate' => $_POST['Date']
    );
    
    //time to run our query, and create the user
    print_r($query);
    print_r($query_params);
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message. 
        //die("Failed to run query: " . $ex->getMessage());
        
        //or just use this use this one:
        print_r($ex);
        $response["success"] = 0;
        $response["message"] = "Database Error2. Please Contact Admin!";
        die(json_encode($response));
    }
    
    //If we have made it this far without dying, we have successfully added
    //a new user to our database.  We could do a few things here, such as 
    //redirect to the login page.  Instead we are going to echo out some
    //json data that will be read by the Android application, which will login
    //the user (or redirect to a different activity, I'm not sure yet..)
    
    $response["success"] = 1;
    $response["message"] = "Distribution Successfully Added";
    // echo json_encode($response);
    
    //for a php webservice you could do a simple redirect and die.
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
}
require("header.php");
?>
<div id="content-left" style="margin:20px;">
    <?php if ($response): ?>
        <h1 style="font-size:20px;margin:10px;color:orange;border: 1px solid black;padding:20px"><?=$response["message"]?></h1><br>
    <?php endif ?>
	<h1 style="font-size:20px;margin:10px;">Registration </h1><hr>
	<form method="post"> 
        Petrol Pump: <br />
        <select name="PumpID">
            <option value="None">None Selected</option>
            <?php foreach ($petrol_pumps as $pump):?>
                <option value="<?=$pump["PetrolPumpsID"]?>"><?=$pump["Name"]?></option>
            <?php endforeach; ?>
        </select><br />
        Distributed Amount: <br />
        <input type="number" name="SentAmount" placeholder="enter distributed amount" />
        <br />
        Date: <br />
        <input type="date" name="Date" placeholder="Distribution date yyyy-mm-dd" /><br /><br />
	    <input type="submit" value="Add New Distribution" /> 
	</form>
</div>
<div id="content-right">
</div>
	<?php require("footer.php");?>