<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Indikator CPL (CPMK)</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-4">
    <h4>Tambah Indikator CPL (CPMK)</h4>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form method="post" action="<?= site_url('cpmk/add'); ?>">

      <div class="mb-3">
        <label for="idcpl">Capaian Pembelajaran Lulusan (CPL)</label>
        <select name="idcpl" class="form-select" required>
          <option value="">-- Pilih CPL --</option>
          <?php foreach ($cpl as $c): ?>
            <option value="<?= $c->idcpl; ?>"><?= $c->kodecpl; ?> - <?= $c->cpl; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="id_mk">Mata Kuliah</label>
        <select name="id_mk" class="form-select" required>
          <option value="">-- Pilih Mata Kuliah --</option>
          <?php foreach ($mk as $m): ?>
            <option value="<?= $m->id_mk; ?>"><?= $m->NamaMK; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Kode Indikator (CPMK)</label>
        <input type="text" name="kodecpmk" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Deskripsi Indikator (CPMK)</label>
        <textarea name="cpmk" rows="3" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label>Bobot (%)</label>
        <input type="number" name="bobot" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="<?= site_url('cpmk'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>