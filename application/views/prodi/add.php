<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Prodi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Program Studi</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('prodi/add'); ?>" method="post">
      <div class="mb-3">
        <label>Kode Prodi</label>
        <input type="text" name="kode_prodi" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Nama Prodi</label>
        <input type="text" name="nama_prodi" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Fakultas</label>
        <select name="fakultas_id" class="form-select" required>
          <option value="">-- Pilih Fakultas --</option>
          <?php foreach ($fakultas as $f): ?>
            <option value="<?= $f->id_fakultas; ?>"><?= $f->nama_fakultas; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Jenjang</label>
        <input type="text" name="jenjang" class="form-control" value="S1">
      </div>
      <div class="mb-3">
        <label>Akreditasi</label>
        <input type="text" name="akreditasi" class="form-control" value="-">
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('prodi'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>