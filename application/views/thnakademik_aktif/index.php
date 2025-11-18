<div class="container my-4">

  <h3 class="mb-4"><?= isset($title) ? $title : 'Tahun Akademik Aktif'; ?></h3>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $this->session->flashdata('success'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $this->session->flashdata('error'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-5">
      <div class="card">
        <div class="card-body">
          <form action="<?= site_url('thnakademik_aktif/update'); ?>" method="post">

            <input type="hidden" name="id" value="<?= isset($current->id) ? $current->id : 1; ?>">

            <div class="mb-3">
              <label for="Thnakademik" class="form-label">Tahun Akademik</label>
              <input
                type="text"
                name="Thnakademik"
                id="Thnakademik"
                class="form-control"
                placeholder="contoh: 2024/2025"
                value="<?= isset($current->Thnakademik) ? htmlspecialchars($current->Thnakademik) : ''; ?>"
                required>
            </div>

            <div class="mb-3">
              <label for="Semester" class="form-label">Semester</label>
              <input class="form-control" type="number" value="<?= isset($current->Semester) ? htmlspecialchars($current->Semester) : ''; ?>" name="Semester" id="Semester">
            </div>

            <button type="submit" class="btn btn-primary">
              Simpan Perubahan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>