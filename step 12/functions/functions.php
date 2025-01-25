<?php 
$db = mysqli_connect("localhost","root","","sewakaset");



function query($query){
	global $db;
	$lemari = mysqli_query($db,$query);//pengambilan data semua ada disini
	// jadi gak harus lagi membawa selemarinya kehadapanmu
	// pertama kita suruh temen kita menyiapkan kota untuk menampung isinya
	$kotak = [];
	// jadi ketika diambil isinya menggunakan looping
	while ( $isi = mysqli_fetch_assoc($lemari)) {
		// temen kalian mengambil baju dimasukkan kotak/wadah terus menerus hingga looping selesai
		$kotak[] = $isi;
	}
	// setelah itu dikembalikan kotaknya
	return $kotak;
	// begitu keluar kamar tidak perlu membawa selemarinya jadi rapih berjejer
	// logiknya kamu mau lihat bajunya temanmu, kemudian temenmu menyiapkan terlebih dahulu disetiap kotak yang ada didalam lemari agar tidak membawa selemarinya dihadapanmu 
}

function tambah($data)
// fungsi tambah() akan mengambil data judul kaset baru yang diisi oleh pengguna pada formulir.
{
	global $db;
	// ambil data dari tiap elemen dalam form
	$judul =  htmlspecialchars($data["judulkaset"]);


	// upload gambar dulu
	$gambar = upload();
	if ( !$gambar ){
		return false;
	}

	// query insert data
	$query = "INSERT INTO kaset VALUES 
		('', '$judul', '$gambar')";
		mysqli_query($db, $query);
		//'' dikosongin untuk auto increment id
	return mysqli_affected_rows($db);
	// fungsi tambah() melakukan hal-hal yang serupa dengan proses penyimpanan baju baru di lemari baju:
    // Mengambil data dari formulir (judul kaset) dan menyimpannya di variabel.
    // Memanggil fungsi upload() untuk mengunggah gambar kaset baru.
    // Membuat query SQL untuk menyimpan data kaset baru ke dalam database.
    // Menjalankan query SQL dan mengembalikan jumlah baris yang terpengaruh (affected rows).

}

function upload()
//var_dump($_FILES);
// array(1) {
// 	["gambar"]=> (dimensi pertama adalah nama gambarnya) 
// 		array(5) {
// 		["name"]=> nama filenya 
// 		string(9) "jamur.jpg"
// 		["type"]=> tipenya
// 		string(10) "image/jpeg"
// 		["tmp_name"]=> tempat penyimpanan sementara
// 		string(24) "D:\xampp\tmp\php674D.tmp"
// 		["error"]=> nanti akan menghasilkan sebuah angka jika nilainya "0" itu artinya tidak ada error, jika lebih dari "0" maka ada eror tapi jikalau hasilnya itu "4" itu artinya adalah tidak ada file yang di upload 
// 		int(0)
// 		["size"]=> ukuran filenya
// 		int(63157)
// }
{
	// kita ambil terlebih dahulu data associatif arraynya ke variabel 
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	
	// melakukan pengecekan
	
	// cek apakah tidak ada gambar yang di upload\
	if ($error === 4) {
		echo "<script> alert('pilih gambar terlebih dahulu')</script>";
		return false;
	}
	
	// kemudian cek yang diupload gambar atau tidak
	$typeGambarValid = ['jpg', 'jpeg', 'png'];
	$typeGambar = explode('.', $namaFile);
	$typeGambar = strtolower(end($typeGambar));
	if ( !in_array($typeGambar,$typeGambarValid)) {
		echo "<script> alert('yang anda upload bukan gambar ')</script>";
		return false;
	}
	
	// cek ukuran
	if ($ukuranFile > 1000000){
		echo "<script> alert('ukuran terlalu BESAR')</script>";
		return false;
	}

	// jika lolos pengecekan, dipindahkan ke temp_filenya trs kita kirim ke tujuannya
	// untuk mengatasi penamaan file sama
	// memberikan nama baru untuk file gambar tersebut, misalnya dengan menambahkan id unik agar tidak terjadi konflik nama file.
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';// arti dari .= itu ditempel dengan
	$namaFileBaru .= $typeGambar;
	

	move_uploaded_file($tmpName, 'img/'. $namaFileBaru);
	// Setelah file gambar dipindahkan, Anda akan mengembalikan nama file gambar baru tersebut, agar bisa disimpan ke dalam database
	return $namaFileBaru;//supaya isi dari gambarnya adalah nama filenya, sehingga gambar bisa dimasukkan ke gambar (pada $query = "INSERT INTO kaset VALUES 
		// ('', '$judul', '$gambar')";
		// mysqli_query($db, $query);)

}

function hapus($id){
	global $db;
	mysqli_query($db, "DELETE FROM kaset WHERE id = $id");
	return mysqli_affected_rows($db);
}

function ubah($data){
	global $db;
	$id = $data["id"];//tidak di input oleh user
	$judul =  htmlspecialchars($data["judulkaset"]);

	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah yang diupload gambar baru atau tidak
	if($_FILES['gambar']['error'] === 4){
		$gambar = $gambarLama;//jika tidak upload maka masih tetap sama 
	} else {
		$gambar = upload();
	}
	// query insert data
		//jadi UPDATE tabel kaset ganti/timpa judul dengan judul baru ()
	$query = "UPDATE kaset SET  
		judulkaset = '$judul', 
		gambar = '$gambar'

		WHERE id = $id
		";

		mysqli_query($db, $query);
	return mysqli_affected_rows($db);
}

function cari($inputan)
// dari sana (index2.php) dikirim $_POST input ditangkap oleh $inputan
{
	$sek = "SELECT * FROM kaset
			WHERE 
			-- artinya cari kaset dengan berdasarkan 
			judulkaset LIKE '%$inputan%' OR -- judulkaset atau 
			-- menggunakan LIKE supaya pencariannya fleksibel biar tidak harus sama dengan apa yang ada di database 
			gambar LIKE '%$inputan%'
		";

		return query($sek);
		// function query dipanggil agar menghasilkan assosiatif array 
}

function registrasi ($data)//<= $data akan menerima/menangkap data data yang di kirim oleh post yang ada di file registrasi.php
{
	global $db;
	$username = strtolower(stripslashes( $data["username"]));//<= ambil data yang ada di $_POST kemudian di tangkap oleh $data kemudian disimpan di $username
	$password = mysqli_real_escape_string($db,$data["password"]);
	$password2 = mysqli_real_escape_string($db,$data["password2"]);


	// agar username tidak sama
	$resault = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");//$username yang diinput oleh user
	if (mysqli_fetch_row($resault) ){
		echo "<script> alert('Username sudah terdaftar')</script>";
		return false;//<= di return false agar berhenti
	}


	// cek konfirmasi password
	if ( $password !== $password2 ){
		echo "<script> alert('password konfirmasi tidak sesuai')</script>";
		return false;
	}

	// enkripsi password <= untuk mengacak password
	// $password = password_hash(password apa yang mau diacak yaitu $password yang mana di isi oleh user, algoritmanya password secara defaultnya php algoritmanya ini terus berubah ketika ada yang baru (PASSWORD_DEFAULT));
	$password = password_hash($password, PASSWORD_DEFAULT);



	// tambahkan user ke database (dbsm)
	mysqli_query($db, "INSERT INTO user VALUES('','$username','$password')");
	// Fungsi mysqli_query() dalam PHP adalah untuk mengirim query SQL ke database MySQL dan mendapatkan hasilnya.
	// Contoh: mysqli_query($connection, "SELECT * FROM users WHERE id = 1");
	// Fungsi ini digunakan untuk mengirim query SQL (seperti SELECT, INSERT, UPDATE, DELETE, dll.) ke database
	return mysqli_affected_rows($db);
	// ingat menggunakan fungsi mysqli_affected_rows($db) agar bisa menghasilkan angka 1 ketika sukses diinput dan ketika -1 ketika gagal 


}
?>