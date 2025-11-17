<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard OBE</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
  <div class="container mt-5 text-center">
    <h3>Selamat Datang, <?= $this->session->userdata('username'); ?>!</h3>
    <p>Anda login sebagai: <strong><?= $this->session->userdata('role'); ?></strong></p>
    <a href="<?= site_url('login/logout'); ?>" class="btn btn-danger">Logout</a>

    <h4>Data Master</h4>
    <ul class="mt-5">
      <a href="<?= base_url('fakultas') ?>">Fakultas</a>
      <a href="<?= base_url('prodi') ?>">Prodi</a>
      <a href="<?= base_url('kaprodi') ?>">Kaprodi</a>
      <a href="<?= base_url('dosen') ?>">Dosen</a>
      <a href="<?= base_url('kurikulum') ?>">Kurikulum</a>
    </ul>

    <h4>Kurikulum</h4>
    <h5>Data</h5>
    <ul>
      <a href="<?= base_url('pl') ?>">Profil Lulusan</a>
      <a href="<?= base_url('cpl') ?>">CPL</a>
      <a href="<?= base_url('bk') ?>">BK</a>
      <a href="<?= base_url('mk') ?>">MK</a>
      <a href="<?= base_url('cpmk') ?>">CPMK</a>
    </ul>
    <h5><a href="<?= base_url('pemetaan/cpl_pl') ?>">Pemetaan</a></h5>
    <h5><a href="<?= base_url('kurikulum/penyusunan_mk') ?>">Penyusunan_mk</a></h5>
    <h5><a href="<?= base_url('rangkuman/peta_cpl_bk_mk') ?>">Rangkuman</a></h5>
  </div>
</body>

</html>