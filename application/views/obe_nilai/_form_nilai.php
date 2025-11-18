<?php
?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <strong>Input Nilai OBE</strong><br>
      <small>Mata Kuliah: <?= htmlspecialchars($kode_mk); ?> | Kelas: <?= htmlspecialchars($kode_kelas); ?></small>
    </div>
  </div>
  <div class="card-body">

    <?php if (empty($mahasiswa)): ?>
      <div class="alert alert-warning mb-0">
        Tidak ada data mahasiswa untuk kelas ini.
      </div>
    <?php elseif (empty($cpmk)): ?>
      <div class="alert alert-warning mb-0">
        CPMK untuk mata kuliah ini belum disusun pada RPS. Silakan lengkapi dulu CPMK.
      </div>
    <?php else: ?>

      <!-- tombol export -->
      <div class="mb-3 d-flex justify-content-end gap-2">
        <a href="<?= site_url('nilai/export_pdf?kode_mk=' . urlencode($kode_mk) . '&kode_kelas=' . urlencode($kode_kelas)); ?>"
          class="btn btn-sm btn-danger"
          target="_blank">
          <!-- kalau pakai bootstrap icons -->
          <!-- <i class="bi bi-file-earmark-pdf"></i> -->
          Export PDF
        </a>

        <a href="<?= site_url('nilai/export_excel?kode_mk=' . urlencode($kode_mk) . '&kode_kelas=' . urlencode($kode_kelas)); ?>"
          class="btn btn-sm btn-success">
          <!-- <i class="bi bi-file-earmark-excel"></i> -->
          Export Excel
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle" id="tabel1">
          <thead class="table-light">
            <tr class="text-center">
              <th style="width: 70px;">No</th>
              <th style="width: 140px;">NIM</th>
              <th>Nama</th>
              <?php foreach ($cpmk as $c): ?>
                <th>
                  <?= htmlspecialchars($c->kode_cpmk); ?><br>
                  <small>Bobot: <?= (float)$c->bobot; ?>%</small>
                </th>
              <?php endforeach; ?>
              <th style="width: 110px;">Nilai Akhir</th>
              <th style="width: 80px;">Huruf</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($mahasiswa as $mhs): ?>
              <?php
              $nim  = $mhs->nim;
              $nama = $mhs->nama;
              ?>
              <tr data-nim="<?= htmlspecialchars($nim); ?>">
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($nim); ?></td>
                <td><?= htmlspecialchars($nama); ?></td>

                <?php foreach ($cpmk as $c): ?>
                  <?php
                  $idCpmk    = $c->id_cpmk;
                  $bobot     = (float)$c->bobot;
                  $nilaiCell = isset($nilai_existing[$nim][$idCpmk])
                    ? $nilai_existing[$nim][$idCpmk]
                    : '';
                  ?>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      min="0"
                      max="100"
                      class="form-control form-control-sm input-nilai-cpmk"
                      data-nim="<?= htmlspecialchars($nim); ?>"
                      data-kode-mk="<?= htmlspecialchars($kode_mk); ?>"
                      data-id-cpmk="<?= htmlspecialchars($idCpmk); ?>"
                      data-bobot="<?= $bobot; ?>"
                      value="<?= $nilaiCell !== '' ? htmlspecialchars($nilaiCell) : ''; ?>">
                  </td>
                <?php endforeach; ?>

                <td class="text-center">
                  <span class="badge bg-secondary nilai-akhir">0</span>
                </td>
                <td class="text-center">
                  <span class="badge bg-secondary nilai-huruf">-</span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php endif; ?>

  </div>
</div>