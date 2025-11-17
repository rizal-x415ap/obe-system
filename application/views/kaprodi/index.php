<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?php echo $title; ?></h3>
        <p class="text-subtitle text-muted">Data <?php echo $title; ?>.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>"><?php echo $this->uri->segment(1); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->uri->segment(2); ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <?php $this->load->view('partials/nav-datamaster'); ?>
      </div>
      <div class="card-body">

        <div class="text-center mb-3">
          <button data-bs-toggle="modal" data-bs-target="#modalAddKaprodi"
            type="button" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Kaprodi
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Program Studi</th>
                <th>Nama Dosen</th>
                <th>Tahun Aktif</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($kaprodi as $k): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $k->nama_prodi; ?></td>
                  <td><?= $k->nama_dosen; ?></td>
                  <td><?= $k->tahun_aktif; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('kaprodi/edit/' . $k->id_kaprodi); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('kaprodi/delete/' . $k->id_kaprodi); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($kaprodi)): ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">Belum ada data kaprodi.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </section>

  <!-- Modal Tambah Kaprodi -->
  <div class="modal fade text-left" id="modalAddKaprodi" tabindex="-1" role="dialog" aria-labelledby="labelAddKaprodi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?php echo form_open('kaprodi/add', ['id' => 'formAddKaprodi']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddKaprodi">Tambah Kaprodi</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group mb-3">
            <label>Program Studi</label>
            <select name="prodi_id" class="form-select" required>
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $p): ?>
                <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Nama Dosen</label>
            <select name="id_dosen" class="form-select" required>
              <option value="">-- Pilih Dosen --</option>
              <?php foreach ($dosen as $d): ?>
                <option value="<?= $d->id_dosen; ?>"><?= $d->nama_dosen; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Tahun Aktif</label>
            <input type="text" name="tahun_aktif" class="form-control" placeholder="Contoh: 2025" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">
            <span class="fs-7 fs-sm-6">Tutup</span>
          </button>
          <button type="submit" class="btn btn-primary ms-1">
            <span class="fs-7 fs-sm-6">Simpan</span>
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <!-- End Modal Tambah Kaprodi -->

</div>