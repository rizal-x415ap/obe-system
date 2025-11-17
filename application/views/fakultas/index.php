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
        <div class="text-center">
          <button data-bs-toggle="modal" data-bs-target="#modalAddFakultas"
            type="submit" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Fakultas
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Fakultas</th>
                <th>Nama Fakultas</th>
                <th>Universitas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($fakultas as $f): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $f->kode_fakultas; ?></td>
                  <td><?= $f->nama_fakultas; ?></td>
                  <td><?= $f->universitas; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('fakultas/edit/' . $f->id_fakultas); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('fakultas/delete/' . $f->id_fakultas); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- Modal Tambah Fakultas -->
  <div class="modal fade text-left" id="modalAddFakultas" tabindex="-1" role="dialog" aria-labelledby="labelAddFakultas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?php echo form_open('fakultas/add', ['id' => 'formAddFakultas']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddFakultas">Tambah Fakultas</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="row">
            <div class="form-group mb-3">
              <label for="kode_fakultas" class="form-label">Kode Fakultas</label>
              <input type="text" name="kode_fakultas" id="kode_fakultas" class="form-control" placeholder="Masukkan kode fakultas" required>
            </div>

            <div class="form-group mb-3">
              <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
              <input type="text" name="nama_fakultas" id="nama_fakultas" class="form-control" placeholder="Masukkan nama fakultas" required>
            </div>

            <div class="form-group mb-3">
              <label for="universitas" class="form-label">Universitas</label>
              <input type="text" name="universitas" id="universitas" class="form-control" placeholder="Masukkan nama universitas" required>
            </div>
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
  <!-- End Modal Tambah Fakultas -->



</div>