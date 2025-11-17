<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>RPS <?= $rps->KodeMK ?> - <?= $rps->NamaMK ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 5px;
      vertical-align: top;
    }

    .noborder th,
    .noborder td {
      border: none;
    }

    .center {
      text-align: center;
    }

    .bold {
      font-weight: bold;
    }

    .header {
      text-align: start;
      font-size: 14px;
      font-weight: bold;
    }

    .sub {
      font-weight: bold;
      background: #f0f0f0;
    }

    h4 {
      text-align: center;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .indent {
      margin-left: 20px;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <table class="noborder">
    <tr>
      <td width="10%"><img src="<?= FCPATH . 'assets/img/logo.png' ?>" width="70"></td>
      <td>
        <div class="header">SEKOLAH TINGGI ILMU KOMPUTER<br>STIKOM TUNAS BANGSA PEMATANGSIANTAR</div>
        Program Studi <?= $prodi->nama_prodi ?>
      </td>
    </tr>
  </table>
  <hr style="border:1px solid #000">
  <h4>RENCANA PEMBELAJARAN SEMESTER (RPS)</h4>

  <!-- Identitas -->
  <table>
    <tr class="sub">
      <th>Mata Kuliah</th>
      <th>Bobot (SKS)</th>
      <th>Semester</th>
      <th>Tanggal Penyusunan</th>
    </tr>
    <tr>
      <td><b><?= $rps->KodeMK ?>.</b> <?= $rps->NamaMK ?></td>
      <td class="center"><?= $rps->sks_teori ?> (Teori) + <?= $rps->sks_praktek ?> (Praktek)</td>
      <td class="center"><?= $rps->semester ?></td>
      <td class="center"><?= date('d-m-Y', strtotime($rps->tanggal_penyusunan)) ?></td>
    </tr>
    <tr>
      <th>Koordinator RPS</th>
      <th>URL E-Learning</th>
      <th>Otorisasi</th>
      <th>Ketua Prodi</th>
    </tr>
    <tr>
      <td><?= $rps->koordinator_pengembang ?></td>
      <td><?= $rps->url_elearning ?: '-' ?></td>
      <td><?= $rps->otorisasi ?: '-' ?></td>
      <td>
        <?php
        $kap = $this->db->get_where('kaprodi', ['id_kaprodi' => $rps->id_kaprodi])->row();
        if ($kap) {
          $d = $this->db->get_where('dosen', ['id_dosen' => $kap->id_dosen])->row();
          echo $d ? $d->nama_dosen : '-';
        } else echo '-';
        ?>
      </td>
    </tr>
  </table>

  <!-- ===================================================
     CAPAIAN PEMBELAJARAN (CP) LULUSAN/PRODI
=================================================== -->
  <?php if (!empty($cpl)): ?>
    <table>
      <tr class="sub">
        <th colspan="2">Capaian Pembelajaran (CP) Lulusan/Prodi</th>
      </tr>
      <?php foreach ($cpl as $c): ?>
        <tr>
          <td width="20%" class="bold"><?= $c->kodecpl ?></td>
          <td>
            <?= $c->cpl ?>
            <?php if (!empty($c->cpmk_list)): ?>
              <?php foreach ($c->cpmk_list as $m): ?>
                <div class="indent">• <b><?= $m->kodecpmk ?></b>. <?= $m->cpmk ?></div>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <!-- CPMK dan Sub -->
  <table>
    <tr class="sub">
      <th colspan="2">Capaian Pembelajaran Mata Kuliah (CPMK)</th>
    </tr>
    <?php foreach ($cpmk as $c): ?>
      <tr>
        <td width="25%" class="bold"><?= $c->kode_cpmk ?></td>
        <td>
          <?= $c->deskripsi ?> [Bobot <?= $c->bobot ?>%]
          <?php
          $indikator = $this->M_rps->get_indikator_cpmk($c->id_rps_cpmk);
          foreach ($indikator as $i): ?>
            <div class="indent">• <b><?= $i->kode_indikator ?></b> <?= $i->indikator ?></div>
          <?php endforeach; ?>
          <?php
          $subs = $this->M_rps->get_subcpmk($c->id_rps_cpmk);
          foreach ($subs as $s): ?>
            <div class="indent"><b><?= $s->kode_sub ?></b>. <?= $s->sub_cpmk ?> [<?= $s->bobot ?>%]</div>
            <?php
            $subind = $this->M_rps->get_indikator_sub($s->id_subcpmk);
            foreach ($subind as $si): ?>
              <div class="indent">– <b><?= $si->kode_indikator ?></b> <?= $si->indikator ?></div>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>


  <!-- Deskripsi -->
  <table>
    <tr class="sub">
      <th>Deskripsi Mata Kuliah</th>
    </tr>
    <tr>
      <td><?= $rps->deskripsi ?: '-' ?></td>
    </tr>
  </table>

  <!-- Materi -->
  <table>
    <tr class="sub">
      <th>Materi Pembelajaran</th>
      <th>Urutan</th>
    </tr>
    <?php foreach ($materi as $m): ?>
      <tr>
        <td><?= $m->materi ?></td>
        <td class="center"><?= $m->urutan ?></td>
      </tr>
    <?php endforeach; ?>
  </table>


  <!-- Pustaka -->
  <table>
    <tr class="sub">
      <th>Kode</th>
      <th>Deskripsi</th>
      <th>Jenis</th>
    </tr>
    <?php foreach ($pustaka as $p): ?>
      <tr>
        <td class="center"><?= $p->kode_pustaka ?></td>
        <td><?= $p->pustaka ?></td>
        <td class="center"><?= $p->jenis ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <!-- Media -->
  <table>
    <tr class="sub">
      <th>Media Pembelajaran</th>
      <th>Jenis</th>
    </tr>
    <?php foreach ($media as $m): ?>
      <tr>
        <td><?= $m->media ?></td>
        <td class="center"><?= $m->jenis ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <!-- Bentuk Penilaian -->
  <table>
    <tr class="sub">
      <th>Bentuk Penilaian</th>
      <th>Keterangan</th>
      <th>Bobot (%)</th>
    </tr>
    <?php foreach ($penilaian as $p): ?>
      <tr>
        <td><?= $p->bentuk ?></td>
        <td><?= $p->keterangan ?></td>
        <td class="center"><?= $p->bobot ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <!-- Pertemuan -->
  <table>
    <tr class="sub">
      <th>Minggu</th>
      <th>CPMK</th>
      <th>Materi</th>
      <th>Media</th>
      <th>Pustaka</th>
      <th>Penilaian</th>
      <th>Sinkronus</th>
      <th>Asinkronus</th>
      <th>Keterangan</th>
    </tr>
    <?php foreach ($pertemuan as $p): ?>
      <tr>
        <td class="center"><?= $p->minggu_ke ?></td>
        <td class="center">
          <?php $c = $this->db->select('kode_cpmk')->get_where('obe_rps_cpmk', ['id_rps_cpmk' => $p->id_rps_cpmk])->row();
          echo $c ? $c->kode_cpmk : '-'; ?>
        </td>
        <td><?= $this->db->select('materi')->get_where('obe_rps_materi', ['id_materi' => $p->id_materi])->row()->materi ?? '-' ?></td>
        <td><?= $this->db->select('media')->get_where('obe_rps_media', ['id_media' => $p->id_media])->row()->media ?? '-' ?></td>
        <td><?= $this->db->select('kode_pustaka')->get_where('obe_rps_pustaka', ['id_pustaka' => $p->id_pustaka])->row()->kode_pustaka ?? '-' ?></td>
        <td><?= $this->db->select('bentuk')->get_where('obe_rps_penilaian', ['id_penilaian' => $p->id_penilaian])->row()->bentuk ?? '-' ?></td>
        <td><?= nl2br($p->sinkronus) ?></td>
        <td><?= nl2br($p->asinkronus) ?></td>
        <td><?= nl2br($p->keterangan) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <br><br>


</body>

</html>