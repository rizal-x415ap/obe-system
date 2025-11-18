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
             <li class="breadcrumb-item"><a href="<?= base_url($this->uri->segment(1)); ?>"><?= $this->uri->segment(1); ?></a></li>
             <li class="breadcrumb-item active" aria-current="page"><?= $this->uri->segment(2); ?></li>
           </ol>
         </nav>
       </div>
     </div>
   </div>

   <section class="section">
     <div class="card">
       <div class="card-body">
         <div class="text-center">
           <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalIdentitas">+ Add RPS</button>
         </div>
         <!-- TAB 1 IDENTITAS -->
         <div class="tab-pane fade show active" id="identitas">
           <table id="tabelRps" class="table table-bordered table-striped">
             <thead class="table-secondary">
               <tr>
                 <th>Mata Kuliah</th>
                 <th>Deskripsi</th>
                 <th>SKS (Teori + Praktik)</th>
                 <th>Semester</th>
                 <th>Koordinator</th>
                 <th>Tanggal</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody>
               <?php foreach ($rps as $r): ?>
                 <tr>
                   <td><b><?= $r->KodeMK ?></b> - <?= $r->NamaMK ?></td>
                   <td><?= substr($r->deskripsi, 0, 100) ?></td>
                   <td><?= $r->sks_teori + $r->sks_praktek ?></td>
                   <td><?= $r->semester ?></td>
                   <td><?= $r->koordinator_pengembang ?></td>
                   <td><?= $r->tanggal_penyusunan ?></td>
                   <td>
                     <a href="<?= site_url('rps/detail/' . $r->id_rps) ?>" class="btn btn-sm btn-primary">Detail</a>
                     <a href="<?= site_url('rps/cetak/' . $r->id_rps) ?>" class="btn btn-sm btn-success">Print</a>
                     <a href="<?= site_url('rps/delete/' . $r->id_rps) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                   </td>
                 </tr>
               <?php endforeach; ?>
             </tbody>
           </table>
         </div>
   </section>


 </div>
 </div>

 <?php $this->load->view('rps/modal_identitas'); ?>

 <script src="<?php echo base_url('assets/'); ?>static/js/components/dark.js"></script>
 <script src="<?php echo base_url('assets/'); ?>extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

 <script src="<?php echo base_url('assets/'); ?>extensions/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="<?php echo base_url('assets/'); ?>extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
 <script src="<?php echo base_url('assets/'); ?>static/js/pages/datatables.js"></script>


 <script src="<?php echo base_url('assets/'); ?>compiled/js/app.js"></script>

 <!-- Toast -->
 <script src="<?php echo base_url('assets/'); ?>static/js/pages/component-toasts.js"></script>
 <!-- Sweetalert -->
 <script src="<?php echo base_url('assets/'); ?>extensions/sweetalert2/sweetalert2.min.js"></script>
 <script>
   new DataTable('#tabelRps');
 </script>
 </body>

 </html>