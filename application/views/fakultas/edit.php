<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Fakultas</h3>
        <p class="text-subtitle text-muted">Edit data Fakultas.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('fakultas'); ?>">Fakultas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Fakultas</h4>
        </div>
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form action="<?= site_url('fakultas/edit/' . $f->id_fakultas); ?>" method="post">
            <div class="form-group mb-3">
              <label>Kode Fakultas</label>
              <input type="text" name="kode_fakultas" class="form-control" value="<?= $f->kode_fakultas; ?>" required>
            </div>
            <div class="form-group mb-3">
              <label>Nama Fakultas</label>
              <input type="text" name="nama_fakultas" class="form-control" value="<?= $f->nama_fakultas; ?>" required>
            </div>
            <div class="form-group mb-3">
              <label>Universitas</label>
              <input type="text" name="universitas" class="form-control" value="<?= $f->universitas; ?>" required>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('fakultas'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>