<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Penyusunan mata kuliah berdasarkan kurikulum aktif.</p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?= base_url($this->uri->segment(1)); ?>">
                <?= ucfirst($this->uri->segment(1)); ?>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <?= ucfirst($this->uri->segment(2)); ?>
            </li>
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
        <div class="text-center mb-3">

          <button id="btnSimpan" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
          </button>
        </div>

        <div class="mb-3">
          <label class="fw-bold">Kurikulum Aktif:</label>
          <span class="badge bg-light-success">
            <?= $kurikulum->NamaKurikulum ?> (<?= $kurikulum->TahunMulai ?>)
          </span>
          <input type="hidden" id="IdKurikulum" value="<?= $kurikulum->IdKurikulum ?>">
        </div>

        <div class="table-responsive">
          <table class="table table-bordered align-middle" id="table1">
            <thead>
              <tr>
                <th rowspan="2" class="text-center" width="3%">No</th>
                <th rowspan="2" class="text-start" width="30%">Mata Kuliah (MK)</th>
                <th colspan="2" class="text-center">SKS</th>
                <th colspan="2" class="text-center">Kategori</th>
                <th colspan="8" class="text-center">Semester</th>
              </tr>
              <tr>
                <th class="text-center">Teori</th>
                <th class="text-center">Praktek</th>
                <th class="text-center">Wajib</th>
                <th class="text-center">Pilihan</th>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                  <th class="text-center"><?= $i ?></th>
                <?php endfor; ?>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1;
              foreach ($mk as $m):
                $r = $relasi[$m->id_mk] ?? null;
              ?>
                <tr data-idmk="<?= $m->id_mk ?>">
                  <td class="text-center"><?= $no++ ?></td>
                  <td class="text-start"><b><?= $m->KodeMK ?></b>. <?= $m->NamaMK ?></td>

                  <!-- SKS -->
                  <td class="text-center">
                    <input type="number" name="sks_teori_<?= $m->id_mk ?>" value="<?= $r->sks_teori ?? 0 ?>" min="0" max="6" class="form-control form-control-sm text-center">
                  </td>
                  <td class="text-center">
                    <input type="number" name="sks_praktek_<?= $m->id_mk ?>" value="<?= $r->sks_praktek ?? 0 ?>" min="0" max="6" class="form-control form-control-sm text-center">
                  </td>

                  <!-- Kategori -->
                  <td class="text-center">
                    <input type="radio" name="kategori_<?= $m->id_mk ?>" value="Wajib" <?= (!$r || $r->kategori == 'Wajib') ? 'checked' : '' ?>>
                  </td>
                  <td class="text-center">
                    <input type="radio" name="kategori_<?= $m->id_mk ?>" value="Pilihan" <?= ($r && $r->kategori == 'Pilihan') ? 'checked' : '' ?>>
                  </td>

                  <!-- Semester -->
                  <?php for ($i = 1; $i <= 8; $i++): ?>
                    <td class="text-center">
                      <input type="radio" name="semester_<?= $m->id_mk ?>" value="<?= $i ?>" <?= ($r && $r->semester == $i) ? 'checked' : '' ?>>
                    </td>
                  <?php endfor; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </section>
</div>

<script>
  $('#btnSimpan').click(function() {
    let IdKurikulum = $('#IdKurikulum').val();
    let records = {};

    $('tr[data-idmk]').each(function() {
      let idmk = $(this).data('idmk');
      records[idmk] = {
        sks_teori: $("input[name='sks_teori_" + idmk + "']").val() || 0,
        sks_praktek: $("input[name='sks_praktek_" + idmk + "']").val() || 0,
        kategori: $("input[name='kategori_" + idmk + "']:checked").val() || 'Wajib',
        semester: $("input[name='semester_" + idmk + "']:checked").val() || 1
      };
    });

    $.ajax({
      url: "<?= site_url('kurikulum/simpan_penyusunan_mk') ?>",
      method: "POST",
      data: {
        IdKurikulum: IdKurikulum,
        data: records
      },
      success: function(res) {
        Swal.fire({
          icon: 'success',
          title: 'Data Tersimpan!',
          text: 'Penyusunan kurikulum berhasil diperbarui.',
          timer: 2000,
          showConfirmButton: false
        });
      }
    });
  });
</script>