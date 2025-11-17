<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Mata Kuliah</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Mata Kuliah (MK)</h3>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form method="post" action="<?= site_url('mk/add'); ?>">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Program Studi</label>
          <select name="kdprodi" class="form-select" required>
            <option value="">-- Pilih Prodi --</option>
            <?php foreach ($prodi as $r): ?>
              <option value="<?= $r->kode_prodi; ?>"><?= $r->nama_prodi; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label>Kode MK</label>
          <input type="text" name="KodeMK" class="form-control" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Nama Mata Kuliah</label>
          <input type="text" name="NamaMK" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Nama Inggris (Subjects)</label>
          <input type="text" name="Subjects" class="form-control">
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label>SKS</label>
          <input type="number" name="Sks" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Semester</label>
          <input type="number" name="Semester" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Jenis</label>
          <select name="Jenis" class="form-select">
            <option value="Wajib">Wajib</option>
            <option value="Pilihan">Pilihan</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('mk'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>