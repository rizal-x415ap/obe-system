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
            <thead class="table-secondary text-center">
              <tr>
                <th width="10%">Kode CPL</th>
                <th width="25%">Deskripsi CPL</th>
                <th width="20%">Indikator CPL (CPMK)</th>
                <th width="35%">Mata Kuliah (MK)</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $grouped = [];
              foreach ($cpl_cpmk as $row) {
                $grouped[$row->idcpl]['kodecpl'] = $row->kodecpl;
                $grouped[$row->idcpl]['cpl'] = $row->cpl;
                if ($row->idcpmk) {
                  $grouped[$row->idcpl]['cpmk'][] = $row;
                }
              }

              foreach ($grouped as $cpl):
                $kodecpl = $cpl['kodecpl'];
                $desccpl = $cpl['cpl'];

                if (!empty($cpl['cpmk'])):
                  foreach ($cpl['cpmk'] as $i):
                    $linked = $map[$i->idcpmk] ?? [];
              ?>
                    <tr>
                      <td class="text-center"><b><?= $kodecpl ?></b></td>
                      <td><?= $desccpl ?></td>
                      <td>
                        <b><?= $i->kodecpmk ?></b>. <?= $i->cpmk ?>
                        <br><small class="text-muted">Bobot: 50%</small>
                        <br>
                        <button class="btn btn-sm btn-success mt-2 btn-tambah"
                          data-idcpmk="<?= $i->idcpmk ?>"
                          data-bs-toggle="modal"
                          data-bs-target="#modalTambah">
                          <i class="bi bi-plus-lg"></i>
                        </button>
                      </td>
                      <td>
                        <?php if ($linked): ?>
                          <?php foreach ($linked as $id_mk): ?>
                            <?php foreach ($mk_list as $m): ?>
                              <?php if ($m->id_mk == $id_mk): ?>
                                <div><?= $m->KodeMK ?> - <?= $m->NamaMK ?></div>
                                <?php break; ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <span class="text-muted">Belum ada MK terkait</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <?php if ($linked): foreach ($linked as $id_mk): ?>
                            <button class="btn btn-sm btn-danger btn-hapus mb-1"
                              data-idcpmk="<?= $i->idcpmk ?>"
                              data-idmk="<?= $id_mk ?>">
                              <i class="bi bi-trash"></i>
                            </button><br>
                        <?php endforeach;
                        endif; ?>
                      </td>
                    </tr>
                  <?php endforeach;
                else: ?>
                  <tr>
                    <td class="text-center"><b><?= $kodecpl ?></b></td>
                    <td><?= $desccpl ?></td>
                    <td colspan="3" class="text-center text-muted">Belum ada indikator (CPMK)</td>
                  </tr>
              <?php endif;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahMK">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTambahLabel">Tambah MK untuk Indikator CPL</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="idcpmk" id="idcpmk">
          <div class="mb-3">
            <label class="form-label">Pilih Mata Kuliah</label>
            <select name="id_mk" class="form-select" required>
              <option value="">-- Pilih Mata Kuliah --</option>
              <?php foreach ($mk_list as $m): ?>
                <option value="<?= $m->id_mk ?>"><?= $m->KodeMK ?> - <?= $m->NamaMK ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm">Simpan</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Modal tambah
  $('#modalTambah').on('show.bs.modal', function(e) {
    const button = $(e.relatedTarget);
    $('#idcpmk').val(button.data('idcpmk'));
  });

  // Simpan relasi MK
  $('#formTambahMK').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('kurikulum/add_indikator_mk') ?>",
      method: "POST",
      data: $(this).serialize(),
      success: function() {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Mata kuliah berhasil ditautkan ke indikator CPL.',
          timer: 2000,
          showConfirmButton: false
        }).then(() => location.reload());
      }
    });
  });

  // Hapus relasi
  $('.btn-hapus').click(function() {
    const idcpmk = $(this).data('idcpmk');
    const idmk = $(this).data('idmk');
    Swal.fire({
      title: 'Hapus tautan MK?',
      text: "Tindakan ini tidak dapat dibatalkan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('kurikulum/delete_indikator_mk') ?>",
          method: "POST",
          data: {
            idcpmk,
            id_mk: idmk
          },
          success: function() {
            Swal.fire({
              icon: 'success',
              title: 'Dihapus!',
              text: 'Tautan MK telah dihapus.',
              timer: 1500,
              showConfirmButton: false
            }).then(() => location.reload());
          }
        });
      }
    });
  });

  // DataTable
  if ($.fn.DataTable.isDataTable('#table1')) {
    $('#table1').DataTable().clear().destroy();
  }

  $('#table1').DataTable({
    rowGroup: {
      dataSrc: 0
    },
    columnDefs: [{
      targets: 0,
      visible: false
    }],
    paging: false,
    searching: false,
    ordering: false,
    info: false,
    responsive: true
  });
</script>