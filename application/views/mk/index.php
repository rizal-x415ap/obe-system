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
            <li class="breadcrumb-item"><a href="<?= base_url() . $this->uri->segment(1); ?>"><?= ucfirst($this->uri->segment(1)); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= ucfirst($this->uri->segment(2)); ?></li>
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
          <button data-bs-toggle="modal" data-bs-target="#modalAddMK" type="button" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Mata Kuliah
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Jenis</th>
                <th>Program Studi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($mk as $m): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><strong><?= $m->KodeMK; ?></strong></td>
                  <td><?= $m->NamaMK; ?></td>
                  <td><?= $m->Sks; ?></td>
                  <td><?= $m->Semester; ?></td>
                  <td><?= $m->Jenis; ?></td>
                  <td><?= $m->nama_prodi; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('mk/edit/' . $m->id_mk); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('mk/delete/' . $m->id_mk); ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($mk)): ?>
                <tr>
                  <td colspan="8" class="text-center text-muted">Belum ada data Mata Kuliah.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah MK -->
  <div class="modal fade text-left" id="modalAddMK" tabindex="-1" role="dialog" aria-labelledby="labelAddMK" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <?= form_open('mk/add', ['id' => 'formAddMK']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddMK">Tambah Mata Kuliah</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Program Studi</label>
              <select name="kdprodi" class="form-select" required>
                <option value="">-- Pilih Prodi --</option>
                <?php foreach ($prodi as $r): ?>
                  <option value="<?= $r->kode_prodi; ?>"><?= $r->nama_prodi; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Kode MK</label>
              <input type="text" name="KodeMK" class="form-control" placeholder="Masukkan kode MK" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Nama Mata Kuliah</label>
              <input type="text" name="NamaMK" class="form-control" placeholder="Masukkan nama mata kuliah" required>
            </div>
            <div class="col-md-6 mb-3">
              <label>Nama Inggris (Subjects)</label>
              <input type="text" name="Subjects" class="form-control" placeholder="Masukkan nama Inggris (Subjects)">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label>SKS</label>
              <input type="number" name="Sks" class="form-control" placeholder="Masukkan SKS" required>
            </div>
            <div class="col-md-4 mb-3">
              <label>Semester</label>
              <input type="number" name="Semester" class="form-control" placeholder="Masukkan semester" required>
            </div>
            <div class="col-md-4 mb-3">
              <label>Jenis</label>
              <select name="Jenis" class="form-select">
                <option value="Wajib">Wajib</option>
                <option value="Pilihan">Pilihan</option>
              </select>
            </div>
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
  <!-- End Modal Tambah MK -->
</div>