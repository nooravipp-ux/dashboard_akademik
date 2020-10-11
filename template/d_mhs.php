<?php 
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/sistemik_dashboard_mobile';
$base_url = '/sistemik_dashboard_mobile';
include $base_dir.'/src/database/database.php';

$db = new database();
$ipk = $db->count_ipk($_SESSION['id_user']);
$data_mk = $db->get_data_nilai_mata_kuliah($_SESSION['id_user']);
$kalender_akademik = $db->get_data_kalender_akademik();
$cek_spp_status = $db->cek_spp_status($_SESSION['id_user']);
$jadwal_kuliah_mhs = $db->jadwal_kuliah_mhs($_SESSION['kode_jurusan'],$_SESSION['smt'],'7');
$cek_spp_semester = $db->cek_spp_semester_mhs($_SESSION['id_user'], $_SESSION['smt']);
$sks_ditempuh = $db->count_sks_ditempuh($_SESSION['id_user']);


?>
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= $_SESSION['username']; ?><span class="float-right"></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <p class="mb-0 text-white small-font"><?= $_SESSION['id_user']; ?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0"><?= round($ipk,2) ?></h5>
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
                                    <input class="form-check-input" type="checkbox" value=""
                                        <?php if($cek_spp_semester != true) echo 'checked'; ?> disabled="disabled">
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
                                    <input class="form-check-input" type="checkbox" value=""
                                        <?php if($cek_spp_semester == true) echo 'checked'; ?> disabled="disabled">
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
                                    <input class="form-check-input" type="checkbox" value="" <?php if($cek_spp_status[0]['cek_spp_status_krs'] == true) echo 'checked'; ?> disabled="disabled">
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
                                    <input class="form-check-input" type="checkbox" value="" <?php if($cek_spp_status[0]['cek_spp_status_uts'] == true) echo 'checked'; ?> disabled="disabled">
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
                                    <input class="form-check-input" type="checkbox" value="" <?php if($cek_spp_status[0]['cek_spp_status_uas'] == true) echo 'checked'; ?> disabled="disabled">
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
    <div class="col-12 col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-header">Statistik IPKS Persemester
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
                <ul class="list-inline">
                    <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>IPK
                    </li>
                </ul>
                <div class="chart-container-1">
                    <canvas id="chart_mhs"></canvas>
                </div>
            </div>

            <div class="row m-0 row-group text-center border-top border-light-3">
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0"><?= round($ipk,2) ?></h5>
                        <small class="mb-0">IPK Rata - Rata <span> <i class="fa fa-arrow-up"></i>
                                2.43%</span></small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0">3.40</h5>
                        <small class="mb-0">IPS Rata - Rata <span> <i class="fa fa-arrow-up"></i>
                                12.65%</span></small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0"><?= $sks_ditempuh ?> SKS</h5>
                        <small class="mb-0">Total SKS Sudah yang Ditempuh</span></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-header">Weekly sales
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
                        <tr>
                            <td><i class="fa fa-circle text-white mr-2"></i> Direct</td>
                            <td>$5856</td>
                            <td>+55%</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-circle text-light-1 mr-2"></i>Affiliate</td>
                            <td>$2602</td>
                            <td>+25%</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-circle text-light-2 mr-2"></i>E-mail</td>
                            <td>$1802</td>
                            <td>+15%</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-circle text-light-3 mr-2"></i>Other</td>
                            <td>$1105</td>
                            <td>+5%</td>
                        </tr>
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
            <div class="card-header">Data Nilai Per Mata Kuliah
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
                <table class="table"
                    style="height:440px;overflow:auto;">
                    <thead>
                        <tr>
                            <th>Smt</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Nilai Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($data_mk as $row){
                        ?>
                        <tr>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['kode_mk']; ?></td>
                            <td><?php echo $row['nama_mk']; ?></td>
                            <td><?php echo $row['sks']; ?></td>
                            <td><?php 
                                if($row['nilai_mk'] == 4){
                                    echo 'A';
                                }elseif(($row['nilai_mk'] == 3)){
                                    echo 'B';
                                }elseif(($row['nilai_mk'] == 2)){
                                    echo 'C';
                                }else{
                                    echo 'D';
                                }
                             ?>
                            </td>
                        </tr>
                        <?php }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">Jadwal Kuliah Tahun Akademik <?php echo $_SESSION['smt_aktif'] ?>
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
                            <th>Smt</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Hari Kuliah</th>
                            <th>Jam Kuliah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jadwal_kuliah_mhs as $jadwal) { ?>
                        <tr>
                            <td><?php echo $jadwal['angka_semester']; ?></td>
                            <td><?php echo $jadwal['nama_mk']; ?></td>
                            <td><?php echo $jadwal['sks_tm']; ?></td>
                            <td><?php echo $jadwal['hari_nama']; ?></td>
                            <td><?php echo $jadwal['wkt_kul_deskripsi_pagi']; ?></td>
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
    var ctx_mhs = document.getElementById('chart_mhs').getContext('2d');
    var chart_mhs = new Chart(ctx_mhs, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderWidth: 1,
                label: 'IPK',
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
                        max: 4.00,
                        min: 0.00,
                        stepSize: 1.00,
                        fontColor: '#ddd'
                    },
                    gridLines: {
                        display: true,
                        color: "rgba(221, 221, 221, 0.08)"
                    },
                }]
            }
        }
    });
    load_data_ipk_persemester();

    function load_data_ipk_persemester() {
        $.ajax({
            url: '<?= $base_url ?>/src/data_ip_sementara.php',
            success: function(data) {
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    chart_mhs.data.labels.push(data[i].semester);
                    chart_mhs.data.datasets.forEach((dataset) => {
                        dataset.data.push(data[i].ip_sementara);
                    });
                }
                // re-render the chart
                chart_mhs.update();
            }
        });
    };

    // chart 2

    var ctx = document.getElementById("chart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Direct", "Affiliate", "E-mail", "Other"],
            datasets: [{
                backgroundColor: [
                    "#ffffff",
                    "rgba(255, 255, 255, 0.70)",
                    "rgba(255, 255, 255, 0.50)",
                    "rgba(255, 255, 255, 0.20)"
                ],
                data: [5856, 2602, 1802, 1105],
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
});
</script>