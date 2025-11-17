<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Profil Lulusan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Profil Lulusan (PL)</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('pl/add'); ?>" method="post">

      <div class="mb-3">
        <label for="kdprodi" class="form-label">Program Studi</label>
        <select name="kdprodi" id="kdprodi" class="form-select" required>
          <option value="">-- Pilih Prodi --</option>
          <?php foreach ($prodi as $r): ?>
            <option value="<?= $r->id_prodi; ?>"><?= $r->nama_prodi; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="kodepl" class="form-label">Kode PL</label>
        <input type="text" name="kodepl" id="kodepl" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="pl" class="form-label">Profil Lulusan</label>
        <input type="text" name="pl" id="pl" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Tuliskan deskripsi profil lulusan..."></textarea>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('pl'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>