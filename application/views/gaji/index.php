<section class="content-header">
    <h1>
        Gaji - Pegawai
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Pegawai</a></li>
        <li class="active">Data Pegawai</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <!-- <h3 class="box-title">Responsive Hover Table</h3> -->
                    <!-- modal create -->

                    <!-- Tombol "Tambah Data" -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData">
                        Tambah Data
                    </button>

                    <?php if ($this->session->flashdata('error_message')) : ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error_message'); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="modalTambahDataLabel">Tambah Data Gaji Pegawai</h4>
                                </div>
                                <div class="modal-body">
                                    <!-- Form tambah data -->
                                    <!-- Form Input Gaji -->
                                    <form action="<?php echo base_url('gaji/insertGaji'); ?>" method="post">
                                        <div class="form-group">
                                            <label for="users_id">Username:</label>
                                            <select class="form-control" name="users_id" required>
                                                <option value="">Pilih Username</option>
                                                <?php foreach ($users_pegawai as $user) { ?>
                                                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->username; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal:</label>
                                            <input type="date" name="tanggal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gaji_pokok">Gaji Pokok:</label>
                                            <input class="form-control" type="number" name="gaji_pokok" value="<?php echo $umr; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="uang_makan">Uang Makan:</label>
                                            <input class="form-control" type="number" name="uang_makan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="uang_transport">Uang Transport:</label>
                                            <input class="form-control" type="number" name="uang_transport" required>
                                        </div>
                                        <input type="submit" value="Simpan" class="btn btn-primary">
                                    </form>
                                    <!-- Akhir form -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal Tambah Data -->

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <?php
                            $grandTotal = array(); // Membuat variabel untuk menyimpan total gaji
                            ?>
                            <tr>
                                <th>ID</th>
                                <th>Periode tanggal pemberian</th>
                                <th>Nama Pegawai</th>
                                <th>Gaji Pokok</th>
                                <th>Uang Makan</th>
                                <th>Uang Transport</th>
                                <th>Total Gaji</th>
                                <th>action</th>
                            </tr>
                            <?php $i = 1;
                            foreach ($gajiData as $data) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <!-- <td><?= $data->id_gaji; ?></td> -->
                                    <td><?= $data->tanggal; ?></td>
                                    <td><?= $data->username; ?></td>
                                    <td>Rp. <?= $data->gaji_pokok; ?></td>
                                    <td>Rp. <?= $data->uang_makan; ?></td>
                                    <td>Rp. <?= $data->uang_transport; ?></td>
                                    <td>
                                        <?php
                                        // Menghitung total gaji untuk setiap ID
                                        $totalGaji = $data->gaji_pokok + $data->uang_makan + $data->uang_transport;
                                        echo 'Rp. ' . $totalGaji;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('gaji/deleteGaji/' . $data->id_gaji); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data gaji ini?')">Delete</a>
                                    </td>
                                </tr>
                                <?php
                                // Menghitung total gaji untuk setiap ID
                                if (isset($grandTotal[$data->id_gaji])) {
                                    // Kalkulasi total gaji
                                    $grandTotal[$data->id_gaji]['gaji_pokok'] += $data->gaji_pokok;
                                    $grandTotal[$data->id_gaji]['uang_makan'] += $data->uang_makan;
                                    $grandTotal[$data->id_gaji]['uang_transport'] += $data->uang_transport;
                                } else {
                                    // Inisialisasi total gaji jika ID belum ada di dalam array
                                    $grandTotal[$data->id_gaji]['gaji_pokok'] = $data->gaji_pokok;
                                    $grandTotal[$data->id_gaji]['uang_makan'] = $data->uang_makan;
                                    $grandTotal[$data->id_gaji]['uang_transport'] = $data->uang_transport;
                                }
                                ?>
                            <?php endforeach; ?>

                            <!-- Menampilkan total gaji per ID -->
                            <!-- <?php foreach ($grandTotal as $id_gaji => $total) : ?>
                                <tr>
                                    <td colspan="3"><strong>Total Gaji (ID <?= $id_gaji ?>):</strong></td>
                                    <td>Rp. <?= $total['gaji_pokok'] ?></td>
                                    <td>Rp. <?= $total['uang_makan'] ?></td>
                                    <td>Rp. <?= $total['uang_transport'] ?></td>
                                    <td>
                                        <?php
                                        // Menghitung total gaji untuk setiap ID
                                        $totalGaji = $total['gaji_pokok'] + $total['uang_makan'] + $total['uang_transport'];
                                        echo 'Rp. ' . $totalGaji;
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>