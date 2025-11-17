<ul class="nav nav-tabs">
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'penyusunan_mk') ? 'active' : '' ?>" href="<?= base_url('kurikulum/penyusunan_mk'); ?>">Penyusunan MK</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'mk_prasyarat') ? 'active' : '' ?>" href="<?= base_url('kurikulum/mk_prasyarat'); ?>">MK Prasyarat</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'dosen_pengampu') ? 'active' : '' ?>" href="<?= base_url('kurikulum/dosen_pengampu'); ?>">Dosen Pengampu</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'indikator_mk') ? 'active' : '' ?>" href="<?= base_url('kurikulum/indikator_mk'); ?>">Indikator MK</a>
  </li>
</ul>