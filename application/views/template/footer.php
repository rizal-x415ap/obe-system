 <!-- TOAST -->
 <?php if ($this->session->flashdata('toast')):
    $toast = $this->session->flashdata('toast');

    // Warna ikon berdasarkan tipe
    $colors = [
      'success' => '#5ddab4',
      'error' => '#ff7976',
      'warning' => '#ffcb94',
      'info' => '#9694ff'
    ];

    $color = $colors[$toast['type']] ?? '#007aff';
  ?>
   <div class="toast-container position-fixed top-0 end-0 p-3">
     <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
       <div class="toast-header">
         <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
           <rect width="100%" height="100%" fill="<?= $color ?>"></rect>
         </svg>
         <strong class="me-auto"><?= ucfirst($toast['type']) ?></strong>
         <small>Baru saja</small>
         <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
       <div class="toast-body">
         <?= $toast['message']; ?><?= isset($toast['user']) ? '<b> ' . $toast['user'] . '</b>' : '' ?>
       </div>
     </div>
   </div>

   <script>
     // Inisialisasi toast Bootstrap
     document.addEventListener('DOMContentLoaded', function() {
       const toastEl = document.getElementById('liveToast');
       if (toastEl) {
         const bsToast = new bootstrap.Toast(toastEl);
         bsToast.show();
       }
     });
   </script>

 <?php endif; ?>
 <!-- END TOAST -->

 <footer>
   <div class="footer clearfix mb-0 text-muted">
     <div class="float-start">
       <p>2025<a href="<?= base_url() ?>"> © OBE</a></p>
     </div>
     <div class="float-end">
       <p>Made with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
         by <a href="https://instagram.com/rizaall15_">Rizal</a></p>
     </div>
   </div>
 </footer>
 </div>
 </div>
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
   const Swal2 = Swal.mixin({
     customClass: {
       input: 'form-control'
     }
   })

   const Toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000,
     timerProgressBar: true,
     didOpen: (toast) => {
       toast.addEventListener('mouseenter', Swal.stopTimer)
       toast.addEventListener('mouseleave', Swal.resumeTimer)
     }
   })
   document.getElementById("logout").addEventListener("click", async (e) => {
     const {
       isConfirmed
     } = await Swal2.fire({
       title: "Apakah kamu ingin logout?",
       icon: "question",
       showCancelButton: true,
       confirmButtonText: "Logout",
       cancelButtonText: "Batal",
       customClass: {
         confirmButton: "btn btn-danger me-2",
         cancelButton: "btn btn-secondary ms-2" // <-- tambahkan me-2
       },
       buttonsStyling: false
     });

     if (isConfirmed) {
       window.location.href = "<?php echo base_url('login/logout'); ?>";
     }
   });

   // Trigger toast jika ada
   window.addEventListener('DOMContentLoaded', function() {
     var toastEl = document.getElementById('liveToast');
     if (toastEl) {
       var toast = new bootstrap.Toast(toastEl);
       toast.show();
     }
   });
 </script>
 <?php if ($this->session->flashdata('swal')):
    $swal = $this->session->flashdata('swal');
  ?>
   <script>
     document.addEventListener("DOMContentLoaded", function() {
       Swal2.fire({
         icon: '<?= $swal['type'] ?>', // success, error, warning, info, question
         title: '<?= $swal['title'] ?>',
         text: '<?= $swal['text'] ?>',
         confirmButtonText: 'OK'
       });
     });
   </script>
 <?php endif; ?>
 <?php if ($this->session->flashdata('open_modal')): ?>
   <script>
     document.addEventListener("DOMContentLoaded", function() {
       var modalId = '<?= $this->session->flashdata('open_modal'); ?>';
       var myModal = new bootstrap.Modal(document.getElementById(modalId));
       myModal.show();
     });
   </script>
 <?php endif; ?>


 </body>
 <!-- Dibuat Oleh Rizal Efendi -->
 <!-- Ig : @rizaall15_ -->
 <!-- STIKOM Tunas Bangsa Pematang Siantar -->

 </html>