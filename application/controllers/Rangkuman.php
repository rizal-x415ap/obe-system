<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rangkuman extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    admin_only(); // hanya admin yang bisa akses
    $this->load->model('M_rangkuman');
  }

  // halaman utama rangkuman
  public function index()
  {
    redirect('rangkuman/peta_cpl_bk_mk');
  }

  // Peta Pemenuhan CPL, BK & MK
  public function peta_cpl_bk_mk()
  {
    $data = $this->M_rangkuman->get_map_data();
    $data['title'] = 'Peta Pemenuhan CPL, BK & MK';
    template('rangkuman/peta_cpl_bk_mk', $data);
  }

  // ORGANISASI MK
  public function organisasi_mk()
  {
    $this->load->model('M_rangkuman');
    $mk = $this->M_rangkuman->get_organisasi_mk();

    // kelompokkan per semester dan kategori
    $data['semesters'] = [];
    foreach ($mk as $m) {
      $sem = $m->semester ?: 0;
      $kat = strtolower($m->kategori);

      // pastikan array semester sudah diinisialisasi
      if (!isset($data['semesters'][$sem])) {
        $data['semesters'][$sem] = [
          'list' => [],
          'total_sks' => 0,
          'total_mk'  => 0
        ];
      }

      // tambahkan MK ke kategori masing-masing
      $data['semesters'][$sem]['list'][$kat][] = $m;

      // total SKS (teori + praktek)
      $data['semesters'][$sem]['total_sks'] += ($m->sks_teori + $m->sks_praktek);
      $data['semesters'][$sem]['total_mk']++;
    }

    // total keseluruhan
    $data['grand_total'] = [
      'sks' => 0,
      'mk' => 0,
      'wajib' => 0,
      'pilihan' => 0,
      'luar' => 0
    ];

    foreach ($data['semesters'] as $sem => $v) {
      $data['grand_total']['sks'] += $v['total_sks'];
      $data['grand_total']['mk']  += $v['total_mk'];
      $data['grand_total']['wajib']  += count($v['list']['wajib'] ?? []);
      $data['grand_total']['pilihan'] += count($v['list']['pilihan'] ?? []);
      $data['grand_total']['luar']   += count($v['list']['luar'] ?? []);
    }

    $data['title'] = 'Organisasi MK';
    template('rangkuman/organisasi_mk', $data);
  }

  // PETA PEMENUHAN CPL & MK TIAP SEMESTER

  public function peta_cpl_mk_semester()
  {
    $this->load->model('M_rangkuman');
    $rows = $this->M_rangkuman->get_cpl_mk_semester();

    // bentuk struktur data: [idcpl][semester][] = MK
    $data['cpl'] = [];
    $data['semester'] = [];

    foreach ($rows as $r) {
      $sem = $r->semester ?: 0;
      if (!isset($data['cpl'][$r->idcpl])) {
        $data['cpl'][$r->idcpl] = [
          'kodecpl' => $r->kodecpl,
          'cpl' => $r->cpl,
          'mk' => []
        ];
      }
      $data['cpl'][$r->idcpl]['mk'][$sem][] = $r;
      $data['semester'][$sem][$r->idcpl][] = $r;
    }

    // hitung jumlah MK per CPL dan per semester
    $data['count_cpl'] = [];
    $data['count_sem'] = [];
    foreach ($rows as $r) {
      $sem = $r->semester ?: 0;
      if (!isset($data['count_cpl'][$r->idcpl])) $data['count_cpl'][$r->idcpl] = 0;
      if (!isset($data['count_sem'][$sem])) $data['count_sem'][$sem] = 0;
      if ($r->id_mk) {
        $data['count_cpl'][$r->idcpl]++;
        $data['count_sem'][$sem]++;
      }
    }

    $data['title'] = 'Peta Pemenuhan CPL & MK Setiap Semester';
    template('rangkuman/peta_cpl_mk_semester', $data);
  }

  // PETA PEMENUHAN INDIKATOR CPL & MK
  public function peta_indikator_cpl_mk()
  {
    $this->load->model('M_rangkuman');
    $rows = $this->M_rangkuman->get_indikator_cpl_mk();

    $data['cpl'] = [];
    $data['mk'] = [];

    // daftar CPL sebagai kolom
    foreach ($rows as $r) {
      if ($r->idcpl && !isset($data['cpl'][$r->idcpl])) {
        $data['cpl'][$r->idcpl] = [
          'kode' => $r->kodecpl,
          'idcpl' => $r->idcpl
        ];
      }
    }

    // daftar MK dan indikator CPMK sebagai isi
    foreach ($rows as $r) {
      if (!isset($data['mk'][$r->id_mk])) {
        $data['mk'][$r->id_mk] = [
          'kode' => $r->KodeMK,
          'nama' => $r->NamaMK,
          'indikator' => [],
          'count' => 0
        ];
      }
      if ($r->idcpmk) {
        $data['mk'][$r->id_mk]['indikator'][$r->idcpl][] = $r;
        $data['mk'][$r->id_mk]['count']++;
      }
    }

    $data['title'] = 'Peta Pemenuhan Indikator CPL & MK';
    template('rangkuman/peta_indikator_cpl_mk', $data);
  }

  //  Export Excell dan PDF

  public function export_excel_peta_indikator_mk()
  {
    $this->load->model('M_rangkuman');
    $rows = $this->M_rangkuman->get_indikator_cpl_mk();

    // Siapkan data seperti view
    $cpl = [];
    $mk = [];

    foreach ($rows as $r) {
      if ($r->idcpl && !isset($cpl[$r->idcpl])) {
        $cpl[$r->idcpl] = ['kode' => $r->kodecpl, 'idcpl' => $r->idcpl];
      }
      if (!isset($mk[$r->id_mk])) {
        $mk[$r->id_mk] = [
          'kode' => $r->KodeMK,
          'nama' => $r->NamaMK,
          'indikator' => [],
          'count' => 0
        ];
      }
      if ($r->idcpmk) {
        $mk[$r->id_mk]['indikator'][$r->idcpl][] = $r;
        $mk[$r->id_mk]['count']++;
      }
    }

    // Load PhpSpreadsheet
    require_once APPPATH . '../vendor/autoload.php';
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Mata Kuliah (MK)');
    $col = 'C';
    foreach ($cpl as $c) {
      $sheet->setCellValue($col . '1', $c['kode']);
      $col++;
    }
    $sheet->setCellValue($col . '1', 'Jumlah Indikator');

    // Data rows
    $rowNum = 2;
    $no = 1;
    foreach ($mk as $idm => $m) {
      $sheet->setCellValue('A' . $rowNum, $no++);
      $sheet->setCellValue('B' . $rowNum, $m['kode'] . '. ' . $m['nama']);

      $col = 'C';
      foreach ($cpl as $idcpl => $c) {
        if (!empty($m['indikator'][$idcpl])) {
          $isi = "";
          foreach ($m['indikator'][$idcpl] as $i) {
            $isi .= $i->kodecpmk . '. ' . $i->cpmk . "\n"; // multi-line
          }
          $sheet->setCellValue($col . $rowNum, trim($isi));
          $sheet->getStyle($col . $rowNum)->getAlignment()->setWrapText(true);
        } else {
          $sheet->setCellValue($col . $rowNum, '-');
        }
        $col++;
      }

      $sheet->setCellValue($col . $rowNum, $m['count']);
      $rowNum++;
    }

    // Auto width & border
    foreach (range('A', $col) as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $borderStyle = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '000000'],
        ],
      ],
    ];
    $sheet->getStyle('A1:' . $col . ($rowNum - 1))->applyFromArray($borderStyle);

    // Output ke Excel
    $filename = 'Peta_Pemenuhan_Indikator_CPL_MK.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
  }

  public function export_pdf_peta_indikator_mk()
  {
    $this->load->model('M_rangkuman');
    $rows = $this->M_rangkuman->get_indikator_cpl_mk();

    $cpl = [];
    $mk = [];

    foreach ($rows as $r) {
      if ($r->idcpl && !isset($cpl[$r->idcpl])) {
        $cpl[$r->idcpl] = ['kode' => $r->kodecpl, 'idcpl' => $r->idcpl];
      }
      if (!isset($mk[$r->id_mk])) {
        $mk[$r->id_mk] = [
          'kode' => $r->KodeMK,
          'nama' => $r->NamaMK,
          'indikator' => [],
          'count' => 0
        ];
      }
      if ($r->idcpmk) {
        $mk[$r->id_mk]['indikator'][$r->idcpl][] = $r;
        $mk[$r->id_mk]['count']++;
      }
    }

    // ===== Buat HTML untuk PDF =====
    $html = '<h3 style="text-align:center;margin-bottom:10px;">Peta Pemenuhan Indikator CPL & MK</h3>';
    $html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%" style="font-size:11px;border-collapse:collapse;">
    <thead style="background:#f2f2f2;font-weight:bold;text-align:center;">
      <tr>
        <th style="width:3%;">#</th>
        <th style="width:25%;">Mata Kuliah (MK)</th>';
    foreach ($cpl as $c) {
      $html .= '<th style="width:auto;">' . $c['kode'] . '</th>';
    }
    $html .= '<th style="width:8%;">Jumlah Indikator</th>
      </tr>
    </thead>
    <tbody>';

    $no = 1;
    foreach ($mk as $idm => $m) {
      $html .= '<tr>';
      $html .= '<td style="text-align:center;">' . $no++ . '</td>';
      $html .= '<td><b>' . $m['kode'] . '</b>. ' . $m['nama'] . '</td>';
      foreach ($cpl as $idcpl => $c) {
        $html .= '<td>';
        if (!empty($m['indikator'][$idcpl])) {
          foreach ($m['indikator'][$idcpl] as $i) {
            $html .= '<div style="margin-bottom:3px;"><b>' . $i->kodecpmk . '</b>. ' . $i->cpmk . '</div>';
          }
        } else {
          $html .= '-';
        }
        $html .= '</td>';
      }
      $html .= '<td style="text-align:center;">' . $m['count'] . '</td>';
      $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // ====== Dompdf generate ======
    // Jika pakai Composer
    require_once APPPATH . '../vendor/autoload.php';
    // Jika manual: require_once APPPATH.'third_party/dompdf/autoload.inc.php';

    $dompdf = new Dompdf\Dompdf(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('Peta_Pemenuhan_Indikator_CPL_MK.pdf', ['Attachment' => true]);
  }
}
