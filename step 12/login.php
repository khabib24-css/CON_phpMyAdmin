<?php 
session_start();
require 'functions/functions.php';

// cek cookie jika ada berarti dia masih login
if (isset($_COOKIE['id']) && isset($_COOKIE['key']))
{
	// ambil dulu datanya
	$id =  $_COOKIE['id'];
	$key =  $_COOKIE['key'];

	// ambil username berdasarkan idnya
	$resault = mysqli_query($db,"SELECT username FROM user WHERE id = $id");// artinya cari username yang idnya = id yang ada di cookie
	$rows = mysqli_fetch_assoc($resault);
	
	// cek cookie & usernamenya
	// isi dari $ key adalah username yang sudah diacak
	if ( $key === hash('sha256',$rows['username']))//$rows['username'] ini mengacak username baru berdasarkan $resault = mysqli_query($db,"SELECT username FROM user WHERE id = $id");
	// sama gak hasilnya kalo sama lakukan 
	{
		$_SESSION['login'] = true;
	}
}



if ( isset($_SESSION["login"]) )//jika ada session login
{
	header("location: index2.php");
	exit;
}

if (isset($_POST["login"])){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$resault = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");//<= ada nggak username yang dimasukkan itu didalam database

	// cek username
	// Fungsi mysqli_num_rows() dalam PHP adalah untuk mendapatkan jumlah baris (rows) yang dikembalikan oleh "SELECT * FROM user WHERE username = '$username'" kalo ketemu pasti nilainya 1 berarti ada kalo gak ada nilainya 0
	if (mysqli_num_rows($resault) === 1) {
		// jika username ada maka jalankan fungsi dibawah ini jika tidak ad maka lanjut ke $error
		// cek password
		$row = mysqli_fetch_assoc($resault);//<= $row berisikan array assoc, isinya id gambar judulkaset 
		if(password_verify($password,$row["password"]) ){

			// set session
			$_SESSION["login"] = true;

			// cek remember me
			if( isset($_POST['remember']) ){
				//buat cookie
				// setcookie('key','value', expirednya;
				

				setcookie('no',$row['id'], strtotime('+7 days'),'/');
				//'no' ini terserah mau apa untuk menampung id
				setcookie('key',hash('sha256',$row['username']), strtotime('+7 days'),'/');
				// 'key' ini juga terserah pokok gak sama dengan username biar susah ditebak kemuadian user name akan di acak dengan menggunakan algoritma php

				// setcookie('login','true', strtotime('+7 days'),'/'); cara ini mudah untuk disusupi user jahat
			}

			header("location: index2.php");
			exit;
		}
	}

	$error = true;

}


?>



<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>LOGIN</h1>

	<?php if( isset($error)) : ?>
		<p style="color:chocolate; font-style:italic">username / password salah</p>
		<?php endif; ?>
	<form action="" method="post">
		<ul>
			<li><label for="username">username</label>
			<input type="text" name="username" id="username"></li>
			<li>
				<label for="password">Password</label>
				<input type="password" name="password" id="password">
			</li>

			<li>
				
				<input type="checkbox" name="remember" id="remember">
				<label for="remember">remember me</label>
			</li>

			<li>
				<button type="submit" name="login">Log in</button>
			</li>
		</ul>
	</form>
</body>
</html>