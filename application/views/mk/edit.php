<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Mata Kuliah</h3>
        <p class="text-subtitle text-muted">Edit data Mata Kuliah.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('mk'); ?>">Mata Kuliah</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Edit Mata Kuliah</h4>
        </div>
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form action="<?= site_url('mk/edit/' . $m->id_mk); ?>" method="post">

            <div class="mb-3">
              <label>Program Studi</label>
              <select name="kdprodi" class="form-select" required>
                <?php foreach ($prodi as $r): ?>
                  <option value="<?= $r->kode_prodi; ?>" <?= ($r->kode_prodi == $m->kdprodi) ? 'selected' : ''; ?>><?= $r->nama_prodi; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Kode MK</label>
                <input type="text" name="KodeMK" class="form-control" value="<?= $m->KodeMK; ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Nama Inggris (Subjects)</label>
                <input type="text" name="Subjects" class="form-control" value="<?= $m->Subjects; ?>">
              </div>
            </div>

            <div class="mb-3">
              <label>Nama Mata Kuliah</label>
              <input type="text" name="NamaMK" class="form-control" value="<?= $m->NamaMK; ?>" required>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label>SKS</label>
                <input type="number" name="Sks" class="form-control" value="<?= $m->Sks; ?>" required>
              </div>
              <div class="col-md-4 mb-3">
                <label>Semester</label>
                <input type="number" name="Semester" class="form-control" value="<?= $m->Semester; ?>" required>
              </div>
              <div class="col-md-4 mb-3">
                <label>Jenis</label>
                <select name="Jenis" class="form-select">
                  <option value="Wajib" <?= ($m->Jenis == 'Wajib') ? 'selected' : ''; ?>>Wajib</option>
                  <option value="Pilihan" <?= ($m->Jenis == 'Pilihan') ? 'selected' : ''; ?>>Pilihan</option>
                </select>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="<?= site_url('mk'); ?>" class="btn btn-secondary ms-2">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>