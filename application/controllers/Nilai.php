<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nilai extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_nilai', 'nilai');

    // Pastikan helper & library ini sudah di-autoload atau load manual:
    // $this->load->helper(['url', 'form']);
    // $this->load->library('session');

    // Contoh cek login (sesuaikan dengan sistem auth kamu)
    if (!$this->session->userdata('logged_in')) {
      redirect('auth/login');
    }
  }

  private function _konversi_huruf($na)
  {
    if (!is_numeric($na)) return '-';
    if ($na >= 85) return 'A';
    if ($na >= 80) return 'A-';
    if ($na >= 75) return 'B+';
    if ($na >= 70) return 'B';
    if ($na >= 65) return 'B-';
    if ($na >= 60) return 'C+';
    if ($na >= 55) return 'C';
    if ($na >= 50) return 'D';
    return 'E';
  }

  // --- Halaman utama: pilih MK & Kelas ---
  public function index()
  {
    $nidn = $this->session->userdata('nidn_dosen'); // sesuaikan dengan session kamu

    $data['title']     = 'Input Nilai OBE';
    $data['matkul']    = $this->nilai->get_matkul_by_dosen($nidn);

    template('obe_nilai/index', $data);
  }

  // --- AJAX: ambil kelas berdasarkan MK ---
  public function ajax_get_kelas()
  {
    if (!$this->input->is_ajax_request()) show_404();

    $nidn     = $this->session->userdata('nidn_dosen');
    $kode_mk  = $this->input->post('kode_mk', TRUE);

    $kelas = $this->nilai->get_kelas_by_dosen_matkul($nidn, $kode_mk);

    echo json_encode($kelas);
  }

  // --- AJAX: load form nilai (tabel dinamis CPMK x Mahasiswa) ---
  public function ajax_load_form()
  {
    if (!$this->input->is_ajax_request()) show_404();

    $nidn        = $this->session->userdata('nidn_dosen');
    $kode_mk     = $this->input->post('kode_mk', TRUE);
    $kode_kelas  = $this->input->post('kode_kelas', TRUE);

    // Mahasiswa dalam kelas
    $mahasiswa = $this->nilai->get_mahasiswa_by_kelas($kode_kelas);

    // CPMK dari RPS untuk MK ini & dosen ini
    $cpmk = $this->nilai->get_cpmk_by_mk_dosen($kode_mk, $nidn);

    // List NIM untuk prefill nilai
    $list_nim = array_map(function ($m) {
      return $m->nim;
    }, $mahasiswa);

    $nilai_existing = $this->nilai->get_nilai_existing($nidn, $kode_mk, $list_nim);

    $data = [
      'kode_mk'        => $kode_mk,
      'kode_kelas'     => $kode_kelas,
      'mahasiswa'      => $mahasiswa,
      'cpmk'           => $cpmk,
      'nilai_existing' => $nilai_existing
    ];

    $this->load->view('obe_nilai/_form_nilai', $data);
  }

  // --- AJAX: simpan satu nilai CPMK (otomatis ketika input berubah) ---
  public function ajax_save_nilai()
  {
    if (!$this->input->is_ajax_request()) show_404();

    $nidn    = $this->session->userdata('nidn_dosen'); // PENTING: sama dgn index()
    $nim     = $this->input->post('nim', TRUE);
    $kode_mk = $this->input->post('kode_mk', TRUE);
    $id_cpmk = $this->input->post('id_cpmk', TRUE);
    $nilai   = $this->input->post('nilai', TRUE);

    if ($nidn == '' || $nim == '' || $kode_mk == '' || $id_cpmk == '') {
      echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
      return;
    }

    $data = [
      'nim'     => $nim,
      'kdmk'    => $kode_mk,
      'nidn'    => $nidn,
      'id_cpmk' => (int)$id_cpmk,
      'nilai'   => ($nilai === '' ? null : floatval($nilai)),
    ];

    $ok = $this->nilai->save_nilai_cell($data);

    if (!$ok) {
      $db_error = $this->db->error();
      echo json_encode([
        'status'  => 'error',
        'message' => 'DB Error: ' . ($db_error['message'] ?? 'tidak diketahui')
      ]);
      return;
    }

    echo json_encode([
      'status'  => 'success',
      'message' => 'Nilai tersimpan'
    ]);
  }


  // Eksport
  public function export_pdf()
  {
    $nidn       = $this->session->userdata('nidn_dosen');
    $kode_mk    = $this->input->get('kode_mk', TRUE);
    $kode_kelas = $this->input->get('kode_kelas', TRUE);

    if (!$nidn || !$kode_mk || !$kode_kelas) {
      show_error('Parameter tidak lengkap untuk export PDF', 400);
    }

    // Ambil data sama seperti ajax_load_form
    $mahasiswa = $this->nilai->get_mahasiswa_by_kelas($kode_kelas);
    $cpmk      = $this->nilai->get_cpmk_by_mk_dosen($kode_mk, $nidn);

    $list_nim = array_map(function ($m) {
      return $m->nim;
    }, $mahasiswa);

    $nilai_existing = $this->nilai->get_nilai_existing($nidn, $kode_mk, $list_nim);

    // Bangun HTML untuk PDF
    $html  = '<h3 style="text-align:center;margin:0;">Rekap Nilai OBE</h3>';
    $html .= '<p style="text-align:center;margin:0 0 10px 0;">MK: ' . htmlspecialchars($kode_mk) . ' | Kelas: ' . htmlspecialchars($kode_kelas) . '</p>';

    $html .= '<table border="1" cellpadding="4" cellspacing="0" width="100%" style="border-collapse:collapse;font-size:11px;">';
    $html .= '<thead>';
    $html .= '<tr style="background:#f2f2f2;text-align:center;">';
    $html .= '<th>No</th><th>NIM</th><th>Nama</th>';

    foreach ($cpmk as $c) {
      $html .= '<th>' . htmlspecialchars($c->kode_cpmk) . '<br><span style="font-size:9px;">Bobot: ' . (float)$c->bobot . '</span></th>';
    }

    $html .= '<th>Nilai Akhir</th><th>Huruf</th>';
    $html .= '</tr>';
    $html .= '</thead><tbody>';

    $no = 1;
    foreach ($mahasiswa as $mhs) {
      $nim   = $mhs->nim;
      $nama  = $mhs->nama;

      // Hitung NA di sisi PHP
      $totalPembobotan = 0;
      $totalBobot      = 0;

      $html .= '<tr>';
      $html .= '<td align="center">' . $no++ . '</td>';
      $html .= '<td>' . htmlspecialchars($nim) . '</td>';
      $html .= '<td>' . htmlspecialchars($nama) . '</td>';

      foreach ($cpmk as $c) {
        $idCpmk = $c->id_cpmk;
        $bobot  = (float)$c->bobot;
        $nilai  = isset($nilai_existing[$nim][$idCpmk])
          ? (float)$nilai_existing[$nim][$idCpmk]
          : 0;

        if (!empty($nilai_existing[$nim][$idCpmk])) {
          $totalPembobotan += $nilai * $bobot;
          $totalBobot      += $bobot;
        }

        $html .= '<td align="center">' . ($nilai !== 0 ? $nilai : '') . '</td>';
      }

      $na = 0;
      if ($totalBobot > 0) {
        $na = $totalPembobotan / $totalBobot;
      }
      $huruf = $this->_konversi_huruf($na);

      $html .= '<td align="center">' . ($na > 0 ? number_format($na, 2) : '') . '</td>';
      $html .= '<td align="center">' . $huruf . '</td>';
      $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // Inisialisasi Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->loadHtml($html);
    $dompdf->render();

    $filename = 'nilai_obe_' . $kode_mk . '_' . $kode_kelas . '.pdf';

    $dompdf->stream($filename, ['Attachment' => 1]); // Attachment = 1 -> langsung download
  }
  public function export_excel()
  {
    $nidn       = $this->session->userdata('nidn_dosen');
    $kode_mk    = $this->input->get('kode_mk', TRUE);
    $kode_kelas = $this->input->get('kode_kelas', TRUE);

    if (!$nidn || !$kode_mk || !$kode_kelas) {
      show_error('Parameter tidak lengkap untuk export Excel', 400);
    }

    $mahasiswa = $this->nilai->get_mahasiswa_by_kelas($kode_kelas);
    $cpmk      = $this->nilai->get_cpmk_by_mk_dosen($kode_mk, $nidn);

    $list_nim = array_map(function ($m) {
      return $m->nim;
    }, $mahasiswa);

    $nilai_existing = $this->nilai->get_nilai_existing($nidn, $kode_mk, $list_nim);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul
    $sheet->setCellValue('A1', 'Rekap Nilai OBE');
    $sheet->setCellValue('A2', 'MK: ' . $kode_mk . ' | Kelas: ' . $kode_kelas);

    // Header tabel mulai baris 4
    $row = 4;
    $col = 1; // A

    $sheet->setCellValueByColumnAndRow($col++, $row, 'No');
    $sheet->setCellValueByColumnAndRow($col++, $row, 'NIM');
    $sheet->setCellValueByColumnAndRow($col++, $row, 'Nama');

    foreach ($cpmk as $c) {
      $sheet->setCellValueByColumnAndRow($col++, $row, $c->kode_cpmk . ' (' . $c->bobot . ')');
    }

    $sheet->setCellValueByColumnAndRow($col++, $row, 'Nilai Akhir');
    $sheet->setCellValueByColumnAndRow($col++, $row, 'Huruf');

    // Isi data
    $row++;
    $no = 1;
    foreach ($mahasiswa as $mhs) {
      $col = 1;
      $nim  = $mhs->nim;
      $nama = $mhs->nama;

      $sheet->setCellValueByColumnAndRow($col++, $row, $no++);
      $sheet->setCellValueByColumnAndRow($col++, $row, $nim);
      $sheet->setCellValueByColumnAndRow($col++, $row, $nama);

      $totalPembobotan = 0;
      $totalBobot      = 0;

      foreach ($cpmk as $c) {
        $idCpmk = $c->id_cpmk;
        $bobot  = (float)$c->bobot;
        $nilai  = isset($nilai_existing[$nim][$idCpmk])
          ? (float)$nilai_existing[$nim][$idCpmk]
          : 0;

        if (!empty($nilai_existing[$nim][$idCpmk])) {
          $totalPembobotan += $nilai * $bobot;
          $totalBobot      += $bobot;
        }

        $sheet->setCellValueByColumnAndRow($col++, $row, $nilai !== 0 ? $nilai : '');
      }

      $na = 0;
      if ($totalBobot > 0) {
        $na = $totalPembobotan / $totalBobot;
      }
      $huruf = $this->_konversi_huruf($na);

      $sheet->setCellValueByColumnAndRow($col++, $row, $na > 0 ? round($na, 2) : '');
      $sheet->setCellValueByColumnAndRow($col++, $row, $huruf);

      $row++;
    }

    // Auto size kolom
    foreach (range('A', $sheet->getHighestColumn()) as $colLetter) {
      $sheet->getColumnDimension($colLetter)->setAutoSize(true);
    }

    $filename = 'nilai_obe_' . $kode_mk . '_' . $kode_kelas . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }
}
