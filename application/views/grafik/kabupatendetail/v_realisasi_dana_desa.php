<div class="card-body bg-primary-gradient">
    <div class="inner">
        <h2 style="color: white; font-weight: bold;"><i class="fa fa-chart-bar"></i>  DANA DESA <?=$result_kabupaten_nama?></h2>
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="card card-info bg-info-gradient">
                    <div class="card-body">
                        <h2 class="mb-1 fw-bold">Realisasi Dana Desa
                            <br>Periode <?= $this->fungsi->nama_bulan($row_desa['periode_desa'])?>
                            <br><?= "Rp " . format_angka($row_desa['total_realisasi']); ?>
                            <br>Persen : <?= $row_desa['persen']; ?> %
                        </h2>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-3"></div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div id="realisasi-dana-desa" style="width:100%; height: 413px;"></div>
            </div>
            <div class="col-lg-4 col-12">
                <div id="realisasi-jumlah-desa" style="width:100%; height: 413px;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="table-responsive">
                    <table class="table-grafik" style="margin-bottom: 0; width: 100%;">
                        <tr height="43" style="background-color: #e60000; color: white; font-size: 27px; font-weight: bold;">
                            <th  colspan="6">Realisasi Dana Desa <?=$result_kabupaten_nama?> Periode <?= $this->fungsi->nama_bulan($row_desa['periode_desa'])?></th>
                        </tr>
                        <tr height="43" style="background-color: #ff8b00; color: white; font-size: 27px; font-weight: bold;">
                            <th style="text-align: center;">Anggaran</th>
                            <th style="text-align: center;">Tahap 1</th>
                            <th style="text-align: center;">Tahap 2</th>
                            <th style="text-align: center;">Tahap 3</th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: center;">Persen</th>
                        </tr>
                        <?php
                            $data_rst   = $this->mquery->select_id('tbl_dana_desa',['id_kabupaten' => $id_kabupaten, 'tahun' => $tahun_data, 'bulan' => $row_desa['bulan_desa']]);
                        ?>
                        <tr height="43" style="background-color: #04756f; color: white; font-size: 27px; font-weight: bold;">
                            <td style="text-align: center;"><?php echo format_rupiah($data_rst['alokasi']); ?></td>
                            <td style="text-align: center;"><?php echo format_rupiah($data_rst['tahap1']); ?></td>
                            <td style="text-align: center;"><?php echo format_rupiah($data_rst['tahap2']); ?></td>
                            <td style="text-align: center;"><?php echo format_rupiah($data_rst['tahap3']); ?></td>
                            <td style="text-align: center;"><?php echo format_rupiah($data_rst['total_realisasi']); ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['persen']; ?> %</td>
                        </tr>
                    
                    </table>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="table-responsive">
                    <table class="table-grafik" style="margin-bottom: 0; width: 100%;">
                        <tr height="43" style="background-color: #ff8b00; color: white; font-size: 27px; font-weight: bold;">
                            <th rowspan="2"  style="text-align: center;">Jumlah Desa</th>
                            <th colspan="3"  style="text-align: center;">Jumlah Desa Cair</th>
                            <th colspan="3"  style="text-align: center;">Jumlah Desa Belum Cair</th>
                        </tr>
                        <tr height="43" style="background-color: #ff8b00; color: white; font-size: 27px; font-weight: bold;">
                            <th style="text-align: center;">Tahap I</th>
                            <th style="text-align: center;">Tahap II</th>
                            <th style="text-align: center;">Tahap III</th>
                            <th style="text-align: center;">Tahap I</th>
                            <th style="text-align: center;">Tahap II</th>
                            <th style="text-align: center;">Tahap III</th>
                        </tr>
                        <?php
                            $data_rst   = $this->mquery->select_id('tbl_dana_desa',['id_kabupaten' => $id_kabupaten, 'tahun' => $tahun_data, 'bulan' => $row_desa['bulan_desa']]);
                        ?>
                        <tr height="43" style="background-color: #04756f; color: white; font-size: 27px; font-weight: bold;">
                            <td style="text-align: center;"><?php echo $data_rst['desa']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['desa1']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['desa2']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['desa3']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['belum1']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['belum2']; ?></td>
                            <td style="text-align: center;"><?php echo $data_rst['belum3']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <br>

    </div>
</div> 
