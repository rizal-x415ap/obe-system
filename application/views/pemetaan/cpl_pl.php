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
            <li class="breadcrumb-item"><a href="<?= base_url($this->uri->segment(1)); ?>"><?= $this->uri->segment(1); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->uri->segment(2); ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <?php $this->load->view('partials/nav-pemetaan'); ?>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-matrix align-middle" id="table1">
            <thead>
              <tr>
                <th rowspan="2" class="text-center" width="3%">No</th>
                <th rowspan="2" class="text-start" width="25%">CPL</th>
                <th colspan="<?= count($pl) ?>" class="text-center">Profil Lulusan (PL)</th>
                <th rowspan="2" class="text-center">Jumlah PL</th>
              </tr>
              <tr>
                <?php foreach ($pl as $p): ?>
                  <th class="text-center"><?= $p->kodepl; ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($cpl as $c): ?>
                <tr data-idcpl="<?= $c->idcpl ?>">
                  <td><?= $no++ ?></td>
                  <td class="text-start"><b><?= $c->kodecpl ?></b>. <?= $c->cpl ?></td>
                  <?php
                  $countChecked = 0;
                  foreach ($pl as $p):
                    $checked = in_array($p->idpl, $relasi[$c->idcpl] ?? []) ? 'checked' : '';
                    if ($checked) $countChecked++;
                  ?>
                    <td class="text-center">
                      <input type="checkbox"
                        class="form-check-input chk-relasi"
                        data-idcpl="<?= $c->idcpl ?>"
                        data-idpl="<?= $p->idpl ?>"
                        <?= $checked ?>>
                    </td>
                  <?php endforeach; ?>
                  <td class="text-center"><span class="badge bg-light-success"><?= $countChecked ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-end">Jumlah CPL</th>
                <?php foreach ($pl as $p): ?>
                  <?php $sum = 0;
                  foreach ($relasi as $cid => $arr) {
                    if (in_array($p->idpl, $arr)) $sum++;
                  } ?>
                  <th class="text-center"><span class="badge bg-light-danger"><?= $sum ?></span></th>
                <?php endforeach; ?>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(function() {
    $('.chk-relasi').change(function() {
      let idcpl = $(this).data('idcpl');
      let idpl = $(this).data('idpl');
      let checked = $(this).is(':checked');
      $.ajax({
        url: "<?= site_url('pemetaan/update_cpl_pl') ?>",
        method: "POST",
        data: {
          idcpl: idcpl,
          idpl: idpl,
          checked: checked
        },
        success: function(res) {
          console.log(res);
        }
      });
    });
  });
</script>