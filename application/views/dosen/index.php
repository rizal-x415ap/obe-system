<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Data Dosen</h3>
        <p class="text-subtitle text-muted">Data dosen aktif di sistem.</p>
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
        <?php $this->load->view('partials/nav-datamaster'); ?>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          <button data-bs-toggle="modal" data-bs-target="#modalAddDosen" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Dosen
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>NIDN</th>
                <th>Nama Dosen</th>
                <th>Email</th>
                <th>Fakultas</th>
                <th>Prodi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($dosen as $d): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $d->nidn; ?></td>
                  <td><?= $d->nama_dosen; ?></td>
                  <td><?= $d->email; ?></td>
                  <td><?= $d->nama_fakultas; ?></td>
                  <td><?= $d->nama_prodi; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('dosen/edit/' . $d->id_dosen); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('dosen/delete/' . $d->id_dosen); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($dosen)): ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">Belum ada data dosen.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah Dosen -->
  <div class="modal fade text-left" id="modalAddDosen" tabindex="-1" role="dialog" aria-labelledby="labelAddDosen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?php echo form_open('dosen/add', ['id' => 'formAddDosen']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddDosen">Tambah Dosen</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">

          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
          <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
          <?php endif; ?>

          <div class="alert alert-info">
            <strong>Catatan:</strong> Akun login dosen akan dibuat otomatis.<br>
            Username = NIDN &nbsp; | &nbsp; Password = NIDN
          </div>

          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group mb-3">
            <label for="nidn" class="form-label">NIDN</label>
            <input type="text" name="nidn" id="nidn" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label for="nama_dosen" class="form-label">Nama Dosen</label>
            <input type="text" name="nama_dosen" id="nama_dosen" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label for="fakultas_id" class="form-label">Fakultas</label>
            <select name="fakultas_id" id="fakultas_id" class="form-select" required>
              <option value="">-- Pilih Fakultas --</option>
              <?php foreach ($fakultas as $f): ?>
                <option value="<?= $f->id_fakultas; ?>"><?= $f->nama_fakultas; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="prodi_id" class="form-label">Program Studi</label>
            <select name="prodi_id" id="prodi_id" class="form-select" required>
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $p): ?>
                <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
              <?php endforeach; ?>
            </select>
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
  <!-- End Modal Tambah Dosen -->
</div>