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
                <?= ($this->uri->segment(1)); ?>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <?= ($this->uri->segment(2)); ?>
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
            <thead class="table-secondary">
              <tr>
                <th width="3%">No</th>
                <th width="20%">Bahan Kajian (BK)</th>
                <?php foreach ($cpl as $c): ?>
                  <th><?= $c->kodecpl ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($map as $idbk => $b): ?>
                <?php $mk_list = $mk[$idbk] ?? []; ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td class="bk-col"><b><?= $b['kodebk'] ?></b>. <?= $b['bahan_kajian'] ?></td>
                  <?php foreach ($cpl as $c): ?>
                    <td>
                      <?php if (in_array($c->idcpl, $b['cpl'] ?? [])): ?>
                        <?php if (!empty($mk_list)): ?>
                          <?php foreach ($mk_list as $m): ?>
                            <div class="box-mk">
                              <b><?= $m['KodeMK'] ?></b> - <?= $m['NamaMK'] ?>
                            </div>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>