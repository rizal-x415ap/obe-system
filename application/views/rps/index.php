<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Manajemen RPS</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">

  <div class="container-fluid mt-4">
    <h4>Modul RPS</h4>

    <ul class="nav nav-tabs mt-3" id="rpsTabs">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#identitas">Identitas RPS</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#detail">Detail RPS</a></li>
    </ul>

    <div class="tab-content mt-3">
      <!-- TAB 1 IDENTITAS -->
      <div class="tab-pane fade show active" id="identitas">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalIdentitas">+ Add RPS</button>
        <table id="tabelRps" class="table table-bordered table-striped">
          <thead class="table-secondary">
            <tr>
              <th>Mata Kuliah</th>
              <th>Deskripsi</th>
              <th>SKS (Teori + Praktik)</th>
              <th>Semester</th>
              <th>Koordinator</th>
              <th>Tanggal</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rps as $r): ?>
              <tr>
                <td><b><?= $r->KodeMK ?></b> - <?= $r->NamaMK ?></td>
                <td><?= substr($r->deskripsi, 0, 100) ?></td>
                <td><?= $r->sks_teori + $r->sks_praktek ?></td>
                <td><?= $r->semester ?></td>
                <td><?= $r->koordinator_pengembang ?></td>
                <td><?= $r->tanggal_penyusunan ?></td>
                <td>
                  <a href="<?= site_url('rps/detail/' . $r->id_rps) ?>" class="btn btn-sm btn-primary">Detail</a>
                  <a href="<?= site_url('rps/cetak/' . $r->id_rps) ?>" class="btn btn-sm btn-success">Print</a>
                  <a href="<?= site_url('rps/delete/' . $r->id_rps) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- TAB 2 DETAIL -->
      <div class="tab-pane fade" id="detail">
        <p>Pilih RPS pada tab "Identitas" untuk mengisi detail CPMK, Materi, Pustaka, Penilaian, Media, dan Pertemuan.</p>
      </div>
    </div>
  </div>

  <?php $this->load->view('rps/modal_identitas'); ?>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    new DataTable('#tabelRps');
  </script>
</body>

</html>