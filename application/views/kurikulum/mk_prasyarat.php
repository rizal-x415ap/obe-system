<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Kelola mata kuliah dan prasyarat dalam kurikulum aktif.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url($this->uri->segment(1)); ?>"><?= ucfirst($this->uri->segment(1)); ?></a></li>
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
            <thead>
              <tr class="table-secondary text-center">
                <th rowspan="2">Mata Kuliah (MK)</th>
                <th colspan="2">SKS</th>
                <th rowspan="2">Kategori</th>
                <th rowspan="2">MK Prasyarat</th>
                <th rowspan="2">Semester</th>
                <th rowspan="2">Aksi</th>
              </tr>
              <tr class="table-secondary text-center">
                <th>Teori</th>
                <th>Praktek</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $map_mk = [];
              foreach ($kurikulum_mk as $km) {
                $map_mk[$km->id_mk] = $km;
              }

              foreach ($mk as $m):
                $list_prasyarat = $prasyarat[$m->id_mk] ?? [];
                $text_prasyarat = !empty($list_prasyarat)
                  ? implode(', ', array_map(fn($r) => $r['kode'] . ' (' . $r['nama'] . ')', $list_prasyarat))
                  : '-';
                $semester_prasyarat = !empty($list_prasyarat)
                  ? implode(', ', array_map(fn($r) => $r['semester'] ?: '-', $list_prasyarat))
                  : '-';
                $sks_teori = $map_mk[$m->id_mk]->sks_teori ?? 0;
                $sks_praktek = $map_mk[$m->id_mk]->sks_praktek ?? 0;
                $kategori = $map_mk[$m->id_mk]->kategori ?? '-';
                $semester = $map_mk[$m->id_mk]->semester ?? 0;
              ?>
                <tr>
                  <td><b><?= $m->KodeMK ?></b>. <?= $m->NamaMK ?></td>
                  <td class="text-center"><?= $sks_teori ?></td>
                  <td class="text-center"><?= $sks_praktek ?></td>
                  <td class="text-center"><?= $kategori ?></td>
                  <td><?= $text_prasyarat ?></td>
                  <td class="text-center"><?= $semester ?></td> <!-- Data sumber RowGroup -->
                  <td class="text-center">
                    <?php if (empty($list_prasyarat)): ?>
                      <button class="btn btn-sm btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah"
                        data-id="<?= $m->id_mk ?>"
                        data-nama="<?= $m->NamaMK ?>">
                        <i class="bi bi-plus-lg"></i>
                      </button>
                    <?php else: ?>
                      <button class="btn btn-sm btn-danger btn-hapus"
                        data-id="<?= $list_prasyarat[0]['id'] ?>">
                        <i class="bi bi-trash"></i>
                      </button>
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
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formPrasyarat">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTambahLabel">Tambah MK Prasyarat</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_mk" id="id_mk">
          <div class="mb-3">
            <label class="form-label">Mata Kuliah</label>
            <input type="text" id="nama_mk" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Pilih MK Prasyarat</label>
            <select name="id_mk_prasyarat" class="form-select" required>
              <option value="">-- Pilih MK Prasyarat --</option>
              <?php foreach ($mk as $r): ?>
                <option value="<?= $r->id_mk ?>"><?= $r->KodeMK ?> - <?= $r->NamaMK ?></option>
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
  if ($.fn.DataTable.isDataTable('#table1')) {
    $('#table1').DataTable().clear().destroy();
  }

  $('#table1').DataTable({
    rowGroup: {
      dataSrc: 5
    },
    columnDefs: [{
      targets: 5,
      visible: false
    }],
    paging: false,
    searching: false,
    ordering: false,
    info: false,
    responsive: true
  });


  $('#modalTambah').on('show.bs.modal', function(e) {
    let button = $(e.relatedTarget);
    $('#id_mk').val(button.data('id'));
    $('#nama_mk').val(button.data('nama'));
  });

  $('#formPrasyarat').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('kurikulum/add_mk_prasyarat') ?>",
      method: "POST",
      data: $(this).serialize(),
      success: function() {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'MK Prasyarat berhasil ditambahkan.',
          timer: 2000,
          showConfirmButton: false
        }).then(() => location.reload());
      }
    });
  });

  $('.btn-hapus').click(function() {
    let id = $(this).data('id');
    Swal.fire({
      title: 'Hapus MK Prasyarat?',
      text: "Tindakan ini tidak dapat dibatalkan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('kurikulum/delete_mk_prasyarat/') ?>" + id,
          success: function() {
            Swal.fire({
              icon: 'success',
              title: 'Dihapus!',
              text: 'MK Prasyarat telah dihapus.',
              timer: 1500,
              showConfirmButton: false
            }).then(() => location.reload());
          }
        });
      }
    });
  });
</script>