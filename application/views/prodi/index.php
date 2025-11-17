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
        <?php $this->load->view('partials/nav-datamaster'); ?>
      </div>
      <div class="card-body">
        <div class="text-center">
          <button data-bs-toggle="modal" data-bs-target="#modalAddProdi" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Prodi
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Prodi</th>
                <th>Nama Prodi</th>
                <th>Fakultas</th>
                <th>Jenjang</th>
                <th>Akreditasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($prodi as $p): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $p->kode_prodi; ?></td>
                  <td><?= $p->nama_prodi; ?></td>
                  <td><?= $p->nama_fakultas; ?></td>
                  <td><?= $p->jenjang; ?></td>
                  <td><?= $p->akreditasi; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('prodi/edit/' . $p->id_prodi); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('prodi/delete/' . $p->id_prodi); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah Prodi -->
  <div class="modal fade text-left" id="modalAddProdi" tabindex="-1" role="dialog" aria-labelledby="labelAddProdi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?php echo form_open('prodi/add', ['id' => 'formAddProdi']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddProdi">Tambah Program Studi</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group mb-3">
            <label for="kode_prodi" class="form-label">Kode Prodi</label>
            <input type="text" name="kode_prodi" id="kode_prodi" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label for="nama_prodi" class="form-label">Nama Prodi</label>
            <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" required>
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
            <label for="jenjang" class="form-label">Jenjang</label>
            <input type="text" name="jenjang" id="jenjang" class="form-control" value="S1">
          </div>

          <div class="form-group mb-3">
            <label for="akreditasi" class="form-label">Akreditasi</label>
            <input type="text" name="akreditasi" id="akreditasi" class="form-control" value="-">
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
  <!-- End Modal Tambah Prodi -->

</div>