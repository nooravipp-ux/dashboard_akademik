<?php 
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/sistemik_dashboard_mobile';
$base_url = '/sistemik_dashboard_mobile';
include $base_dir.'/src/database/database.php';

$db = new database();
$kalender = $db->get_data_kalender_akademik();
$jadwal_pagi = $db->tampil_jadwal_ajar_dosen_pagi('0402017301','20201');
$jadwal_sore = $db->tampil_jadwal_ajar_dosen_sore('0402017301','20201');
// var_dump($jadwal_sore);
// die();

?>
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= $_SESSION['username'];?><span class="float-right"></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font"><?= $_SESSION['id_user'];?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">IPK</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">

                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    Belum
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" disabled="disabled">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    Sudah
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status Pembayaran (LUNAS)</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" disabled="disabled">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    KRS
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" disabled="disabled">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    UTS
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" disabled="disabled">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    UAS
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Di Perbolehkan Untuk</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <div class="card-header">History Semester <?php echo $_SESSION['smt_aktif'] ?>
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
                <table class="table align-items-center table-flush table-borderless">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
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