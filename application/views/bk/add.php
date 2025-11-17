<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Bahan Kajian</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Bahan Kajian (BK)</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form method="post" action="<?= site_url('bk/add'); ?>">

      <div class="mb-3">
        <label>Program Studi</label>
        <select name="kdprodi" class="form-select" required>
          <option value="">-- Pilih Prodi --</option>
          <?php foreach ($prodi as $r): ?>
            <option value="<?= $r->id_prodi; ?>"><?= $r->nama_prodi; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Kode BK</label>
        <input type="text" name="kodebk" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Nama Bahan Kajian</label>
        <input type="text" name="bahan_kajian" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="form-control"></textarea>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('bk'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>