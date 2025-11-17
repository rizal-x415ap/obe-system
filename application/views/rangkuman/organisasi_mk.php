<style>
  .box-mk {
    background: #f8f9fa;
    border-left: 4px solid #0d6efd;
    border-radius: 4px;
    margin: 3px 0;
    padding: 4px 8px;
    font-size: 0.9em;
  }

  .box-mk small {
    color: #198754;
  }

  .total-box td {
    font-weight: bold;
    text-align: center;
  }
</style>

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
    <div class="card shadow-sm">
      <div class="card-header py-3">
        <?php $this->load->view('partials/nav-rangkuman'); ?>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle" id="table1">
            <thead class="table-secondary text-center">
              <tr>
                <th width="10%">Semester</th>
                <th width="8%">SKS<br>(T+P)</th>
                <th width="8%">Jumlah MK</th>
                <th>Mata Kuliah Wajib Prodi</th>
                <th>Mata Kuliah Pilihan Prodi</th>
                <th>Mata Kuliah Wajib Luar Prodi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($semesters as $sem => $v): ?>
                <tr>
                  <td class="text-center"><b>Semester <?= $sem; ?></b></td>
                  <td class="text-center"><?= $v['total_sks'] ?? 0; ?></td>
                  <td class="text-center"><?= $v['total_mk'] ?? 0; ?></td>

                  <!-- Wajib Prodi -->
                  <td>
                    <?php foreach ($v['list']['wajib'] ?? [] as $m): ?>
                      <div class="box-mk">
                        <b><?= $m->KodeMK; ?></b>. <?= $m->NamaMK; ?>
                        <small>(<?= $m->sks_teori + $m->sks_praktek; ?> SKS)</small>
                      </div>
                    <?php endforeach; ?>
                  </td>

                  <!-- Pilihan Prodi -->
                  <td>
                    <?php foreach ($v['list']['pilihan'] ?? [] as $m): ?>
                      <div class="box-mk">
                        <b><?= $m->KodeMK; ?></b>. <?= $m->NamaMK; ?>
                        <small>(<?= $m->sks_teori + $m->sks_praktek; ?> SKS)</small>
                      </div>
                    <?php endforeach; ?>
                  </td>

                  <!-- Luar Prodi -->
                  <td>
                    <?php foreach ($v['list']['luar'] ?? [] as $m): ?>
                      <div class="box-mk">
                        <b><?= $m->KodeMK; ?></b>. <?= $m->NamaMK; ?>
                        <small>(<?= $m->sks_teori + $m->sks_praktek; ?> SKS)</small>
                      </div>
                    <?php endforeach; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>

            <tfoot class="table-light total-box text-c">
              <tr>
                <td><b>Total</b></td>
                <td class="text-center"><?= $grand_total['sks']; ?></td>
                <td class="text-center"><?= $grand_total['mk']; ?></td>
                <td class="text-center"><?= $grand_total['wajib']; ?> MK</td>
                <td class="text-center"><?= $grand_total['pilihan']; ?> MK</td>
                <td class="text-center"><?= $grand_total['luar']; ?> MK</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>