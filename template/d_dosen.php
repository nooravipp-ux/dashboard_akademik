<?php 
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/dashboard_akademik';
$base_url = '/dashboard_akademik';
include $base_dir.'/src/database/database.php';

$db = new database();
$kalender = $db->get_data_kalender_akademik();
$jadwal_pagi = $db->tampil_jadwal_ajar_dosen_pagi('0402017301','20201');
$jadwal_sore = $db->tampil_jadwal_ajar_dosen_sore('0402017301','20201');


?>
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">Kalender Akademik
                <div class="card-action">
                    <div class="dropdown">
                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret"
                            data-toggle="dropdown">
                            <i class="icon-options"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void();">Action</a>
                            <a class="dropdown-item" href="javascript:void();">Another action</a>
                            <a class="dropdown-item" href="javascript:void();">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void();">Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach($kalender as $data){ ?>
                            <tr>
                                <td><?= $data['m_kegiatan_nama'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $data['t_kegiatan_deskripsi'] ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Row-->

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">Jadwal Ajar Tahun akademik <?php echo $_SESSION['smt_aktif'] ?>
                <div class="card-action">
                    <div class="dropdown">
                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret"
                            data-toggle="dropdown">
                            <i class="icon-options"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void();">Action</a>
                            <a class="dropdown-item" href="javascript:void();">Another action</a>
                            <a class="dropdown-item" href="javascript:void();">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void();">Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" style="height:440px;overflow:auto;">
                    <thead>
                        <tr>
                            <th>Smstr</th>
                            <th>Nama MK</th>
                            <th>sks</th>
                            <th>Ruang</th>
                            <th>Hari/Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jadwal_pagi as $jp){ ?>
                        <tr>
                            <td><?= $jp['angka_semester'] ?></td>
                            <td><?= $jp['nama_mk'] ?></td>
                            <td><?= $jp['sks_tm'] ?></td>
                            <td><?= $jp['nama_kelas_pagi'] ?></td>
                            <td><?= $jp['hari_nama'] ?>, <?= $jp['wkt_kul_deskripsi_pagi'] ?></td>
                        </tr>
                        <?php }?>
                        <?php foreach($jadwal_sore as $js){ ?>
                        <tr>
                            <td><?= $js['angka_semester'] ?></td>
                            <td><?= $js['nama_mk'] ?></td>
                            <td><?= $js['sks_tm'] ?></td>
                            <td><?= $js['nama_kelas_sore'] ?></td>
                            <td><?= $js['hari_nama'] ?>, <?= $js['wkt_kul_deskripsi_sore'] ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">History <?php echo $_SESSION['smt_aktif'] ?>
                <div class="card-action">
                    <div class="dropdown">
                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret"
                            data-toggle="dropdown">
                            <i class="icon-options"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void();">Action</a>
                            <a class="dropdown-item" href="javascript:void();">Another action</a>
                            <a class="dropdown-item" href="javascript:void();">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void();">Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mhs</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>