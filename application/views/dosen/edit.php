<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Data Dosen</h3>
        <p class="text-subtitle text-muted">Perbarui informasi dosen di sistem.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('dosen'); ?>">Dosen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <form action="<?= site_url('dosen/edit/' . $d->id_dosen); ?>" method="post">
            <div class="form-group mb-3">
              <label for="nidn" class="form-label">NIDN</label>
              <input type="text" name="nidn" id="nidn" class="form-control" value="<?= $d->nidn; ?>" required>
            </div>

            <div class="form-group mb-3">
              <label for="nama_dosen" class="form-label">Nama Dosen</label>
              <input type="text" name="nama_dosen" id="nama_dosen" class="form-control" value="<?= $d->nama_dosen; ?>" required>
            </div>

            <div class="form-group mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="<?= $d->email; ?>" required>
            </div>

            <div class="form-group mb-3">
              <label for="fakultas_id" class="form-label">Fakultas</label>
              <select name="fakultas_id" id="fakultas_id" class="form-select" required>
                <?php foreach ($fakultas as $f): ?>
                  <option value="<?= $f->id_fakultas; ?>" <?= ($f->id_fakultas == $d->fakultas_id) ? 'selected' : ''; ?>>
                    <?= $f->nama_fakultas; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label for="prodi_id" class="form-label">Program Studi</label>
              <select name="prodi_id" id="prodi_id" class="form-select" required>
                <?php foreach ($prodi as $p): ?>
                  <option value="<?= $p->id_prodi; ?>" <?= ($p->id_prodi == $d->prodi_id) ? 'selected' : ''; ?>>
                    <?= $p->nama_prodi; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('dosen'); ?>" class="btn btn-secondary ms-2">Kembali</a>

            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>