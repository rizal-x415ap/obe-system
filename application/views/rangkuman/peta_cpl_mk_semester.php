<style>
  .mk-box {
    background: #f8f9fa;
    border-left: 4px solid #0d6efd;
    border-radius: 4px;
    margin: 3px 0;
    padding: 4px 8px;
    font-size: 0.9em;
  }

  .mk-box small {
    color: #198754;
  }

  .total-box td {
    font-weight: bold;
    text-align: center;
  }

  .cpl-col {
    width: 20%;
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
                <th width="3%">#</th>
                <th class="cpl-col">Capaian Pembelajaran Lulusan (CPL)</th>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                  <th>Semester <?= $i; ?></th>
                <?php endfor; ?>
                <th>Jumlah MK</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1;
              foreach ($cpl as $idcpl => $c): ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><b><?= $c['kodecpl']; ?></b>. <?= $c['cpl']; ?></td>

                  <?php for ($i = 1; $i <= 8; $i++): ?>
                    <td>
                      <?php if (!empty($c['mk'][$i])): ?>
                        <?php foreach ($c['mk'][$i] as $m): ?>
                          <div class="mk-box">
                            <b><?= $m->KodeMK; ?></b> <?= $m->NamaMK; ?>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                  <?php endfor; ?>

                  <td class="text-center"><?= $count_cpl[$idcpl] ?? 0; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>

            <tfoot class="table-light total-box">
              <tr>
                <td colspan="2"><b>Jumlah MK</b></td>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                  <td class="text-center"><?= $count_sem[$i] ?? 0; ?></td>
                <?php endfor; ?>
                <td class="text-center"><?= array_sum($count_sem); ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>