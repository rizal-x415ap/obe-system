<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Data <?= $title; ?>.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() . $this->uri->segment(1); ?>"><?= $this->uri->segment(1); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->uri->segment(2); ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <?php $this->load->view('partials/nav-data'); ?>
      </div>
      <div class="card-body">
        <div class="text-center">
          <button data-bs-toggle="modal" data-bs-target="#modalAddBK" type="button" class="btn btn-sm btn-success">
            <i class="bi bi-plus-square"></i> Tambah Bahan Kajian
          </button>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode BK</th>
                <th>Nama Bahan Kajian</th>
                <th>Program Studi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($bk as $b): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><strong><?= $b->kodebk; ?></strong></td>
                  <td><?= $b->bahan_kajian; ?></td>
                  <td><?= $b->nama_prodi; ?></td>
                  <td><?= $b->deskripsi; ?></td>
                  <td class="aksi">
                    <a href="<?= site_url('bk/edit/' . $b->idbk); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('bk/delete/' . $b->idbk); ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($bk)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">Belum ada data Bahan Kajian.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah BK -->
  <div class="modal fade text-left" id="modalAddBK" tabindex="-1" role="dialog" aria-labelledby="labelAddBK" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <?= form_open('bk/add', ['id' => 'formAddBK']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="labelAddBK">Tambah Bahan Kajian</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>

        <div class="modal-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group mb-3">
            <label>Program Studi</label>
            <select name="kdprodi" class="form-select" required>
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $r): ?>
                <option value="<?= $r->id_prodi; ?>"><?= $r->nama_prodi; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Kode BK</label>
            <input type="text" name="kodebk" class="form-control" placeholder="Masukkan kode BK" required>
          </div>

          <div class="form-group mb-3">
            <label>Nama Bahan Kajian</label>
            <input type="text" name="bahan_kajian" class="form-control" placeholder="Masukkan nama bahan kajian" required>
          </div>

          <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="form-control" placeholder="Masukkan deskripsi"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary ms-1">Simpan</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <!-- End Modal Tambah BK -->
</div>