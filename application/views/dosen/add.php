<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Dosen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Dosen</h3>
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="alert alert-info">
      <strong>Catatan:</strong> Akun login dosen akan dibuat otomatis.<br>
      Username = NIDN &nbsp; | &nbsp; Password = NIDN
    </div>

    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('dosen/add'); ?>" method="post">
      <div class="mb-3">
        <label>NIDN</label>
        <input type="text" name="nidn" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Nama Dosen</label>
        <input type="text" name="nama_dosen" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
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
        <label>Program Studi</label>
        <select name="prodi_id" class="form-select" required>
          <option value="">-- Pilih Prodi --</option>
          <?php foreach ($prodi as $p): ?>
            <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('dosen'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>