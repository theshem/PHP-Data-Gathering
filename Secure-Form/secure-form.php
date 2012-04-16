<?php
session_start();

function gennum($q){
	$token = '';
	for($i=0; $i<$q; $i++){
		$token .= rand(0,9);
	}
	return $token;
}


if(!isset($_POST['submit'])){
	// set a security code
	$_SESSION['token'] = gennum(40);
?>

<form action="" method="post">
	<label for="fname">
		First Name: <input type="text" name="fname" />
	</label>
	<label for="lname">
		Last Name: <input type="text" name="lname" />
	</label>
	<input type="hidden" name="TOKEN" value="<?php echo $_SESSION['token'] ?>" />
	<input type="submit" name="submit" value="Submit" />
</form>

<?php	
}else{
	echo '<pre>';
	if($_POST['TOKEN'] != $_SESSION['token']){
		$message = "Access Denied!";
		
	}else{
		$message = "Your FIRST NAME is: $_POST[fname]\nYour LAST NAME is: $_POST[lname]";
	}
	echo $message;
	
	// set new security code
	$_SESSION['token'] = gennum(40);
}
?>