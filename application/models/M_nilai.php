<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_nilai extends CI_Model
{
  // --- Dropdown: Mata Kuliah yang diampu dosen (berdasarkan matriks) ---
  public function get_matkul_by_dosen($nidn)
  {
    $this->db->select('mk.KodeMK AS kode_mk, mk.NamaMK');
    $this->db->from('obe_matriks m');
    $this->db->join('mata_kuliah mk', 'mk.KodeMK = m.KdMK', 'inner');

    // HANYA cek: MK sudah punya RPS & CPMK
    $this->db->join('obe_rps r', 'r.id_mk = mk.id_mk', 'inner');
    $this->db->join('obe_rps_cpmk rc', 'rc.id_rps = r.id_rps', 'inner');

    // Filter dosen yang login dari matriks
    $this->db->where('m.KdDosen', $nidn);

    $this->db->group_by('mk.KodeMK, mk.NamaMK');
    $this->db->order_by('mk.NamaMK', 'ASC');

    return $this->db->get()->result();
  }


  // --- Dropdown: Kelas berdasarkan MK & dosen ---
  public function get_kelas_by_dosen_matkul($nidn, $kode_mk)
  {
    $this->db->select('m.KdKelas AS kode_kelas, k.nmkelas');
    $this->db->from('obe_matriks m');
    $this->db->join('obe_kelas k', 'k.kodekelas = m.KdKelas', 'inner');

    $this->db->where('m.KdDosen', $nidn);
    $this->db->where('m.KdMK', $kode_mk);

    $this->db->group_by('m.KdKelas, k.nmkelas');
    $this->db->order_by('k.nmkelas', 'ASC');

    return $this->db->get()->result();
  }



  // --- Data mahasiswa dalam satu kelas ---
  public function get_mahasiswa_by_kelas($kode_kelas)
  {
    $this->db->from('obe_mahasiswa');
    $this->db->where('kodekelas', $kode_kelas);
    $this->db->order_by('nim', 'ASC');
    return $this->db->get()->result();
  }

  // --- Data CPMK berdasarkan MK & dosen (dari RPS) ---
  public function get_cpmk_by_mk_dosen($kode_mk, $nidn)
  {
    $this->db->select('rc.id_rps_cpmk AS id_cpmk, rc.kode_cpmk, rc.deskripsi, rc.bobot');
    $this->db->from('obe_rps_cpmk rc');
    $this->db->join('obe_rps r', 'r.id_rps = rc.id_rps', 'inner');
    $this->db->join('mata_kuliah mk', 'mk.id_mk = r.id_mk', 'inner');

    // Filter berdasarkan KodeMK saja
    $this->db->where('mk.KodeMK', $kode_mk);

    // $nidn tidak dipakai di sini, karena tabel rps kamu tidak punya kolom nidn

    $this->db->order_by('rc.kode_cpmk', 'ASC');
    return $this->db->get()->result();
  }


  // --- Nilai yang sudah pernah diinput (untuk pre-fill form) ---
  public function get_nilai_existing($nidn, $kode_mk, $list_nim = [])
  {
    if (empty($list_nim)) return [];

    $this->db->from('obe_nilai');
    $this->db->where('nidn', $nidn);
    $this->db->where('kdmk', $kode_mk);
    $this->db->where_in('nim', $list_nim);
    $query = $this->db->get()->result();

    // Disusun: $result[nim][id_cpmk] = nilai
    $result = [];
    foreach ($query as $row) {
      $result[$row->nim][$row->id_cpmk] = (float)$row->nilai;
    }
    return $result;
  }

  // --- Insert / Update satu sel nilai CPMK ---
  public function save_nilai_cell($data)
  {
    $where = [
      'nim'     => $data['nim'],
      'kdmk'    => $data['kdmk'],
      'nidn'    => $data['nidn'],
      'id_cpmk' => $data['id_cpmk'],
    ];

    $existing = $this->db->get_where('obe_nilai', $where)->row();

    if ($existing) {
      $this->db->where('id_nilai', $existing->id_nilai);
      return $this->db->update('obe_nilai', [
        'nilai'      => $data['nilai'],
        'updated_at' => date('Y-m-d H:i:s')
      ]);
    } else {
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');
      return $this->db->insert('obe_nilai', $data);
    }
  }
}
