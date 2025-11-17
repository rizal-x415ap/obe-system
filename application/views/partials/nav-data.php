<ul class="nav nav-tabs">
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'pl') ? 'active' : '' ?>" href="<?= base_url('pl'); ?>">Profil Lulusan (PL)</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'cpl') ? 'active' : '' ?>" href="<?= base_url('cpl'); ?>">CPL Prodi</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'cpmk') ? 'active' : '' ?>" href="<?= base_url('cpmk'); ?>">Indikator CPL</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'bk') ? 'active' : '' ?>" href="<?= base_url('bk'); ?>">Bahan Kajian (BK)</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(1) == 'mk') ? 'active' : '' ?>" href="<?= base_url('mk'); ?>">Mata Kuliah (MK)</a>
  </li>
</ul>