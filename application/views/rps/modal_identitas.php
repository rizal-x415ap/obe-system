<div class="modal fade" id="modalIdentitas" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= site_url('rps/add') ?>">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Identitas RPS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Mata Kuliah</label>
            <select name="id_mk" class="form-select" required>
              <option value="" disabled selected>Pilih Matakuliah</option>
              <?php foreach ($matakuliah as $mk): ?>
                <option value="<?= $mk->id_mk ?>"><?= $mk->KodeMK ?> - <?= $mk->NamaMK ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>Deskripsi Mata Kuliah</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label>Koordinator Pengembang RPS</label>
            <select name="koordinator" class="form-select" required>
              <?php foreach ($dosen as $d): ?>
                <option value="<?= $d->nama_dosen ?>"><?= $d->nama_dosen ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>URL E-Learning</label>
            <input type="text" name="url_elearning" class="form-control">
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Tanggal Penyusunan</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-6">
              <label>Otorisasi</label>
              <input type="text" name="otorisasi" class="form-control">
            </div>
          </div>
          <div class="mt-3">
            <label>Ketua Prodi</label>
            <select name="id_kaprodi" class="form-select" required>
              <?php foreach ($kaprodi as $k): ?>
                <option value="<?= $k->id_kaprodi ?>"><?= $k->nama_dosen ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>