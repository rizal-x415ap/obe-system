<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Kelola keterkaitan indikator CPL (CPMK) dengan mata kuliah.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?= base_url($this->uri->segment(1)); ?>"><?= ucfirst($this->uri->segment(1)); ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= ucfirst($this->uri->segment(2)); ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <?php $this->load->view('partials/nav-penyusunan'); ?>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered align-middle" id="table1">
            <thead class="table-secondary">
              <tr>
                <th width="35%">Mata Kuliah (MK)</th>
                <th width="55%">Dosen Pengampu</th>
                <th width="10%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($mk as $m): ?>
                <?php $list_pengampu = $pengampu[$m->id_mk] ?? []; ?>
                <tr>
                  <td><b><?= $m->KodeMK ?></b>. <?= $m->NamaMK ?></td>
                  <td>
                    <?php if ($list_pengampu): ?>
                      <?php foreach ($list_pengampu as $d): ?>
                        <div><?= $d['nama'] ?></div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted fst-italic">Belum ada dosen pengampu</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if (empty($list_pengampu)): ?>
                      <button class="btn btn-sm btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah"
                        data-id="<?= $m->id_mk ?>"
                        data-nama="<?= $m->NamaMK ?>">
                        <i class="bi bi-plus-lg"></i>
                      </button>
                    <?php else: ?>
                      <?php foreach ($list_pengampu as $d): ?>
                        <button class="btn btn-sm btn-danger btn-hapus mb-1"
                          data-id="<?= $d['id'] ?>">
                          <i class="bi bi-trash"></i>
                        </button><br>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formPengampu">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalTambahLabel">Tambah Dosen Pengampu MK</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_mk" id="id_mk">
            <div class="mb-3">
              <label class="form-label">Mata Kuliah</label>
              <input type="text" id="nama_mk" class="form-control" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Pilih Dosen Pengampu</label>
              <select name="id_dosen" class="form-select" required>
                <option value="">-- Pilih Dosen --</option>
                <?php foreach ($dosen as $d): ?>
                  <option value="<?= $d->id_dosen ?>"><?= $d->nama_dosen ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Modal isi otomatis
    $('#modalTambah').on('show.bs.modal', function(e) {
      let btn = $(e.relatedTarget);
      $('#id_mk').val(btn.data('id'));
      $('#nama_mk').val(btn.data('nama'));
    });

    // Submit tambah pengampu
    $('#formPengampu').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('kurikulum/add_dosen_pengampu') ?>",
        method: "POST",
        data: $(this).serialize(),
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Dosen pengampu berhasil ditambahkan!',
            timer: 1200,
            showConfirmButton: false
          }).then(() => location.reload());
        }
      });
    });

    // Hapus dosen pengampu
    $('.btn-hapus').click(function() {
      let id = $(this).data('id');
      Swal.fire({
        title: 'Hapus Dosen Pengampu?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('kurikulum/delete_dosen_pengampu/') ?>" + id,
            success: function() {
              Swal.fire({
                icon: 'success',
                title: 'Terhapus',
                timer: 1000,
                showConfirmButton: false
              }).then(() => location.reload());
            }
          });
        }
      });
    });
  </script>