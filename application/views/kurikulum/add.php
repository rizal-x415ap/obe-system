<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Kurikulum</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Kurikulum</h3>
    <form action="<?= site_url('kurikulum/add') ?>" method="post" class="mt-3">
      <div class="mb-3">
        <label>Program Studi</label>
        <select name="kdprodi" class="form-select" required>
          <option value="">-- Pilih Prodi --</option>
          <?php foreach ($prodi as $r): ?>
            <option value="<?= $r->id_prodi ?>"><?= $r->nama_prodi ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Nama Kurikulum</label>
        <input type="text" name="NamaKurikulum" class="form-control" required>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Tahun Mulai</label>
          <input type="number" name="TahunMulai" class="form-control" min="2000" max="2100" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Tahun Selesai</label>
          <input type="number" name="TahunSelesai" class="form-control" min="2000" max="2100">
        </div>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="Status" class="form-select">
          <option value="Aktif">Aktif</option>
          <option value="Nonaktif">Nonaktif</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="Deskripsi" rows="3" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('kurikulum') ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>