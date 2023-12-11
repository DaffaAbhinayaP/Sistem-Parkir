<section class="content-header">
  <h1>
    Laporan Harian
    <small>Version 2.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Laporan Harian</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <h1>Laporan Harian</h1>
  <form action="<?php echo site_url('laporan/generateLaporanHarian'); ?>" method="post">
    <div class="form-group">
      <label for="hari">Pilih Tanggal:</label>
      <select name="hari" class="form-control">
        <?php foreach ($pilihanHari as $hari => $namaHari) {
          $tanggal = strtotime(date("Y-m") . "-" . $hari);
          $pilihanTanggal = date("Y-m-d", $tanggal);
        ?>
          <option value="<?php echo $pilihanTanggal; ?>"><?php echo date("d F Y", $tanggal); ?></option>
        <?php } ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Generate Laporan</button>
  </form>

  <!-- /.row -->
</section>