<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Kaprodi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Kaprodi</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('kaprodi/add'); ?>" method="post">
      <div class="mb-3">
        <label>Program Studi</label>
        <select name="prodi_id" class="form-select" required>
          <option value="">-- Pilih Prodi --</option>
          <?php foreach ($prodi as $p): ?>
            <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Nama Dosen</label>
        <select name="id_dosen" class="form-select" required>
          <option value="">-- Pilih Dosen --</option>
          <?php foreach ($dosen as $d): ?>
            <option value="<?= $d->id_dosen; ?>"><?= $d->nama_dosen; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Tahun Aktif</label>
        <input type="text" name="tahun_aktif" class="form-control" placeholder="contoh: 2025" required>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('kaprodi'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>