<?php 
require 'functions/functions.php';

if ( isset($_POST["register"]) ) //<= jika tombol register di kllik
{
	if( registrasi($_POST) > 0)//<= fungsi registrasi yang mengambil data dari ($_POST) lebih besar dari 0 maka
	{
		echo "<script> 
			alert('User berhasil ditambahkan');
		</script>";
	}else{
		echo mysqli_error($db);
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	
	<title>Registrasi</title>
	<style>
		label{
			display: block;
		}
	</style>
</head>
<body>
	<h1>Registration</h1>

	<form action="" method="post">
		<ul>
			<li>
				<label for="username">username</label>		
				<input type="text" name="username" id="username">		
			</li>
			<li>
				<label for="password">Pasword</label>
				<input type="password" name="password" id="password">
			</li>
			<li>
				<label for="password2">Konfirmasi Pasword</label>
				<input type="password" name="password2" id="password2">
			</li>
			<li><button type="submit" name="register">Sign up</button></li>		
		</ul>

	</form>
</body>
</html>