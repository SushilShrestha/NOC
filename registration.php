<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
require("config.inc.php");
require("reports.php");

//if posted data is not empty
if (!empty($_POST)) {
    //If the username or password is empty when the user submits
    //the form, the page will die.
    //Using die isn't a very good practice, you may want to look into
    //displaying an error message within the form instead.  
    //We could also do front-end form validation from within our Android App,
    //but it is good to have a have the back-end code do a double check.
    if (empty($_POST['PhoneNumber']) || empty($_POST['FuelType']) 
        || empty($_POST['VehicleType'])  || empty($_POST['VehicleID'])
        || empty($_POST['BillBookID']) || empty($_POST['UserName'])
        || empty($_POST['PumpID'])) {
        
        
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please Enter All the Credentials";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    //if the page hasn't died, we will check with our database to see if there is
    //already a user with the username specificed in the form.  ":user" is just
    //a blank variable that we will change before we execute the query.  We
    //do it this way to increase security, and defend against sql injections
    $query        = " SELECT 1 FROM UserTokens WHERE BillBookID = :bill";
    //now lets update what :user should be
    $query_params = array(
        ':bill' => $_POST['BillBookID']
    );
    
    //Now let's make run the query:
    try {
        // These two statements run the query against your database table. 
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message. 
        //die("Failed to run query: " . $ex->getMessage());
        
        //or just use this use this one to product JSON data:
        $response["success"] = 0;
        $response["message"] = "Error Please Try Again!";
        die(json_encode($response));
    }
    
    //fetch is an array of returned data.  If any data is returned,
    //we know that the username is already in use, so we murder our
    //page
    $row = $stmt->fetch();
    if ($row) {
        // For testing, you could use a die and message. 
        //die("This username is already in use");
        
        //You could comment out the above die and use this one:
        $response["success"] = 0;
        $response["message"] = "This Vehichle has already been registered";
        die(json_encode($response));
    }
    
    // token generation part starts
    $file = 'file.txt'; // your file name
    // error handling etc to make sure file exists & readable

    $fdata = file_get_contents ( $file ); // read file data
    // parse $fdata if needed and extract number
    $fdata = intval($fdata) + 1;

    file_put_contents($file, $fdata); // write it back to file

    $token = $fdata;


    //If we have made it here without dying, then we are in the clear to 
    //create a new user.  Let's setup our new query to create a user.  
    //Again, to protect against sql injects, user tokens such as :user and :pass
    $query = "INSERT INTO UserTokens ( BillBookID,PhoneNumber,FuelType,VehicleType,VehicleID,UserName,fk_PetrolPumpsID,Token )
     VALUES ( :bill, :phone, :fuel, :vehicletype, :vehicleid, :username, :pumpid, :token ) ";
    
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
        ':bill' => $_POST['BillBookID'],
        ':phone' => $_POST['PhoneNumber'],
        ':fuel' => $_POST['FuelType'],
        ':vehicletype' => $_POST['VehicleType'],
        ':vehicleid' => $_POST['VehicleID'],
        ':username' => $_POST['UserName'],
        ':pumpid' => $_POST['PumpID'],
        ':token' => $token,

    );
    
    //time to run our query, and create the user
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message. 
        //die("Failed to run query: " . $ex->getMessage());
        
        //or just use this use this one:
        $response["success"] = 0;
        $response["message"] = "Database Error2. Please Try Again!";
        die(json_encode($response));
    }
    
    //If we have made it this far without dying, we have successfully added
    //a new user to our database.  We could do a few things here, such as 
    //redirect to the login page.  Instead we are going to echo out some
    //json data that will be read by the Android application, which will login
    //the user (or redirect to a different activity, I'm not sure yet..)
    $response["success"] = 1;
    $response["message"] = "Username Successfully Added! Your Token is $token";
    display_success($response);
    // echo json_encode($response);
    
    //for a php webservice you could do a simple redirect and die.
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
    $petrol_pumps = $db->query("SELECT PetrolPumpsID, Name FROM PetrolPumps");
    require("header.php");
?>
<div id="content-left" style="margin:20px;">
	<h1 style="font-size:20px;margin:10px;">Registration </h1><hr>
	<form action="registration.php" method="post"> 
	    Username:<br /> 
	    <input type="text" name="UserName" value="" /> 
	    <br /><br /> 
        Contact Number:<br /> 
        <input type="text" name="PhoneNumber" placeholder="Valid Contact Number" /> 
        <br /><br /> 
        Fuel Type:<br /> 
        <input type="text" name="FuelType" placeholder="Petrol/Disel" /> 
        <br /><br /> 
	    Vehicle Type:<br /> 
        <input type="text" name="VehicleType" placeholder="Bike/Car/Bus" /> 
        <br /><br /> 
        Vehicle ID:<br /> 
        <input type="text" name="VehicleID" placeholder="Number Plate" /> 
        <br /><br /> 
        Bill Book Number:<br /> 
        <input type="text" name="BillBookID" placeholder="Bill book Number" /> 
        <br /><br /> 
        Petrol Pump: <br />
        <select name="PumpID">
            <option value="None">None Selected</option>
            <?php foreach ($petrol_pumps as $pump):?>
                <option value="<?=$pump["PetrolPumpsID"]?>"><?=$pump["Name"]?></option>
            <?php endforeach; ?>
        </select><br /><br />
	    <input type="submit" value="Register New User" /> 
	</form>
</div>
<div id="content-right">
</div>
	<?php
}
    
    require("footer.php");
?>