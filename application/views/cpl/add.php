<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah CPL</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Capaian Pembelajaran Lulusan (CPL)</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('cpl/add'); ?>" method="post">

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
        <label>Kode CPL</label>
        <input type="text" name="kodecpl" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Deskripsi CPL</label>
        <textarea name="cpl" rows="3" class="form-control" placeholder="Tuliskan uraian CPL..." required></textarea>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('cpl'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>