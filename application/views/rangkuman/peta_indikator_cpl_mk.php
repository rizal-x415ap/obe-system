<style>
  .indikator-box {
    background: #f8f9fa;
    border-left: 4px solid #0d6efd;
    border-radius: 4px;
    margin: 3px 0;
    padding: 4px 8px;
    font-size: 0.9em;
  }

  .indikator-box b {
    color: #0d6efd;
  }

  .total-box td {
    font-weight: bold;
    text-align: center;
  }

  .mk-col {
    width: 25%;
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
        <div class="mb-3 d-flex flex-wrap gap-2">
          <a href="<?= site_url('rangkuman/export_excel_peta_indikator_mk') ?>" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Download Excel
          </a>
          <a href="<?= site_url('rangkuman/export_pdf_peta_indikator_mk') ?>" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
          </a>
        </div>

        <div class="table-responsive">
          <table id="table1" class="table table-bordered align-middle table-striped">
            <thead class="table-secondary text-center">
              <tr>
                <th width="5%">#</th>
                <th class="mk-col">Mata Kuliah (MK)</th>
                <?php foreach ($cpl as $c): ?>
                  <th><?= $c['kode']; ?></th>
                <?php endforeach; ?>
                <th width="10%">Jumlah Indikator CPL</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1;
              foreach ($mk as $id_mk => $m): ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><b><?= $m['kode']; ?></b>. <?= $m['nama']; ?></td>

                  <?php foreach ($cpl as $idcpl => $c): ?>
                    <td>
                      <?php if (!empty($m['indikator'][$idcpl])): ?>
                        <?php foreach ($m['indikator'][$idcpl] as $i): ?>
                          <div class="indikator-box">
                            <b><?= $i->kodecpmk; ?></b>. <?= $i->cpmk; ?>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>

                  <td class="text-center"><b><?= $m['count']; ?></b></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>