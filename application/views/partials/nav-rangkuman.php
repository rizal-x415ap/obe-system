<ul class="nav nav-tabs">
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'peta_cpl_bk_mk') ? 'active' : '' ?>" href="<?= base_url('rangkuman/peta_cpl_bk_mk'); ?>">Peta Pemenuhan CPL, BK & MK</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'organisasi_mk') ? 'active' : '' ?>" href="<?= base_url('rangkuman/organisasi_mk'); ?>">Organisasi MK</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'peta_cpl_mk_semester') ? 'active' : '' ?>" href="<?= base_url('rangkuman/peta_cpl_mk_semester'); ?>">Peta Pemenuhan CPL & MK Setiap Semester</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'peta_indikator_cpl_mk') ? 'active' : '' ?>" href="<?= base_url('rangkuman/peta_indikator_cpl_mk'); ?>">Peta Pemenuhan Indikator CPL & MK</a>
  </li>
</ul>