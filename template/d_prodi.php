<?php 
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/dashboard_akademik';
$base_url = '/dashboard_akademik';
include $base_dir.'/src/database/database.php';

$db = new database();
$kalender = $db->get_data_kalender_akademik();
$jumlah_dosen = $db->jumlah_dosen($_SESSION['kode_jurusan']);
$jumlah_mhs_aktif = $db->jumlah_mhs_aktif($_SESSION['kode_jurusan']);
$jumlah_krs = $db->jumlah_krs($_SESSION['kode_jurusan'], $_SESSION['smt']);
$mhs_krs = $db->mhs_krs($_SESSION['kode_jurusan'], $_SESSION['smt']);
$mk_dosen = $db->mata_kuliah_dosen_ajar($_SESSION['kode_jurusan'], $_SESSION['smt']);
$persetujuan_krs = $db->data_persetujuan_krs_array($_SESSION['kode_jurusan'], $_SESSION['smt']);
$jml_mhs_pagi = $db->jumlah_mhs_pagi_sore($_SESSION['kode_jurusan'], 11);
$jml_mhs_sore = $db->jumlah_mhs_pagi_sore($_SESSION['kode_jurusan'], 12);
$jml_mhs_per_matkul = $db->data_mhs_per_matkul($_SESSION['kode_jurusan'], $_SESSION['smt']);

?>
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?=  $jumlah_mhs_aktif ?><span class="float-right"></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Mhs Aktif</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= $jumlah_dosen ?></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Dosen</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= $mhs_krs ?></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Mhs KRS</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= $jumlah_krs ?></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total KRS</p>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Nama Kegiatan</td>
                                <td>Tanggal Kegiatan</td>
                                <td>Deskripsi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kalender as $data){ ?>
                            <tr>
                                <td><?= $data['m_kegiatan_nama'] ?></td>
                                <td><?= $data['t_kegiatan_tgl_awal']?> s/d <?= $data['t_kegiatan_tgl_akhir']?></td>
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
<div class="row">
    <div class="col-12 col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-header">Jumlah Mahasiswa Pertahun
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
                <div class="chart-container-1">
                    <canvas id="chart_prodi"></canvas>
                </div>
            </div>

            <div class="row m-0 row-group text-center border-top border-light-3">
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0"><?=  $jumlah_mhs_aktif ?></h5>
                        <small class="mb-0">Total Mahasiswa (Pagi - Sore)</small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0"><?= $jml_mhs_pagi ?></h5>
                        <small class="mb-0">Mhs Reguler Pagi</small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0"><?= $jml_mhs_sore ?></h5>
                        <small class="mb-0">Mhs Reguler Sore</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-header">Kartu Rencana Studi
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
                <div class="chart-container-2">
                    <canvas id="chart2"></canvas>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center">
                    <tbody>
                        <?php foreach($persetujuan_krs as $krs){?>
                        <tr>
                            <td><i class="fa fa-circle text-white mr-2"></i><?= $krs['status_krs_nama'] ?></td>
                            <td><?= $krs['jumlah_krs'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--End Row-->
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
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
            <div class="table-responsive" style="height:400px;overflow:auto;">
                <table class="table align-items-center table-hover">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Jml Mhs</th>
                            <th>Dosen Pagi</th>
                            <th>Waktu Pagi</th>
                            <th>Dosen Sore</th>
                            <th>Waktu Sore</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jml_mhs_per_matkul as $data_mk){ ?>
                            <tr>
                                <td><?= $data_mk['nama_mk_mhs']?></td>
                                <td><?= $data_mk['nama_kelas']?></td>
                                <td><?= $data_mk['jml_mhs']?></td>
                                <td><?= $data_mk['dosen_nama_pagi']?></td>
                                <td><?= $data_mk['hari_nama_pagi']?> - <?= $data_mk['wkt_kul_deskripsi_pagi']?></td>
                                <td><?= $data_mk['dosen_nama_sore']?></td>
                                <td><?= $data_mk['hari_nama_sore']?> - <?= $data_mk['wkt_kul_deskripsi_sore']?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var ctx_prodi = document.getElementById('chart_prodi').getContext('2d');
    var chart_prodi = new Chart(ctx_prodi, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderWidth: 1,
                label: 'Jumlah Mhs',
                backgroundColor: 'rgba(255, 255, 255, 0.25)',
                borderColor: "transparent",
                pointRadius: "4",
                borderWidth: 6
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false,
                labels: {
                    fontColor: '#ddd',
                    boxWidth: 40
                }
            },
            tooltips: {
                displayColors: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        max: 70,
                        min: 0,
                        stepSize: 10,
                        fontColor: '#ddd'
                    },
                    gridLines: {
                        display: true,
                        color: "rgba(221, 221, 221, 0.08)"
                    },
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "#ddd",
                    }
                }],
            }
        }
    });
    load_data_jumlah_mhs_per_tahun();

    function load_data_jumlah_mhs_per_tahun() {
        $.ajax({
            url: '<?= $base_url ?>/src/jumlah_mhs_angkatan.php',
            success: function(data) {
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    chart_prodi.data.labels.push(data[i].tahun_angkatan);
                    chart_prodi.data.datasets.forEach((dataset) => {
                        dataset.data.push(data[i].jumlah_mhs);
                    });
                }
                // re-render the chart
                chart_prodi.update();
            }
        });
    };

    var ctx = document.getElementById("chart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                backgroundColor: [
                    "#ffffff",
                    "rgba(255, 255, 255, 0.70)",
                    "rgba(255, 255, 255, 0.50)",
                    "rgba(255, 255, 255, 0.20)"
                ],
                data: [],
                borderWidth: [0, 0, 0, 0]
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
                display: false,
                labels: {
                    fontColor: '#ddd',
                    boxWidth: 15
                }
            },
            tooltips: {
                displayColors: false
            }
        }
    });

    load_krs();

    function load_krs() {
        $.ajax({
            url: '<?= $base_url ?>/src/krs.php',
            success: function(data) {
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    myChart.data.labels.push(data[i].status_krs_nama);
                    myChart.data.datasets.forEach((dataset) => {
                        dataset.data.push(data[i].jumlah_krs);
                    });
                }
                // re-render the chart
                myChart.update();
            }
        });
    };
});
</script>