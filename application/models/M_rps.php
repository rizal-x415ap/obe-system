<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rps extends CI_Model
{
  /* ==============================
     IDENTITAS RPS
  ============================== */
  public function get_all()
  {
    $this->db->select('r.*, mk.KodeMK, mk.NamaMK,
                       km.sks_teori, km.sks_praktek, km.semester');
    $this->db->from('obe_rps r');
    $this->db->join('mata_kuliah mk', 'mk.id_mk=r.id_mk');
    $this->db->join('kurikulum_mk km', 'km.id_mk=mk.id_mk', 'left');
    return $this->db->get()->result();
  }

  public function get_by_id($id)
  {
    $this->db->select('r.*, mk.KodeMK, mk.NamaMK,
                       km.sks_teori, km.sks_praktek, km.semester');
    $this->db->from('obe_rps r');
    $this->db->join('mata_kuliah mk', 'mk.id_mk=r.id_mk');
    $this->db->join('kurikulum_mk km', 'km.id_mk=mk.id_mk', 'left');
    $this->db->where('r.id_rps', $id);
    return $this->db->get()->row();
  }

  public function get_mk_susun()
  {
    // ambil nidn dosen dari session
    $nid = $this->session->userdata('nidn_dosen');
    // ambil tahun akademik aktif
    $thn = $this->db->get('ThnAkademik_aktif')->row();
    $thn_aktif = $thn->Thnakademik;
    $semester_aktif = $thn->Semester;

    $this->db->select('
        mk.id_mk,
        mk.KodeMK,
        mk.NamaMK,
        mk.Sks,
        mk.Semester as SemesterMK
    ');
    $this->db->from('obe_matriks m');
    $this->db->join('mata_kuliah mk', 'mk.KodeMK = m.KdMK', 'left');
    // filter berdasarkan dosen login
    $this->db->where('m.KdDosen', $nid);
    // filter berdasarkan tahun akademik aktif
    $this->db->where('m.ThnAjaran', $thn_aktif);
    $this->db->where('m.Semester', $semester_aktif);
    // buang data mk yang NULL
    $this->db->where('mk.KodeMK IS NOT NULL', null, false);
    // hanya tampilkan MK unik
    $this->db->group_by('mk.KodeMK');
    $this->db->order_by('mk.KodeMK', 'ASC');

    return $this->db->get()->result();
  }

  public function get_dosen()
  {
    return $this->db->get('dosen')->result();
  }

  public function get_kaprodi()
  {
    $this->db->select('k.id_kaprodi,d.nama_dosen');
    $this->db->from('kaprodi k');
    $this->db->join('dosen d', 'd.id_dosen=k.id_dosen');
    return $this->db->get()->result();
  }

  public function insert_identitas($data)
  {
    $insert = [
      'id_mk' => $data['id_mk'],
      'deskripsi' => $data['deskripsi'],
      'koordinator_pengembang' => $data['koordinator'],
      'url_elearning' => $data['url_elearning'],
      'tanggal_penyusunan' => $data['tanggal'],
      'otorisasi' => $data['otorisasi'],
      'id_kaprodi' => $data['id_kaprodi'],
      'id_dosen' => $this->session->userdata('id_dosen')
    ];
    return $this->db->insert('obe_rps', $insert);
  }

  public function delete_rps($id)
  {
    return $this->db->delete('obe_rps', ['id_rps' => $id]);
  }

  /* ==============================
     CPMK & SUBCPMK
  ============================== */
  public function get_rps_cpmk($id)
  {
    $this->db->where('id_rps', $id);
    $this->db->order_by('id_rps_cpmk', 'ASC');
    return $this->db->get('obe_rps_cpmk')->result();
  }

  public function insert_cpmk($data)
  {
    $ins = [
      'id_rps' => $data['id_rps'],
      'kode_cpmk' => $data['kode_cpmk'],
      'deskripsi' => $data['deskripsi'],
      'bobot' => $data['bobot']
    ];
    return $this->db->insert('obe_rps_cpmk', $ins);
  }

  public function update_cpmk($id, $data)
  {
    $this->db->where('id_rps_cpmk', $id);
    return $this->db->update('obe_rps_cpmk', [
      'kode_cpmk' => $data['kode_cpmk'],
      'deskripsi' => $data['deskripsi'],
      'bobot' => $data['bobot']
    ]);
  }

  public function delete_cpmk($id)
  {
    return $this->db->delete('obe_rps_cpmk', ['id_rps_cpmk' => $id]);
  }

  public function get_subcpmk($id_cpmk)
  {
    return $this->db->get_where('obe_rps_subcpmk', ['id_rps_cpmk' => $id_cpmk])->result();
  }

  public function insert_subcpmk($data)
  {
    $ins = [
      'id_rps_cpmk' => $data['id_rps_cpmk'],
      'kode_sub' => $data['kode_sub'],
      'sub_cpmk' => $data['sub_cpmk'],
      'bobot' => $data['bobot']
    ];
    return $this->db->insert('obe_rps_subcpmk', $ins);
  }

  public function update_subcpmk($id, $data)
  {
    $this->db->where('id_subcpmk', $id);
    return $this->db->update('obe_rps_subcpmk', [
      'kode_sub' => $data['kode_sub'],
      'sub_cpmk' => $data['sub_cpmk'],
      'bobot' => $data['bobot']
    ]);
  }

  public function delete_subcpmk($id)
  {
    return $this->db->delete('obe_rps_subcpmk', ['id_subcpmk' => $id]);
  }

  /* ==============================
     INDIKATOR CPMK / SUBCPMK
  ============================== */
  public function get_indikator_cpmk($id_cpmk)
  {
    return $this->db->get_where('obe_rps_indikator', ['id_rps_cpmk' => $id_cpmk])->result();
  }

  public function get_indikator_sub($id_sub)
  {
    return $this->db->get_where('obe_rps_indikator', ['id_subcpmk' => $id_sub])->result();
  }

  public function insert_indikator($data)
  {
    return $this->db->insert('obe_rps_indikator', $data);
  }

  public function update_indikator($id, $data)
  {
    $this->db->where('id_indikator', $id);
    return $this->db->update('obe_rps_indikator', $data);
  }

  public function delete_indikator($id)
  {
    return $this->db->delete('obe_rps_indikator', ['id_indikator' => $id]);
  }

  /* ==============================
     DETAIL LAIN (materi, pustaka, media, penilaian, pertemuan)
  ============================== */
  public function get_rps_materi($id)
  {
    return $this->db->get_where('obe_rps_materi', ['id_rps' => $id])->result();
  }
  public function insert_materi($d)
  {
    return $this->db->insert('obe_rps_materi', $d);
  }
  public function delete_materi($id)
  {
    return $this->db->delete('obe_rps_materi', ['id_materi' => $id]);
  }

  public function get_rps_pustaka($id)
  {
    return $this->db->get_where('obe_rps_pustaka', ['id_rps' => $id])->result();
  }
  public function insert_pustaka($d)
  {
    return $this->db->insert('obe_rps_pustaka', $d);
  }
  public function delete_pustaka($id)
  {
    return $this->db->delete('obe_rps_pustaka', ['id_pustaka' => $id]);
  }

  public function get_rps_media($id)
  {
    return $this->db->get_where('obe_rps_media', ['id_rps' => $id])->result();
  }
  public function insert_media($d)
  {
    return $this->db->insert('obe_rps_media', $d);
  }
  public function delete_media($id)
  {
    return $this->db->delete('obe_rps_media', ['id_media' => $id]);
  }

  public function get_rps_penilaian($id)
  {
    return $this->db->get_where('obe_rps_penilaian', ['id_rps' => $id])->result();
  }
  public function insert_penilaian($d)
  {
    return $this->db->insert('obe_rps_penilaian', $d);
  }
  public function delete_penilaian($id)
  {
    return $this->db->delete('obe_rps_penilaian', ['id_penilaian' => $id]);
  }

  public function get_rps_pertemuan($id)
  {
    return $this->db->get_where('obe_rps_pertemuan', ['id_rps' => $id])->result();
  }
  public function insert_pertemuan($d)
  {
    return $this->db->insert('obe_rps_pertemuan', $d);
  }
  public function delete_pertemuan($id)
  {
    return $this->db->delete('obe_rps_pertemuan', ['id_pertemuan' => $id]);
  }

  /* ==============================
     CETAK PDF
  ============================== */
  public function get_full($id)
  {
    $this->db->select('r.*, mk.KodeMK, mk.NamaMK,
                       km.sks_teori, km.sks_praktek, km.semester');
    $this->db->from('obe_rps r');
    $this->db->join('mata_kuliah mk', 'mk.id_mk=r.id_mk');
    $this->db->join('kurikulum_mk km', 'km.id_mk=mk.id_mk', 'left');
    $this->db->where('r.id_rps', $id);
    return $this->db->get()->row();
  }
  public function get_prodi_rps($id)
  {
    $this->db->select('
        r.id_rps,
        r.id_mk,
        mk.KodeMK,
        mk.NamaMK,
        mk.kdprodi,
        p.nama_prodi
    ');
    $this->db->from('obe_rps r');
    $this->db->join('mata_kuliah mk', 'mk.id_mk = r.id_mk', 'left');
    $this->db->join('prodi p', 'p.kode_prodi = mk.kdprodi', 'left');
    $this->db->where('r.id_rps', $id);

    return $this->db->get()->row();
  }

  public function get_cpl_by_mk($id_mk)
  {
    // Ambil semua CPL yang terhubung dengan MK
    $this->db->select('c.idcpl, c.kodecpl, c.cpl');
    $this->db->from('obe_cpl_mk cm');
    $this->db->join('obe_cpl c', 'c.idcpl = cm.idcpl');
    $this->db->where('cm.id_mk', $id_mk);
    $this->db->order_by('c.kodecpl', 'ASC');
    $cpl_list = $this->db->get()->result();

    $result = [];

    foreach ($cpl_list as $cpl) {
      // Ambil CPMK yang benar-benar terhubung lewat CPL dan MK tersebut
      $this->db->select('m.idcpmk, m.kodecpmk, m.cpmk');
      $this->db->from('obe_cpl_cpmk rel');
      $this->db->join('obe_cpmk m', 'm.idcpmk = rel.idcpmk');
      $this->db->join('obe_cpl_mk cm', 'cm.idcpl = rel.idcpl');
      $this->db->where('rel.idcpl', $cpl->idcpl);
      $this->db->where('cm.id_mk', $id_mk);
      $this->db->order_by('m.kodecpmk', 'ASC');
      $cpl->cpmk_list = $this->db->get()->result();

      $result[] = $cpl;
    }

    return $result;
  }
}
