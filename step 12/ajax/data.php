<?php 
sleep(1);
// fungsi sleep ini untuk menidurkan / menjeda selama 1 detik, agar loading dalam pencarian sifatnya hanya sementara jika sudah masuk ke host maka dinonaktifkan saja
require '../functions/functions.php';
// kita tangkap dari file script.js
$keyword = $_GET["keyword"];

$query = "SELECT * FROM kaset
			WHERE 
			-- artinya cari kaset dengan berdasarkan 
			judulkaset LIKE '%$keyword%' OR -- judulkaset atau 
			-- menggunakan LIKE supaya pencariannya fleksibel biar tidak harus sama dengan apa yang ada di database 
			gambar LIKE '%$keyword%'
		";
$wadah = query($query);
?>
<table border="1" cellpaddin="10" cellspacing="0">
	<tr>
		<th>NO.</th>
		<th>AKSI</th>
		<th>GAMBAR</th>
		<th>JUDUL KASET</th>
	</tr>
	<?php $i = 1 ?>
	<?php foreach ($wadah as $baris) : ?>
	<tr>
		<td> <?= $i ?> </td>
		<td>
			<a href="ubah.php?id=<?= $baris["id"]; ?>">EDIT</a>
			<a href="hapus.php?id=<?= $baris["id"]; ?>" onclick="return confirm('SERIUS ?');">DELETE</a>
			<!-- ? berfungsi untuk mengirimkan data dan datanya adalah id -->
			<!--idnya diisi dengan id yang ada di tabel database  -->
		</td>
		<td><img src="img/<?= $baris["gambar"]; ?>" width="70"></td>
		<td><?= $baris["judulkaset"]; ?></td>
	</tr>
	<?php $i++ ?>
		<?php endforeach; ?>
	</table>