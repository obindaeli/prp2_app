<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title mb-0">
            FORM UPLOAD EXCEL ANGGARAN KAS
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="form-ubah">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="hidden" name="id_no" value="<?=$tbl_realisasi_wilayah['no']?>">
                        <input type="text" name="tahun" id="tahun" class="form-control" value="<?=$tbl_realisasi_wilayah['tahun']?>" readonly>
                        <small class="text-danger tahun"></small>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control select2" style="width: 100%;">
                                <option value="<?=$tbl_realisasi_wilayah['bulan']?>"><?=bulan($tbl_realisasi_wilayah['bulan'])?></option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        <small class="text-danger bulan"></small>
                    </div>
                    <div class="form-group">
                        <label for="pendapatan">Pendapatan</label>
                        <input type="text" name="pendapatan" id="pendapatan"  value="<?=$tbl_realisasi_wilayah['pendapatan_realisasi']?>" class="form-control">
                        <small class="text-danger pendapatan"></small>
                    </div>
                    <div class="form-group">
                        <label for="belanja">Belanja</label>
                        <input type="text" name="belanja" id="belanja"  value="<?=$tbl_realisasi_wilayah['belanja_realisasi']?>" class="form-control">
                        <small class="text-danger belanja"></small>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Data</label>
                        <input type="date" name="tanggal" id="tanggal"  value="<?=$tbl_realisasi_wilayah['tanggal']?>" class="form-control">
                        <small class="text-danger tanggal"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" id="btn-upload" class="btn btn-sm btn-primary">
                <i class="fa fa-save"></i> SIMPAN
            </button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                <i class="fa fa-times"></i> BATAL
            </button>
        </div>
    </form>
</div>

<script>
    $('.select2').select2();
</script>