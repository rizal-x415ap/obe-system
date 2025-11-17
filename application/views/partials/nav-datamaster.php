<ul class="nav nav-tabs">
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'fakultas') ? 'active' : '' ?>" href="<?= base_url('fakultas'); ?>">Fakultas</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'prodi') ? 'active' : '' ?>" href="<?= base_url('prodi'); ?>">Prodi</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'dosen') ? 'active' : '' ?>" href="<?= base_url('dosen'); ?>">Dosen</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'kaprodi') ? 'active' : '' ?>" href="<?= base_url('kaprodi'); ?>">Kaprodi</a>
  </li>
</ul>