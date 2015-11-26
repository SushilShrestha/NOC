<?php
	session_start();
	$next_page = isset($_GET['next'])?$_GET['next']:(isset($_POST['next'])?$_POST['next']:false);
	$error = false;
	
	if (isset($_POST['username']) && isset($_POST['password'])){
		$username=$_POST['username'];
		$password=$_POST['password'];

		if ($username=="admin" && $password=="NOCpass"){
			$_SESSION['user'] = "admin";
			if ($next_page){
				header("Location: $next_page");
				die();
			}
			header("Location: /NOC/admin_issuedtokens.php");
			die();
		}
		$error = true;
	}
	if (isset($_POST['username']) || isset($_POST['password'])){
		$error = true;
	}
?>
<?php require("header.php") ?>
<div id="content-left" style="font-family:sans;">
	<div style="padding:20px">
		<h2 style="font-size:20px;margin:20px 0px;">Welcome to Petroleum distribution management system</h2>
		<div>This portal is for admin user of Nepal Oil Corporation Limited. If you have arrived here just by chance, you can go to homepage by clicking <a href="http://nepaloil.com.np">here</a></div>
	</div>
</div>
<div id="content-right">
	<h2 style="font-size:20px;margin:20px 0px;">Login</h2>
	<?php if ($error):?><div style="color:red;">Username or Password incorrect</div><?php endif ?>
	<form method="POST">
		<input type="text" name="username" placeholder="username"/>
		<input type="password" name="password" placeholder="password" />
		<input type="submit" value="Login"/>
	</form>
</div>
<?php require("footer.php") ?>