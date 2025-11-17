<div class="card shadow-sm">
  <div class="card-header">
    <h4 class="fw-bold">Edit Kurikulum</h4>
  </div>

  <div class="card-body">
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <form action="<?= site_url('kurikulum/edit/' . $k->IdKurikulum) ?>" method="post">

      <div class="mb-3">
        <label>Program Studi</label>
        <select name="kdprodi" class="form-select" required>
          <?php foreach ($prodi as $r): ?>
            <option value="<?= $r->id_prodi ?>" <?= ($r->id_prodi == $k->kdprodi) ? 'selected' : '' ?>>
              <?= $r->nama_prodi ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Nama Kurikulum</label>
        <input type="text" name="NamaKurikulum" value="<?= $k->NamaKurikulum ?>" class="form-control" required>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Tahun Mulai</label>
          <input type="number" name="TahunMulai" value="<?= $k->TahunMulai ?>" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Tahun Selesai</label>
          <input type="number" name="TahunSelesai" value="<?= $k->TahunSelesai ?>" class="form-control">
        </div>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="Status" class="form-select">
          <option value="Aktif" <?= ($k->Status == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
          <option value="Nonaktif" <?= ($k->Status == 'Nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="Deskripsi" rows="3" class="form-control"><?= $k->Deskripsi ?></textarea>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= site_url('kurikulum/set_kurikulum') ?>" class="btn btn-secondary">Kembali</a>
      </div>

    </form>
  </div>
</div>