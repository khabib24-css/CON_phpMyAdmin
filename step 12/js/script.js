$(document).ready(function () {
  //$ ini sama dengan cara memanggil jquery. bacanya jquery tolong carikan/ ambilkan saya (document) ketika (document) tersebut siap, jalankan function berikut
  // yang ada didalam (document) terserah
  // menghilangkan tombol cari
  $("#tombol-cari").hide();
  //event ketika keyword ditulis
  $("#keyword").on("keyup", function () {
    //cara bacanya : jquery tolong carikan/ambilkan saya elemen keyword lalu on ketika di keyup lakukan fungsi berikut ini
    $(".loader").show();

    // ajax menggunakan LOAD
    // $("#container").load("ajax/data.php?keyword=" + $("#keyword").val());
    //jquery tolong carikan / ambilkan saya elemen container lalu (load)/(ubah isinya) dengan data yang kita ambil dari sumber (ajax/data.php) lalu kirimkan data keywordnya dikirimkan dengan apapun yang diketikkan oleh user
    // .load ini hanya bisa pada GET ketika pada POST maka menggunakan fungsi ajax yang lain

    // $.get()
    $.get("ajax/data.php?keyword=" + $("#keyword").val(), function (data) {
      $("#container").html(data);
      $(".loader").hide();
    });
  });
});

// memanggil ajax dengan jquery
