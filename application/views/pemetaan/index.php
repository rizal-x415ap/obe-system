<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Pemetaan Kurikulum OBE</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    .cpl-card {
      border-left: 4px solid #0d6efd;
      margin-bottom: 20px;
    }

    .cpl-header {
      background: #f1f3f5;
      padding: 10px 15px;
      font-weight: 600;
    }

    .table-pemetaan td,
    .table-pemetaan th {
      vertical-align: middle !important;
    }

    .badge-blue {
      background: #0d6efd;
    }
  </style>
</head>

<body class="bg-light">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Pemetaan Kurikulum OBE</h4>
    </div>

    <?php foreach ($pemetaan as $p): ?>
      <div class="card cpl-card">
        <div class="cpl-header d-flex justify-content-between align-items-center">
          <div><strong><?= $p->kodecpl; ?>.</strong> <?= $p->cpl; ?></div>
          <span class="badge bg-primary">CPL ID: <?= $p->idcpl; ?></span>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-pemetaan">
            <tr>
              <th width="18%">Profil Lulusan (PL)</th>
              <td><?= $p->profil ?: '<span class="text-muted">Belum dipetakan</span>'; ?></td>
              <td width="10%">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#pl<?= $p->idcpl; ?>">Tambah</button>
              </td>
            </tr>
            <tr>
              <th>Bahan Kajian (BK)</th>
              <td><?= $p->bahan_kajian ?: '<span class="text-muted">Belum dipetakan</span>'; ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#bk<?= $p->idcpl; ?>">Tambah</button>
              </td>
            </tr>
            <tr>
              <th>Mata Kuliah (MK)</th>
              <td><?= $p->matkul ?: '<span class="text-muted">Belum dipetakan</span>'; ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#mk<?= $p->idcpl; ?>">Tambah</button>
              </td>
            </tr>
            <tr>
              <th>Indikator (CPMK)</th>
              <td><?= $p->indikator ?: '<span class="text-muted">Belum dipetakan</span>'; ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#cpmk<?= $p->idcpl; ?>">Tambah</button>
              </td>
            </tr>
          </table>

          <!-- Collapse forms -->
          <div class="collapse mt-3" id="pl<?= $p->idcpl; ?>">
            <form action="<?= site_url('pemetaan/add_relation'); ?>" method="post">
              <input type="hidden" name="table" value="obe_pl_cpl">
              <input type="hidden" name="idcpl" value="<?= $p->idcpl; ?>">
              <select name="target[]" class="form-select" multiple required>
                <?php foreach ($pl as $r): ?>
                  <option value="<?= $r->idpl; ?>"><?= $r->kodepl; ?> - <?= $r->pl; ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-success btn-sm mt-2">Simpan</button>
            </form>
          </div>

          <div class="collapse mt-3" id="bk<?= $p->idcpl; ?>">
            <form action="<?= site_url('pemetaan/add_relation'); ?>" method="post">
              <input type="hidden" name="table" value="obe_cpl_bk">
              <input type="hidden" name="idcpl" value="<?= $p->idcpl; ?>">
              <select name="target[]" class="form-select" multiple required>
                <?php foreach ($bk as $r): ?>
                  <option value="<?= $r->idbk; ?>"><?= $r->kodebk; ?> - <?= $r->bahan_kajian; ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-success btn-sm mt-2">Simpan</button>
            </form>
          </div>

          <div class="collapse mt-3" id="mk<?= $p->idcpl; ?>">
            <form action="<?= site_url('pemetaan/add_relation'); ?>" method="post">
              <input type="hidden" name="table" value="obe_cpl_mk">
              <input type="hidden" name="idcpl" value="<?= $p->idcpl; ?>">
              <select name="target[]" class="form-select" multiple required>
                <?php foreach ($mk as $r): ?>
                  <option value="<?= $r->id_mk; ?>"><?= $r->KodeMK; ?> - <?= $r->NamaMK; ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-success btn-sm mt-2">Simpan</button>
            </form>
          </div>

          <div class="collapse mt-3" id="cpmk<?= $p->idcpl; ?>">
            <form action="<?= site_url('pemetaan/add_relation'); ?>" method="post">
              <input type="hidden" name="table" value="obe_cpl_cpmk">
              <input type="hidden" name="idcpl" value="<?= $p->idcpl; ?>">
              <select name="target[]" class="form-select" multiple required>
                <?php foreach ($cpmk as $r): ?>
                  <option value="<?= $r->idcpmk; ?>"><?= $r->kodecpmk; ?> - <?= $r->cpmk; ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-success btn-sm mt-2">Simpan</button>
            </form>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>