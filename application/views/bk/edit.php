<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Bahan Kajian</h3>
        <p class="text-subtitle text-muted">Edit data Bahan Kajian.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('bk'); ?>">Bahan Kajian</a></li>
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
          <h4>Edit Bahan Kajian</h4>
        </div>
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form action="<?= site_url('bk/edit/' . $bk->idbk); ?>" method="post">

            <div class="form-group mb-3">
              <label>Program Studi</label>
              <select name="kdprodi" class="form-select" required>
                <?php foreach ($prodi as $r): ?>
                  <option value="<?= $r->id_prodi; ?>" <?= ($r->id_prodi == $bk->kdprodi) ? 'selected' : ''; ?>>
                    <?= $r->nama_prodi; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Kode BK</label>
              <input type="text" name="kodebk" value="<?= $bk->kodebk; ?>" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Nama Bahan Kajian</label>
              <input type="text" name="bahan_kajian" value="<?= $bk->bahan_kajian; ?>" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi" rows="3" class="form-control"><?= $bk->deskripsi; ?></textarea>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('bk'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>