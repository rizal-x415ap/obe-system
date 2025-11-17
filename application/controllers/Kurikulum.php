<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kurikulum extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only();
    $this->load->model('M_kurikulum');
    $this->load->library('form_validation');
  }

  // CRUD UTAMA KURIKULUM


  public function set_kurikulum()
  {
    $data['kurikulum'] = $this->M_kurikulum->get_all();
    template('kurikulum/index', $data);
  }

  public function add()
  {
    $data['prodi'] = $this->M_kurikulum->get_prodi();

    $this->form_validation->set_rules('NamaKurikulum', 'Nama Kurikulum', 'required');
    $this->form_validation->set_rules('TahunMulai', 'Tahun Mulai', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('kurikulum', $data);
    } else {
      $insert = [
        'kdprodi' => $this->input->post('kdprodi'),
        'NamaKurikulum' => $this->input->post('NamaKurikulum'),
        'TahunMulai' => $this->input->post('TahunMulai'),
        'TahunSelesai' => $this->input->post('TahunSelesai'),
        'Status' => $this->input->post('Status'),
        'Deskripsi' => $this->input->post('Deskripsi')
      ];
      $this->M_kurikulum->insert($insert);
      redirect('kurikulum');
    }
  }

  public function edit($id)
  {
    $data['k'] = $this->M_kurikulum->get_by_id($id);
    $data['prodi'] = $this->M_kurikulum->get_prodi();
    if (!$data['k']) redirect('kurikulum');

    $this->form_validation->set_rules('NamaKurikulum', 'Nama Kurikulum', 'required');
    $this->form_validation->set_rules('TahunMulai', 'Tahun Mulai', 'required');

    if ($this->form_validation->run() == FALSE) {
      template('kurikulum/edit', $data);
    } else {
      $update = [
        'kdprodi' => $this->input->post('kdprodi'),
        'NamaKurikulum' => $this->input->post('NamaKurikulum'),
        'TahunMulai' => $this->input->post('TahunMulai'),
        'TahunSelesai' => $this->input->post('TahunSelesai'),
        'Status' => $this->input->post('Status'),
        'Deskripsi' => $this->input->post('Deskripsi')
      ];
      $this->M_kurikulum->update($id, $update);
      redirect('kurikulum');
    }
  }

  public function delete($id)
  {
    $this->M_kurikulum->delete($id);
    redirect('kurikulum');
  }

  // PENYUSUNAN MATA KULIAH DALAM KURIKULUM

  public function penyusunan_mk()
  {
    // ambil kurikulum aktif
    $aktif = $this->M_kurikulum->get_aktif();
    if (!$aktif) {
      echo "<div style='padding:20px;font-family:sans-serif;color:red;'>❌ Belum ada kurikulum aktif. Silakan aktifkan di menu Kurikulum.</div>";
      return;
    }

    $data['kurikulum'] = $aktif;
    $data['mk'] = $this->M_kurikulum->get_mk();
    $data['relasi'] = $this->M_kurikulum->get_kurikulum_mk($aktif->IdKurikulum);
    $data['title'] = 'Penyusunan MK';
    template('kurikulum/penyusunan_mk', $data);
  }

  public function simpan_penyusunan_mk()
  {
    $IdKurikulum = $this->input->post('IdKurikulum');
    $records = $this->input->post('data');

    $result = $this->M_kurikulum->save_kurikulum_mk($IdKurikulum, $records);

    if ($result) {
      echo json_encode(['success' => true, 'msg' => 'Data berhasil disimpan.']);
    } else {
      echo json_encode(['success' => false, 'msg' => 'Terjadi kesalahan saat menyimpan.']);
    }
  }

  //  MK PRASYARAT

  public function mk_prasyarat()
  {
    $aktif = $this->M_kurikulum->get_aktif();
    if (!$aktif) {
      echo "<div style='padding:20px;font-family:sans-serif;color:red;'>❌ Belum ada kurikulum aktif. Silakan aktifkan di menu Kurikulum.</div>";
      return;
    }

    $data['kurikulum'] = $aktif;
    $data['mk'] = $this->M_kurikulum->get_mk();
    $data['kurikulum_mk'] = $this->db->get('kurikulum_mk')->result(); // ambil SKS dan semester MK utama
    $data['prasyarat'] = $this->M_kurikulum->get_prasyarat_map_detail();
    $data['title'] = 'Penyusunan MK Prasyarat';

    template('kurikulum/mk_prasyarat', $data);
  }

  public function add_mk_prasyarat()
  {
    $id_mk = $this->input->post('id_mk');
    $id_mk_prasyarat = $this->input->post('id_mk_prasyarat');
    $this->M_kurikulum->add_mk_prasyarat($id_mk, $id_mk_prasyarat);
    echo json_encode(['success' => true]);
  }

  public function delete_mk_prasyarat($id)
  {
    $this->M_kurikulum->delete_mk_prasyarat($id);
    echo json_encode(['success' => true]);
  }

  // DOSEN PENGAMPU MK

  public function dosen_pengampu()
  {
    $aktif = $this->M_kurikulum->get_aktif();
    if (!$aktif) {
      echo "<div style='padding:20px;font-family:sans-serif;color:red;'>❌ Belum ada kurikulum aktif. Silakan aktifkan di menu Kurikulum.</div>";
      return;
    }

    $data['kurikulum']   = $aktif;
    $data['kurikulum_mk'] = $this->db->order_by('semester')->get('kurikulum_mk')->result();
    $data['mk']          = $this->M_kurikulum->get_mk();
    $data['dosen']       = $this->M_kurikulum->get_dosen();
    $data['pengampu']    = $this->M_kurikulum->get_pengampu_map();
    $data['title'] = 'Dosen Pengampu MK';

    template('kurikulum/dosen_pengampu', $data);
  }

  public function add_dosen_pengampu()
  {
    $id_mk = $this->input->post('id_mk');
    $id_dosen = $this->input->post('id_dosen');
    $this->M_kurikulum->add_pengampu($id_mk, $id_dosen);
    echo json_encode(['success' => true]);
  }

  public function delete_dosen_pengampu($id)
  {
    $this->M_kurikulum->delete_pengampu($id);
    echo json_encode(['success' => true]);
  }

  // INDIKATOR MK

  public function indikator_mk()
  {
    $data['cpl_cpmk'] = $this->M_kurikulum->get_cpl_with_cpmk();
    $data['mk_list'] = $this->M_kurikulum->get_mk();
    $data['map'] = $this->M_kurikulum->get_cpmk_mk_map();
    $data['title'] = 'Indikator MK';

    template('kurikulum/indikator_mk', $data);
  }

  public function add_indikator_mk()
  {
    $idcpmk = $this->input->post('idcpmk');
    $id_mk = $this->input->post('id_mk');
    $this->M_kurikulum->add_cpmk_mk($idcpmk, $id_mk);
    echo json_encode(['success' => true]);
  }

  public function delete_indikator_mk()
  {
    $idcpmk = $this->input->post('idcpmk');
    $id_mk = $this->input->post('id_mk');
    $this->M_kurikulum->delete_cpmk_mk($idcpmk, $id_mk);
    echo json_encode(['success' => true]);
  }
}
