<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Data <?= $title; ?>.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url($this->uri->segment(1)); ?>"><?= $this->uri->segment(1); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->uri->segment(2); ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <?php $this->load->view('partials/nav-data'); ?>
      </div>

      <div class="card-body">

        <div class="text-center mb-3">
          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCpmk">
            <i class="bi bi-plus-square"></i> Tambah Indikator
          </button>
        </div>

        <?php foreach ($grouped as $g): ?>
          <?php
          // Hitung total bobot indikator per CPL
          $totalBobot = 0;
          if (!empty($g['indikator'])) {
            foreach ($g['indikator'] as $ik) {
              $totalBobot += (int)$ik['bobot'];
            }
          }
          ?>

          <div class="card mb-3 border border-success">
            <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
              <div><strong><?= $g['kodecpl']; ?>.</strong> <?= $g['cpl']; ?></div>
              <span class="badge bg-light text-dark">Total Bobot: <?= $totalBobot; ?>%</span>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-bordered mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width:10%">Kode</th>
                      <th>Indikator (CPMK)</th>
                      <th>Mata Kuliah</th>
                      <th style="width:10%">Bobot</th>
                      <th style="width:15%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($g['indikator'])): ?>
                      <?php foreach ($g['indikator'] as $ik): ?>
                        <tr>
                          <td><strong><?= $ik['kodecpmk']; ?></strong></td>
                          <td><?= $ik['cpmk']; ?></td>
                          <td><?= $ik['NamaMK']; ?></td>
                          <td class="text-center fw-bold"><?= $ik['bobot']; ?>%</td>
                          <td class="text-center">
                            <a href="<?= site_url('cpmk/edit/' . $ik['idcpmk']); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= site_url('cpmk/delete/' . $ik['idcpmk']); ?>" class="btn btn-sm btn-danger"
                              onclick="return confirm('Hapus indikator ini?')"><i class="bi bi-trash"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada indikator.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php endforeach; ?>


      </div>
    </div>
  </section>

  <!-- Modal Tambah CPMK -->
  <div class="modal fade text-left" id="modalAddCpmk" tabindex="-1" aria-labelledby="labelAddCpmk">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?= form_open('cpmk/add'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddCpmk">Tambah Indikator CPL (CPMK)</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="mb-3">
            <label>Capaian Pembelajaran Lulusan (CPL)</label>
            <select name="idcpl" class="form-select" required>
              <option value="">-- Pilih CPL --</option>
              <?php foreach ($cpl as $c): ?>
                <option
                  class="text-truncate"
                  value="<?= $c->idcpl; ?>"
                  title="<?= $c->kodecpl; ?> - <?= $c->cpl; ?>"> <?= $c->kodecpl; ?> - <?= (strlen($c->cpl) > 45) ? substr($c->cpl, 0, 40) . '...' : $c->cpl; ?>
                </option> <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Mata Kuliah</label>
            <select name="id_mk" class="form-select" required>
              <option value="">-- Pilih Mata Kuliah --</option>
              <?php foreach ($mk as $m): ?>
                <option value="<?= $m->id_mk; ?>"><?= $m->NamaMK; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Kode CPMK</label>
            <input type="text" name="kodecpmk" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Deskripsi CPMK</label>
            <textarea name="cpmk" rows="3" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label>Bobot (%)</label>
            <input type="number" name="bobot" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>