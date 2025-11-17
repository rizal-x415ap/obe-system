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
            <li class="breadcrumb-item">
              <a href="<?= base_url($this->uri->segment(1)); ?>">
                <?= $this->uri->segment(1); ?>
              </a>
            </li>
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
          <button data-bs-toggle="modal" data-bs-target="#modalAddPL" type="button" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah PL
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode PL</th>
                <th>Profil Lulusan</th>
                <th>Program Studi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($pl as $p): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><strong><?= $p->kodepl; ?></strong></td>
                  <td><?= $p->pl; ?></td>
                  <td><?= $p->nama_prodi; ?></td>
                  <td><?= $p->deskripsi; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('pl/edit/' . $p->idpl); ?>" class="btn btn-sm btn-warning">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= site_url('pl/delete/' . $p->idpl); ?>" class="btn btn-sm btn-danger"
                      onclick="return confirm('Hapus data ini?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($pl)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">Belum ada data Profil Lulusan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </section>


  <!-- Modal Tambah PL -->
  <div class="modal fade text-left" id="modalAddPL" tabindex="-1" role="dialog" aria-labelledby="labelAddPL" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?= form_open('pl/add', ['id' => 'formAddPL']); ?>
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="labelAddPL">Tambah Profil Lulusan</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group mb-3">
            <label>Program Studi</label>
            <select name="kdprodi" class="form-select" required>
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $r): ?>
                <option value="<?= $r->id_prodi; ?>"><?= $r->nama_prodi; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Kode PL</label>
            <input type="text" name="kodepl" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Profil Lulusan</label>
            <input type="text" name="pl" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="form-control"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary ms-1">Simpan</button>
        </div>

      </div>
      </form>
    </div>
  </div>
  <!-- End Modal -->
</div>