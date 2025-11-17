<!-- Content Header -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold">Data Kurikulum</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKurikulumModal">
    <i class="bi bi-plus-circle"></i> Tambah Kurikulum
  </button>
</div>

<!-- Card Table -->
<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Kurikulum</th>
            <th>Program Studi</th>
            <th>Tahun Mulai</th>
            <th>Tahun Selesai</th>
            <th>Status</th>
            <th width="110">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($kurikulum as $k): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $k->NamaKurikulum ?></td>
              <td><?= $k->nama_prodi ?></td>
              <td><?= $k->TahunMulai ?></td>
              <td><?= $k->TahunSelesai ?></td>
              <td>
                <span class="badge bg-<?= ($k->Status == 'Aktif') ? 'success' : 'secondary' ?>">
                  <?= $k->Status ?>
                </span>
              </td>
              <td>
                <a href="<?= site_url('kurikulum/edit/' . $k->IdKurikulum) ?>" class="btn btn-sm btn-warning">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= site_url('kurikulum/delete/' . $k->IdKurikulum) ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($kurikulum)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted">Belum ada data kurikulum.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Kurikulum -->
<div class="modal fade" id="addKurikulumModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Tambah Kurikulum</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <form action="<?= site_url('kurikulum/add') ?>" method="post">

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

          <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>