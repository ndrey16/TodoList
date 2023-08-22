<?php

$berkas = "data/data.json";
$dataJson = file_get_contents($berkas);
$getTodo = json_decode($dataJson, true);

$aktivitas = array("Others", "Session 1", "Session 2", "Session 3", "Session 4");

if (isset($_GET['delete'])) {
  $index = $_GET['delete'];
  if (isset($getTodo[$index])) {
    unset($getTodo[$index]);
    $getTodo = array_values($getTodo);
    $dataJson = json_encode($getTodo, JSON_PRETTY_PRINT);
    file_put_contents($berkas, $dataJson);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kegiatan   = $_POST['listKegiatan'];
  $keterangan = $_POST['aktifitas'];
  $jadwal     = $_POST['tanggal'];

  $allTodo    = array($kegiatan, $keterangan, $jadwal);
                array_push($getTodo, $allTodo);
                array_multisort($getTodo, SORT_ASC);
  $dataJson   = json_encode($getTodo, JSON_PRETTY_PRINT);
                file_put_contents($berkas, $dataJson);
                header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TODO | Kegiatan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Tema AdminLTE -->
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
</head>

<body class="bg-image hold-transition login-page m-3" style="background-image: url('image/bg1.jpg'); background-size: cover; background-position: center; ">
  <div class="container-fluid col-md-6">
    <div class="card card-outline card-primary" style="background-image: url('image/bg1.jpg'); background-size: cover; background-position: center;">
      <div class="card-header text-center">
        <h6 class="h1"><b>Todo</b>LIST</h6>
      </div>
      <div class="card-body">
        <h6 class="login-box-msg">Masukkan kegiatan Anda</h6>

        <form method="post">
          <div class="input-group mb-3">
            <select class="form-control" name="listKegiatan">
              <?php
                foreach ($aktivitas as $ak) {
                  echo "<option value='" . $ak . "'>" . $ak . "</option>";
                }
              ?>
            </select>
          </div>

          <div class="input-group mb-3">
            <input type="text" class="form-control" name="aktifitas" placeholder="Keterangan" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-list"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="date" class="form-control" name="tanggal" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-calendar"></span>
              </div>
            </div>
          </div>

          <div class="social-auth-links text-center mt-2 mb-3">
            <button type="submit" class="btn btn-block btn-primary ">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- TO DO List -->
  <div class="container-fluid center col-md-6">
    <div class="card-header text-center"  style="background-image: url('image/bghome.jpg'); background-size: cover; background-position: center;">
      <h3 class="card-title ">
        <i class="ion ion-clipboard mr-1 "></i><strong>List Session</strong>
      </h3>
    </div>

    <div class="todo-list" data-widget="todo-list">
  <?php
    $number = 1;
    foreach ($getTodo as $index => $todo) {
      echo "<li class='bg-image' style=\"background-image: url('image/bg1.jpg'); background-size: cover; background-position: center;\">";
      echo "<span class='handle' >";
      echo "<i class='fas fa-ellipsis-v'></i>";
      echo "<i class='fas fa-ellipsis-v'></i>";
      echo "</span>";
      echo "<div class='icheck-primary d-inline ml-2'>";
      echo "<input type='checkbox' value='' name='todo$number' id='todoCheck$number'>";
      echo "<label for='todoCheck$number'></label>";
      echo "</div>";
      echo "<span class='text'>". $todo[0] ."<br>". $todo[1] . "</span>";
      echo "<small class='badge badge-warning'><i class='far fa-clock'>".$todo[2]."</i></small>";
      echo "<div class='tools'>";
      echo "<a class='badge-danger' href='?delete=" . $index . "'><i class='fas fa-trash'></i></a>";
      echo "</div>";
      echo "</li>";
      $number++;
    }
  ?>
</div>
  </div>

  <!-- Berkas JavaScript -->
  <!-- jQuery -->
  <script src="template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
