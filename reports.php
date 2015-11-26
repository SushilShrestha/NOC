<?php // This file includes helper functions ?>

<?php function display_error($message){ ?>
	<?php require("header.php") ?>
	<div id="content-left">
		<h3 style="font-size:20px;margin:10px;color:red">Something Bad happened!!</h3>
		<div style="font-size:20px;margin:10px;"><?=$message["message"]?></div>
	</div>
	<div id="content-right"></div>
	<?php require("footer.php") ?>
<?php } ?>

<?php function display_success($message){?>
	<?php require("header.php") ?>
	<div id="content-left">
		<h3 style="font-size:20px;margin:10px;color:green">Success.</h3>
		<div style="font-size:20px;margin:10px;"><?=$message["message"]?></div>
	</div>
	<div id="content-right"></div>
	<?php require("footer.php") ?>
<?php } ?>

<?php function requires_admin_login(){
	if (isset($_SESSION['user']) && $_SESSION['user']=="admin"){
		return true;
	}
	header("Location: /NOC/login.php");
	die();
}