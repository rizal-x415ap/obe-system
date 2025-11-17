<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Kaprodi</h3>
        <p class="text-subtitle text-muted">Edit data Kaprodi.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('kaprodi'); ?>">Kaprodi</a></li>
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
          <h4>Edit Kaprodi</h4>
        </div>
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <form action="<?= site_url('kaprodi/edit/' . $k->id_kaprodi); ?>" method="post">

            <div class="form-group mb-3">
              <label>Program Studi</label>
              <select name="prodi_id" class="form-select" required>
                <?php foreach ($prodi as $p): ?>
                  <option value="<?= $p->id_prodi; ?>" <?= ($p->id_prodi == $k->prodi_id) ? 'selected' : ''; ?>>
                    <?= $p->nama_prodi; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Nama Dosen</label>
              <select name="id_dosen" class="form-select" required>
                <?php foreach ($dosen as $d): ?>
                  <option value="<?= $d->id_dosen; ?>" <?= ($d->id_dosen == $k->id_dosen) ? 'selected' : ''; ?>>
                    <?= $d->nama_dosen; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Tahun Aktif</label>
              <input type="text" name="tahun_aktif" class="form-control" value="<?= $k->tahun_aktif; ?>" required>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('kaprodi'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>