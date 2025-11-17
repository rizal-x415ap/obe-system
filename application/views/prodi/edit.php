<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Program Studi</h3>
        <p class="text-subtitle text-muted">Edit data Program Studi.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('prodi'); ?>">Program Studi</a></li>
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
          <h4>Edit Program Studi</h4>
        </div>
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form action="<?= site_url('prodi/edit/' . $p->id_prodi); ?>" method="post">

            <div class="form-group mb-3">
              <label>Kode Prodi</label>
              <input type="text" name="kode_prodi" class="form-control" value="<?= $p->kode_prodi; ?>" required>
            </div>

            <div class="form-group mb-3">
              <label>Nama Prodi</label>
              <input type="text" name="nama_prodi" class="form-control" value="<?= $p->nama_prodi; ?>" required>
            </div>

            <div class="form-group mb-3">
              <label>Fakultas</label>
              <select name="fakultas_id" class="form-select" required>
                <?php foreach ($fakultas as $f): ?>
                  <option value="<?= $f->id_fakultas; ?>" <?= ($f->id_fakultas == $p->fakultas_id) ? 'selected' : ''; ?>>
                    <?= $f->nama_fakultas; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Jenjang</label>
              <input type="text" name="jenjang" class="form-control" value="<?= $p->jenjang; ?>">
            </div>

            <div class="form-group mb-3">
              <label>Akreditasi</label>
              <input type="text" name="akreditasi" class="form-control" value="<?= $p->akreditasi; ?>">
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('prodi'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>