<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Danadesa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('Danadesa_model', 'danadesa');
        $this->user = is_logged_in();
        $this->akses = cek_akses_user();
    }

    public function index($tahun=NULL, $bulan=NULL)
    {
        if ($this->akses['akses'] == 'Y') {
            if($tahun==NULL){$tahun=date('Y');}
            if($bulan==NULL){$bulan=date('m');}
            $data = [
                "menu_active" => "upload_data",
                "submenu_active" => "upload-dana-desa",
                "tahun" => $tahun,
                "bulan" => $bulan,
                "periode" => $this->mquery->select_id('tbl_dana_desa_log', ['tahun' => $tahun, 'bulan' => $bulan]),
                "result_bulan" => $this->mquery->select_data('bulan', 'id_bulan ASC')
            ];
            $this->load->view('upload/dana_desa/view', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    public function load()
    {
        $tahun = htmlspecialchars($this->input->post('tahun'));
        $bulan = htmlspecialchars($this->input->post('bulan'));
        $result_kabupaten = $this->mquery->select_by('tbl_dana_desa', ['tahun' => $tahun, 'bulan' => $bulan]);
        $array = [];
        $tahun_now=date('Y');
        foreach ($result_kabupaten as $kab) {
            $r_kab = $this->mquery->select_id('ta_kabupaten', ['id_kabupaten' => $kab['id_kabupaten']]);
            $nama_kabupaten = $r_kab['nama_kabupaten'];

            $dana = $this->danadesa->sum_danadesa($tahun, $bulan, $kab['id_kabupaten']);
            $alokasi = $dana['alokasi'];
            $realisasi_tahap1 = $dana['tahap1'];
            $realisasi_tahap2 = $dana['tahap2'];
            $realisasi_tahap3 = $dana['tahap3'];
            $realisasi_total = $realisasi_tahap1 + $realisasi_tahap2 + $realisasi_tahap3;
            $persen_realisasi = $realisasi_total / $alokasi * 100;

            $jumlah = $this->danadesa->sum_jumlahdesa($tahun, $bulan, $kab['id_kabupaten']);
            $jumlah_desa = $jumlah['desa'];
            $realisasi_desa1 = $jumlah['desa1'];
            $realisasi_desa2 = $jumlah['desa2'];
            $realisasi_desa3 = $jumlah['desa3'];
            $belum_cair1 = $jumlah_desa - $realisasi_desa1;
            $belum_cair2 = $jumlah_desa - $realisasi_desa2;
            $belum_cair3 = $jumlah_desa - $realisasi_desa3;

            if($tahun_now==$tahun)
                {
                    if ($this->akses['hapus'] == 'Y') 
                        {$delete = action_delete(encrypt_url($kab['id_danadesa']));}
                    else{$delete = "-";}
                }
                else
                {
                    if ($this->akses['hapus_1'] == 'Y') 
                        {$delete = action_delete(encrypt_url($kab['id_danadesa']));}
                    else{$delete = "-";}
                }

            $array[] = [
                'nama_kabupaten' => $nama_kabupaten,
                'alokasi' => $alokasi,
                'realisasi_tahap1' => $realisasi_tahap1,
                'realisasi_tahap2' => $realisasi_tahap2,
                'realisasi_tahap3' => $realisasi_tahap3,
                'realisasi_total' => $realisasi_total,
                'persen_realisasi' => $persen_realisasi,
                'jumlah_desa' => $jumlah_desa,
                'realisasi_desa1' => $realisasi_desa1,
                'realisasi_desa2' => $realisasi_desa2,
                'realisasi_desa3' => $realisasi_desa3,
                'belum_cair1' => $belum_cair1,
                'belum_cair2' => $belum_cair2,
                'belum_cair3' => $belum_cair3,
                'opsi' => $delete
            ];
        }
        $result_realisasi = array_sort($array, 'persen_realisasi', SORT_DESC); // sorting array berdasarkan jumlah tertinggi
        $data = [
            "result_realisasi" => $result_realisasi
        ];
        $this->load->view('upload/dana_desa/load', $data);
    }

    private function _rule_form()
    {
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|max_length[5]|trim');
        $this->form_validation->set_rules('tgl_periode', 'Tanggal periode', 'required|max_length[25]|trim');
        $this->form_validation->set_message('required', '%s tidak boleh kosong');
        $this->form_validation->set_message('max_length', 'Karakter %s terlalu panjang');
    }

    private function _send_error($params)
    {
        if ($params == 'file') {
            $errors = [
                'tahun' => form_error('tahun'),
                'tgl_periode' => form_error('tgl_periode'),
                'file_upload' => $this->upload->display_errors()
            ];
            $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => 'Data Gagal Disimpan'];
        } else {
            $errors = [
                'tahun' => form_error('tahun'),
                'tgl_periode' => form_error('tgl_periode'),
                'file_upload' => form_error('file_upload')
            ];
            $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => 'Data Gagal Disimpan'];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function form_upload()
    {
        $this->load->view('upload/dana_desa/form_upload');
    }

    function upload()
    {
        $this->_rule_form();
        if ($this->form_validation->run() == false) {
            $this->_send_error('default');
        } else {
            $post = $this->input->post(null, TRUE);
            $new_file = "";
            $config['upload_path'] = "./uploads/excel/";
            $config['allowed_types'] = 'xls';
            $config['file_name'] = 'dana-desa-' . date("Ymd-His");
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_upload')) {
                $this->_send_error('file');
            } else {
                $upload = $this->upload->data();
                $new_file = $upload['file_name'];
                if ($new_file != "") {
                    $excelreader = new PHPExcel_Reader_Excel5();
                    $loadexcel = $excelreader->load('./uploads/excel/' . $new_file);
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 0;
                    $tgl_periode = tanggal_database($post['tgl_periode']);
                    $bulan = date('m', strtotime($tgl_periode));
                    $cek_validasi=0;
                    $tdk_sesuai="";
                    foreach ($sheet as $row) {
                        if ($numrow > 2) {
                            $cek_B = strlen($row['B']);
                            if ($cek_B != 0) {
                                $kabupaten_danadesa=$row['B'];
                                $cek_kabupaten = $this->mquery->count_data('ta_kabupaten', ['nama_kabupaten' => $kabupaten_danadesa]);
                                if($cek_kabupaten==0){$tdk_sesuai=$tdk_sesuai." ".$kabupaten_danadesa; $cek_validasi++;}
                            }
                        }
                        $numrow++;
                    }
                    $tdk_sesuai=$tdk_sesuai." Tidak Sesuai";

                    if($cek_validasi>0)
                    {
                        $errors = [
                            'data error' => 'data error'
                        ];
                        $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => $tdk_sesuai];
                        $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    }
                    else
                    {
                        $numrow = 0;
                        $this->db->trans_start();

                        $this->db->delete('tbl_dana_desa_log', ['tahun' => $post['tahun'], 'bulan' => $bulan]);
                        foreach ($sheet as $row) {
                            if ($numrow >= 2) {
                                $cek_batas = strlen($row['A']);
                                if ($cek_batas != 0) {
                                    if ($row['A'] != 'TOTAL') {
                                        $nama_kabupaten = trim($row['B']);
                                        $alokasi = number_only($row['C']);
                                        $tahap1 = number_only($row['D']);
                                        $tahap2 = number_only($row['E']);
                                        $tahap3 = number_only($row['F']);
                                        $total = number_only($row['G']);
                                        $persen_total = konversi_angka($row['H']);
                                        $jumlah_desa = number_only($row['I']);
                                        $desa1 = number_only($row['J']);
                                        $desa2 = number_only($row['K']);
                                        $desa3 = number_only($row['L']);
                                        $belum1 = number_only($row['M']);
                                        $belum2 = number_only($row['N']);
                                        $belum3 = number_only($row['O']);
                                        $get_kode = $this->mquery->select_id('ta_kabupaten', ['nama_kabupaten' => $nama_kabupaten]);
                                        $id_kabupaten = $get_kode['id_kabupaten'];
                                        $array =  [
                                            'id_kabupaten' => $id_kabupaten,
                                            'tahun' => $post['tahun'],
                                            'bulan' => $bulan,
                                            'alokasi' => $alokasi,
                                            'tahap1' => $tahap1,
                                            'tahap2' => $tahap2,
                                            'tahap3' => $tahap3,
                                            'total_realisasi' => $total,
                                            'persen' => $persen_total,
                                            'desa' => $jumlah_desa,
                                            'desa1' => $desa1,
                                            'desa2' => $desa2,
                                            'desa3' => $desa3,
                                            'belum1' => $belum1,
                                            'belum2' => $belum2,
                                            'belum3' => $belum3
                                        ];
                                        $cek_skpd = $this->mquery->count_data('tbl_dana_desa', ['id_kabupaten' => $id_kabupaten, 'tahun' => $post['tahun'], 'bulan' => $bulan]);
                                        if ($cek_skpd > 0) {
                                            $this->db->update('tbl_dana_desa', $array, ['id_kabupaten' => $id_kabupaten, 'tahun' => $post['tahun'], 'bulan' => $bulan]);
                                        } else {
                                            $this->db->insert('tbl_dana_desa', $array);
                                        }
                                    }
                                }
                            }
                            $numrow++;
                        }
                        $array_log = [
                            "tahun" => $post['tahun'],
                            "bulan" => $bulan,
                            "periode" => $tgl_periode,
                            "tgl_input" => date('Y-m-d H:i:s'),
                            "user_input" => $this->user['user']
                        ];
                        $this->db->insert('tbl_dana_desa_log', $array_log);
                        $this->db->trans_complete();
                        $res = $this->db->trans_status();
                        $data = ['status' => TRUE, 'notif' => $res];
                        $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    }
                }
            }
        }
    }

    public function delete()
    {
        $encrypt_id = htmlspecialchars($this->input->post('id', TRUE));
        $id_danadesa = decrypt_url($encrypt_id);
        $temp = $this->mquery->select_id('tbl_dana_desa', ['id_danadesa' => $id_danadesa]);
        $string = ['tbl_dana_desa' => $temp];
        $log = simpan_log("delete tbl_dana_desa", json_encode($string));
        $res = $this->mquery->delete_data('tbl_dana_desa', ['id_danadesa' => $id_danadesa], $log);
        $data = ['status' => TRUE, 'notif' => $res];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
