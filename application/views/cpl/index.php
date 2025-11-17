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
          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCpl">
            <i class="bi bi-plus-square"></i> Tambah CPL
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode CPL</th>
                <th>CPL</th>
                <th>Program Studi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($cpl as $c): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><strong><?= $c->kodecpl; ?></strong></td>
                  <td><?= $c->cpl; ?></td>
                  <td><?= $c->nama_prodi; ?></td>
                  <td>
                    <a href="<?= site_url('cpl/edit/' . $c->idcpl); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a onclick="return confirm('Hapus data ini?')" href="<?= site_url('cpl/delete/' . $c->idcpl); ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($cpl)): ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">Belum ada data CPL.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah CPL -->
  <div class="modal fade text-left" id="modalAddCpl" tabindex="-1" aria-labelledby="labelAddCpl">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?= form_open('cpl/add'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddCpl">Tambah CPL</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="mb-3">
            <label>Program Studi</label>
            <select name="kdprodi" class="form-select" required>
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $p): ?>
                <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Kode CPL</label>
            <input type="text" name="kodecpl" class="form-control" placeholder="Misal: CPL1" required>
          </div>

          <div class="mb-3">
            <label>Deskripsi CPL</label>
            <textarea name="cpl" class="form-control" rows="3" required placeholder="Tuliskan uraian CPL..."></textarea>
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