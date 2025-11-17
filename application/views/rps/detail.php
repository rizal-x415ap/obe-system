<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Detail RPS</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    .card-header {
      background: #f5f5f5;
      font-weight: bold;
    }

    .table th,
    .table td {
      vertical-align: top;
    }

    .btn-xs {
      padding: 2px 6px;
      font-size: 12px;
    }

    .indikator-box {
      margin-left: 15px;
      font-size: 13px;
    }
  </style>
</head>

<body class="bg-light">

  <div class="container-fluid mt-3">
    <h4>Detail RPS : <?= $rps->KodeMK ?> – <?= $rps->NamaMK ?></h4>

    <!-- ========== CPMK / SubCPMK / Indikator ========== -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar CPMK / Sub CPMK</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCpmkModal">+ CPMK</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th style="width:35%">CPMK</th>
              <th style="width:8%">Bobot (%)</th>
              <th style="width:35%">Sub CPMK</th>
              <th style="width:8%">Bobot Sub (%)</th>
              <th style="width:14%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total_bobot = 0;
            foreach ($cpmk as $c):
              $total_bobot += $c->bobot;
              $subs = $this->M_rps->get_subcpmk($c->id_rps_cpmk);
              $ind = $this->M_rps->get_indikator_cpmk($c->id_rps_cpmk);
            ?>
              <tr>
                <td>
                  <b><?= $c->kode_cpmk ?>.</b> <?= $c->deskripsi ?>
                  <?php if ($ind): ?>
                    <?php foreach ($ind as $i): ?>
                      <div class="indikator-box">
                        • <b><?= $i->kode_indikator ?></b> <?= $i->indikator ?>
                        <a href="<?= site_url('rps/delete_indikator/' . $i->id_indikator) ?>" class="text-danger ms-1">🗑</a>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  <div class="mt-1">
                    <button class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#addIndikator<?= $c->id_rps_cpmk ?>">+ IK</button>
                    <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editCpmk<?= $c->id_rps_cpmk ?>">✏ Edit</button>
                    <a href="<?= site_url('rps/delete_cpmk/' . $c->id_rps_cpmk) ?>" class="btn btn-danger btn-xs">🗑</a>
                    <button class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#addSub<?= $c->id_rps_cpmk ?>">+ Sub</button>
                  </div>
                </td>
                <td class="text-center"><?= $c->bobot ?></td>
                <td>
                  <?php foreach ($subs as $s): ?>
                    <div><b><?= $s->kode_sub ?></b>. <?= $s->sub_cpmk ?> [<?= $s->bobot ?>%]</div>
                    <?php
                    $subind = $this->M_rps->get_indikator_sub($s->id_subcpmk);
                    foreach ($subind as $si): ?>
                      <div class="indikator-box">
                        • <b><?= $si->kode_indikator ?></b> <?= $si->indikator ?>
                        <a href="<?= site_url('rps/delete_indikator/' . $si->id_indikator) ?>" class="text-danger ms-1">🗑</a>
                      </div>
                    <?php endforeach; ?>
                    <div class="ms-3 mb-2">
                      <button class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#addIndSub<?= $s->id_subcpmk ?>">+ IK</button>
                      <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editSub<?= $s->id_subcpmk ?>">✏ Edit</button>
                      <a href="<?= site_url('rps/delete_subcpmk/' . $s->id_subcpmk) ?>" class="btn btn-danger btn-xs">🗑</a>
                    </div>
                  <?php endforeach; ?>
                </td>
                <td class="text-center"><?= array_sum(array_column($subs, 'bobot')) ?></td>
                <td class="text-center">–</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr class="table-light">
              <td class="text-end"><b>Total Bobot CPMK</b></td>
              <td class="text-center"><b><?= $total_bobot ?> %</b></td>
              <td colspan="3"></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <!-- =========================
     MATERI PEMBELAJARAN
========================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Materi Pembelajaran</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMateriModal">+ Materi</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th>Urutan</th>
              <th>Materi</th>
              <th width="15%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($materi as $m): ?>
              <tr>
                <td class="text-center"><?= $m->urutan ?></td>
                <td><?= $m->materi ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editMateri<?= $m->id_materi ?>">✏</button>
                  <a href="<?= site_url('rps/delete_materi/' . $m->id_materi) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data ini?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- =========================
     DAFTAR PUSTAKA
========================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Pustaka</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPustakaModal">+ Pustaka</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th>Kode</th>
              <th>Deskripsi</th>
              <th>Jenis</th>
              <th width="15%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pustaka as $p): ?>
              <tr>
                <td class="text-center"><?= $p->kode_pustaka ?></td>
                <td><?= $p->pustaka ?></td>
                <td class="text-center"><?= $p->jenis ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editPustaka<?= $p->id_pustaka ?>">✏</button>
                  <a href="<?= site_url('rps/delete_pustaka/' . $p->id_pustaka) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data ini?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- =========================
     MEDIA PEMBELAJARAN
========================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Media Pembelajaran</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMediaModal">+ Media</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th>Media</th>
              <th>Jenis</th>
              <th width="15%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($media as $m): ?>
              <tr>
                <td><?= $m->media ?></td>
                <td class="text-center"><?= $m->jenis ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editMedia<?= $m->id_media ?>">✏</button>
                  <a href="<?= site_url('rps/delete_media/' . $m->id_media) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data ini?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- =========================
     BENTUK PENILAIAN
========================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Bentuk Penilaian</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPenilaianModal">+ Penilaian</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th>Bentuk Penilaian</th>
              <th>Keterangan</th>
              <th>Bobot (%)</th>
              <th width="15%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($penilaian as $p): ?>
              <tr>
                <td><?= $p->bentuk ?></td>
                <td><?= $p->keterangan ?></td>
                <td class="text-center"><?= $p->bobot ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editPenilaian<?= $p->id_penilaian ?>">✏</button>
                  <a href="<?= site_url('rps/delete_penilaian/' . $p->id_penilaian) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data ini?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- =========================
     DAFTAR PERTEMUAN
========================= -->
    <div class="card mb-5">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Pertemuan</span>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPertemuanModal">+ Pertemuan</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-secondary text-center align-middle">
            <tr>
              <th>Minggu ke</th>
              <th>CPMK</th>
              <th>Materi</th>
              <th>Media</th>
              <th>Pustaka</th>
              <th>Bentuk Penilaian</th>
              <th>Aktivitas Sinkronus</th>
              <th>Aktivitas Asinkronus</th>
              <th>Keterangan</th>
              <th width="12%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pertemuan as $p): ?>
              <tr>
                <td class="text-center"><?= $p->minggu_ke ?></td>
                <td>
                  <?php
                  $cpmk_name = $this->db->select('kode_cpmk')->get_where('obe_rps_cpmk', ['id_rps_cpmk' => $p->id_rps_cpmk])->row();
                  echo $cpmk_name ? $cpmk_name->kode_cpmk : '-';
                  ?>
                </td>
                <td>
                  <?php
                  $mat = $this->db->select('materi')->get_where('obe_rps_materi', ['id_materi' => $p->id_materi])->row();
                  echo $mat ? $mat->materi : '-';
                  ?>
                </td>
                <td>
                  <?php
                  $med = $this->db->select('media')->get_where('obe_rps_media', ['id_media' => $p->id_media])->row();
                  echo $med ? $med->media : '-';
                  ?>
                </td>
                <td>
                  <?php
                  $pus = $this->db->select('kode_pustaka')->get_where('obe_rps_pustaka', ['id_pustaka' => $p->id_pustaka])->row();
                  echo $pus ? $pus->kode_pustaka : '-';
                  ?>
                </td>
                <td>
                  <?php
                  $pen = $this->db->select('bentuk')->get_where('obe_rps_penilaian', ['id_penilaian' => $p->id_penilaian])->row();
                  echo $pen ? $pen->bentuk : '-';
                  ?>
                </td>
                <td><?= nl2br($p->sinkronus) ?></td>
                <td><?= nl2br($p->asinkronus) ?></td>
                <td><?= nl2br($p->keterangan) ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editPertemuan<?= $p->id_pertemuan ?>">✏</button>
                  <a href="<?= site_url('rps/delete_pertemuan/' . $p->id_pertemuan) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Hapus pertemuan ini?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ===========================
     ====  MODALS  ====
===========================-->

  <!-- Modal Tambah CPMK -->
  <div class="modal fade" id="addCpmkModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= site_url('rps/add_cpmk') ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah CPMK</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="mb-2"><label>Kode CPMK</label><input name="kode_cpmk" class="form-control" required></div>
          <div class="mb-2"><label>Deskripsi CPMK</label><textarea name="deskripsi" class="form-control" required></textarea></div>
          <div class="mb-2"><label>Bobot (%)</label><input type="number" name="bobot" class="form-control" required></div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <?php foreach ($cpmk as $c): ?>
    <!-- Modal Edit CPMK -->
    <div class="modal fade" id="editCpmk<?= $c->id_rps_cpmk ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/edit_cpmk/' . $c->id_rps_cpmk) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit CPMK</h5>
          </div>
          <div class="modal-body">
            <div class="mb-2"><label>Kode</label><input name="kode_cpmk" class="form-control" value="<?= $c->kode_cpmk ?>"></div>
            <div class="mb-2"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"><?= $c->deskripsi ?></textarea></div>
            <div class="mb-2"><label>Bobot (%)</label><input name="bobot" class="form-control" value="<?= $c->bobot ?>"></div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>

    <!-- Modal Tambah SubCPMK -->
    <div class="modal fade" id="addSub<?= $c->id_rps_cpmk ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/add_subcpmk') ?>" class="modal-content">
          <div class="modal-header">
            <h5>Tambah Sub CPMK</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_rps_cpmk" value="<?= $c->id_rps_cpmk ?>">
            <div class="mb-2"><label>Kode Sub</label><input name="kode_sub" class="form-control" required></div>
            <div class="mb-2"><label>Deskripsi</label><textarea name="sub_cpmk" class="form-control" required></textarea></div>
            <div class="mb-2"><label>Bobot (%)</label><input name="bobot" class="form-control" type="number"></div>
          </div>
          <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
        </form>
      </div>
    </div>

    <!-- Modal Tambah Indikator CPMK -->
    <div class="modal fade" id="addIndikator<?= $c->id_rps_cpmk ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/add_indikator') ?>" class="modal-content">
          <div class="modal-header">
            <h5>Tambah Indikator CPMK</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_rps_cpmk" value="<?= $c->id_rps_cpmk ?>">
            <div class="mb-2"><label>Kode Indikator</label><input name="kode_indikator" class="form-control"></div>
            <div class="mb-2"><label>Deskripsi Indikator</label><textarea name="indikator" class="form-control"></textarea></div>
          </div>
          <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
        </form>
      </div>
    </div>

    <?php
    $subs = $this->M_rps->get_subcpmk($c->id_rps_cpmk);
    foreach ($subs as $s):
    ?>
      <!-- Modal Edit SubCPMK -->
      <div class="modal fade" id="editSub<?= $s->id_subcpmk ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="post" action="<?= site_url('rps/edit_subcpmk/' . $s->id_subcpmk) ?>" class="modal-content">
            <div class="modal-header">
              <h5>Edit Sub CPMK</h5>
            </div>
            <div class="modal-body">
              <div class="mb-2"><label>Kode Sub</label><input name="kode_sub" class="form-control" value="<?= $s->kode_sub ?>"></div>
              <div class="mb-2"><label>Deskripsi</label><textarea name="sub_cpmk" class="form-control"><?= $s->sub_cpmk ?></textarea></div>
              <div class="mb-2"><label>Bobot (%)</label><input name="bobot" class="form-control" value="<?= $s->bobot ?>"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
          </form>
        </div>
      </div>

      <!-- Modal Tambah Indikator SubCPMK -->
      <div class="modal fade" id="addIndSub<?= $s->id_subcpmk ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="post" action="<?= site_url('rps/add_indikator') ?>" class="modal-content">
            <div class="modal-header">
              <h5>Tambah Indikator Sub CPMK</h5>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_subcpmk" value="<?= $s->id_subcpmk ?>">
              <div class="mb-2"><label>Kode Indikator</label><input name="kode_indikator" class="form-control"></div>
              <div class="mb-2"><label>Deskripsi Indikator</label><textarea name="indikator" class="form-control"></textarea></div>
            </div>
            <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
          </form>
        </div>
      </div>
  <?php endforeach;
  endforeach; ?>

  <!-- Modal Tambah Materi -->
  <div class="modal fade" id="addMateriModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= site_url('rps/add_materi') ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Materi Pembelajaran</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="mb-2"><label>Urutan</label><input type="number" name="urutan" class="form-control" required></div>
          <div class="mb-2"><label>Materi</label><textarea name="materi" class="form-control" rows="3" required></textarea></div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Materi -->
  <?php foreach ($materi as $m): ?>
    <div class="modal fade" id="editMateri<?= $m->id_materi ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/edit_materi/' . $m->id_materi) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit Materi Pembelajaran</h5>
          </div>
          <div class="modal-body">
            <div class="mb-2"><label>Urutan</label><input type="number" name="urutan" class="form-control" value="<?= $m->urutan ?>"></div>
            <div class="mb-2"><label>Materi</label><textarea name="materi" class="form-control"><?= $m->materi ?></textarea></div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Modal Tambah Pustaka -->
  <div class="modal fade" id="addPustakaModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= site_url('rps/add_pustaka') ?>" class="modal-content">
        <div class="modal-header">
          <h5>Tambah Daftar Pustaka</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="mb-2"><label>Kode</label><input name="kode_pustaka" class="form-control" required></div>
          <div class="mb-2"><label>Deskripsi</label><textarea name="pustaka" class="form-control" required></textarea></div>
          <div class="mb-2"><label>Jenis</label>
            <select name="jenis" class="form-select">
              <option value="Utama">Utama</option>
              <option value="Pendukung">Pendukung</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Pustaka -->
  <?php foreach ($pustaka as $p): ?>
    <div class="modal fade" id="editPustaka<?= $p->id_pustaka ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/edit_pustaka/' . $p->id_pustaka) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit Daftar Pustaka</h5>
          </div>
          <div class="modal-body">
            <div class="mb-2"><label>Kode</label><input name="kode_pustaka" class="form-control" value="<?= $p->kode_pustaka ?>"></div>
            <div class="mb-2"><label>Deskripsi</label><textarea name="pustaka" class="form-control"><?= $p->pustaka ?></textarea></div>
            <div class="mb-2"><label>Jenis</label>
              <select name="jenis" class="form-select">
                <option <?= $p->jenis == 'Utama' ? 'selected' : '' ?> value="Utama">Utama</option>
                <option <?= $p->jenis == 'Pendukung' ? 'selected' : '' ?> value="Pendukung">Pendukung</option>
              </select>
            </div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  <!-- Modal Tambah Media -->
  <div class="modal fade" id="addMediaModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= site_url('rps/add_media') ?>" class="modal-content">
        <div class="modal-header">
          <h5>Tambah Media Pembelajaran</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="mb-2"><label>Media</label><input name="media" class="form-control" required></div>
          <div class="mb-2"><label>Jenis</label>
            <select name="jenis" class="form-select">
              <option value="Perangkat Keras">Perangkat Keras</option>
              <option value="Perangkat Lunak">Perangkat Lunak</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Media -->
  <?php foreach ($media as $m): ?>
    <div class="modal fade" id="editMedia<?= $m->id_media ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/edit_media/' . $m->id_media) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit Media Pembelajaran</h5>
          </div>
          <div class="modal-body">
            <div class="mb-2"><label>Media</label><input name="media" class="form-control" value="<?= $m->media ?>"></div>
            <div class="mb-2"><label>Jenis</label>
              <select name="jenis" class="form-select">
                <option <?= $m->jenis == 'Perangkat Keras' ? 'selected' : '' ?> value="Perangkat Keras">Perangkat Keras</option>
                <option <?= $m->jenis == 'Perangkat Lunak' ? 'selected' : '' ?> value="Perangkat Lunak">Perangkat Lunak</option>
              </select>
            </div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  <!-- Modal Tambah Penilaian -->
  <div class="modal fade" id="addPenilaianModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= site_url('rps/add_penilaian') ?>" class="modal-content">
        <div class="modal-header">
          <h5>Tambah Bentuk Penilaian</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="mb-2"><label>Bentuk Penilaian</label><input name="bentuk" class="form-control" required></div>
          <div class="mb-2"><label>Keterangan</label><textarea name="keterangan" class="form-control" rows="3" required></textarea></div>
          <div class="mb-2"><label>Bobot (%)</label><input type="number" name="bobot" class="form-control" step="0.1" required></div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Penilaian -->
  <?php foreach ($penilaian as $p): ?>
    <div class="modal fade" id="editPenilaian<?= $p->id_penilaian ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="post" action="<?= site_url('rps/edit_penilaian/' . $p->id_penilaian) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit Bentuk Penilaian</h5>
          </div>
          <div class="modal-body">
            <div class="mb-2"><label>Bentuk Penilaian</label><input name="bentuk" class="form-control" value="<?= $p->bentuk ?>"></div>
            <div class="mb-2"><label>Keterangan</label><textarea name="keterangan" class="form-control"><?= $p->keterangan ?></textarea></div>
            <div class="mb-2"><label>Bobot (%)</label><input name="bobot" class="form-control" value="<?= $p->bobot ?>"></div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  <!-- ========== Modal Tambah Pertemuan ========== -->
  <div class="modal fade" id="addPertemuanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form method="post" action="<?= site_url('rps/add_pertemuan') ?>" class="modal-content">
        <div class="modal-header">
          <h5>Tambah Pertemuan</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rps" value="<?= $rps->id_rps ?>">
          <div class="row">
            <div class="col-md-4 mb-2">
              <label>Minggu ke</label>
              <input type="number" name="minggu_ke" class="form-control" required>
            </div>
            <div class="col-md-4 mb-2">
              <label>CPMK</label>
              <select name="id_rps_cpmk" class="form-select">
                <option value="">- Pilih -</option>
                <?php foreach ($cpmk as $c): ?>
                  <option value="<?= $c->id_rps_cpmk ?>"><?= $c->kode_cpmk ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-2">
              <label>Materi</label>
              <select name="id_materi" class="form-select">
                <option value="">- Pilih -</option>
                <?php foreach ($materi as $m): ?>
                  <option value="<?= $m->id_materi ?>"><?= $m->materi ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-2">
              <label>Media</label>
              <select name="id_media" class="form-select">
                <option value="">- Pilih -</option>
                <?php foreach ($media as $m): ?>
                  <option value="<?= $m->id_media ?>"><?= $m->media ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-2">
              <label>Pustaka</label>
              <select name="id_pustaka" class="form-select">
                <option value="">- Pilih -</option>
                <?php foreach ($pustaka as $p): ?>
                  <option value="<?= $p->id_pustaka ?>"><?= $p->kode_pustaka ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-2">
              <label>Bentuk Penilaian</label>
              <select name="id_penilaian" class="form-select">
                <option value="">- Pilih -</option>
                <?php foreach ($penilaian as $p): ?>
                  <option value="<?= $p->id_penilaian ?>"><?= $p->bentuk ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mb-2">
            <label>Aktivitas Sinkronus</label>
            <textarea name="sinkronus" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-2">
            <label>Aktivitas Asinkronus</label>
            <textarea name="asinkronus" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer"><button class="btn btn-success">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- ========== Modal Edit Pertemuan ========== -->
  <?php foreach ($pertemuan as $p): ?>
    <div class="modal fade" id="editPertemuan<?= $p->id_pertemuan ?>" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form method="post" action="<?= site_url('rps/edit_pertemuan/' . $p->id_pertemuan) ?>" class="modal-content">
          <div class="modal-header">
            <h5>Edit Pertemuan Minggu ke <?= $p->minggu_ke ?></h5>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4 mb-2">
                <label>Minggu ke</label>
                <input type="number" name="minggu_ke" class="form-control" value="<?= $p->minggu_ke ?>">
              </div>
              <div class="col-md-4 mb-2">
                <label>CPMK</label>
                <select name="id_rps_cpmk" class="form-select">
                  <option value="">- Pilih -</option>
                  <?php foreach ($cpmk as $c): ?>
                    <option value="<?= $c->id_rps_cpmk ?>" <?= $p->id_rps_cpmk == $c->id_rps_cpmk ? 'selected' : '' ?>><?= $c->kode_cpmk ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 mb-2">
                <label>Materi</label>
                <select name="id_materi" class="form-select">
                  <option value="">- Pilih -</option>
                  <?php foreach ($materi as $m): ?>
                    <option value="<?= $m->id_materi ?>" <?= $p->id_materi == $m->id_materi ? 'selected' : '' ?>><?= $m->materi ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 mb-2">
                <label>Media</label>
                <select name="id_media" class="form-select">
                  <option value="">- Pilih -</option>
                  <?php foreach ($media as $m): ?>
                    <option value="<?= $m->id_media ?>" <?= $p->id_media == $m->id_media ? 'selected' : '' ?>><?= $m->media ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 mb-2">
                <label>Pustaka</label>
                <select name="id_pustaka" class="form-select">
                  <option value="">- Pilih -</option>
                  <?php foreach ($pustaka as $ps): ?>
                    <option value="<?= $ps->id_pustaka ?>" <?= $p->id_pustaka == $ps->id_pustaka ? 'selected' : '' ?>><?= $ps->kode_pustaka ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 mb-2">
                <label>Bentuk Penilaian</label>
                <select name="id_penilaian" class="form-select">
                  <option value="">- Pilih -</option>
                  <?php foreach ($penilaian as $pn): ?>
                    <option value="<?= $pn->id_penilaian ?>" <?= $p->id_penilaian == $pn->id_penilaian ? 'selected' : '' ?>><?= $pn->bentuk ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="mb-2">
              <label>Aktivitas Sinkronus</label>
              <textarea name="sinkronus" class="form-control"><?= $p->sinkronus ?></textarea>
            </div>
            <div class="mb-2">
              <label>Aktivitas Asinkronus</label>
              <textarea name="asinkronus" class="form-control"><?= $p->asinkronus ?></textarea>
            </div>
            <div class="mb-2">
              <label>Keterangan</label>
              <textarea name="keterangan" class="form-control"><?= $p->keterangan ?></textarea>
            </div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>