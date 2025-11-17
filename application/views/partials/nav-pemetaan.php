<ul class="nav nav-tabs">
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'cpl_pl') ? 'active' : '' ?>" href="<?= base_url('pemetaan/cpl_pl'); ?>">CPL & PL</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'cpl_bk') ? 'active' : '' ?>" href="<?= base_url('pemetaan/cpl_bk'); ?>">CPL & BK</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'bk_mk') ? 'active' : '' ?>" href="<?= base_url('pemetaan/bk_mk'); ?>">BK & MK</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link <?= ($this->uri->segment(2) == 'cpl_mk') ? 'active' : '' ?>" href="<?= base_url('pemetaan/cpl_mk'); ?>">CPL & MK</a>
  </li>
</ul>