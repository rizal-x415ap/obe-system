<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit CPL</h3>
        <p class="text-subtitle text-muted">Edit data CPL.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('cpl'); ?>">CPL</a></li>
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
          <h4>Edit CPL</h4>
        </div>

        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form action="<?= site_url('cpl/edit/' . $c->idcpl); ?>" method="post">

            <div class="mb-3">
              <label>Program Studi</label>
              <select name="kdprodi" class="form-select" required>
                <?php foreach ($prodi as $p): ?>
                  <option value="<?= $p->id_prodi; ?>" <?= ($p->id_prodi == $c->kdprodi) ? 'selected' : ''; ?>>
                    <?= $p->nama_prodi; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label>Kode CPL</label>
              <input type="text" name="kodecpl" class="form-control" value="<?= $c->kodecpl; ?>" required>
            </div>

            <div class="mb-3">
              <label>Deskripsi CPL</label>
              <textarea name="cpl" rows="3" class="form-control" required><?= $c->cpl; ?></textarea>
            </div>

            <div class="d-flex justify-content-end">
              <button class="btn btn-primary">Update</button>
              <a href="<?= site_url('cpl'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>