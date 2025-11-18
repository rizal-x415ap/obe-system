<div class="container my-4">

  <h3 class="mb-4"><?= isset($title) ? $title : 'Input Nilai OBE'; ?></h3>

  <div class="card mb-4">
    <div class="card-body">
      <form id="form-filter">
        <div class="row g-3 align-items-end">
          <div class="col-md-5">
            <label for="kode_mk" class="form-label">Mata Kuliah</label>
            <select name="kode_mk" id="kode_mk" class="form-select" required>
              <option value="">-- Pilih Mata Kuliah --</option>
              <?php if (!empty($matkul)): ?>
                <?php foreach ($matkul as $mk): ?>
                  <option value="<?= $mk->kode_mk; ?>">
                    <?= $mk->kode_mk . ' - ' . $mk->NamaMK; ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label for="kode_kelas" class="form-label">Kelas</label>
            <select name="kode_kelas" id="kode_kelas" class="form-select" required>
              <option value="">-- Pilih Kelas --</option>
              <!-- diisi via AJAX -->
            </select>
          </div>

          <div class="col-md-3">
            <button type="button" id="btn-tampilkan" class="btn btn-primary w-100">
              Tampilkan Nilai
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="wrapper-form-nilai">
    <!-- form nilai (tabel) akan dimuat via AJAX -->
  </div>
</div>

<script>
  const baseUrl = "<?= site_url(); ?>";

  // --- Konversi nilai akhir ke huruf ---
  function konversiHuruf(na) {
    if (isNaN(na)) return '-';
    if (na >= 85) return 'A';
    if (na >= 80) return 'A-';
    if (na >= 75) return 'B+';
    if (na >= 70) return 'B';
    if (na >= 65) return 'B-';
    if (na >= 60) return 'C+';
    if (na >= 55) return 'C';
    if (na >= 50) return 'D';
    return 'E';
  }

  // --- Hitung NA & huruf untuk satu baris ---
  function hitungNilaiBaris(tr) {
    let totalPembobotan = 0;
    let totalBobot = 0;

    const inputs = tr.querySelectorAll('.input-nilai-cpmk');
    inputs.forEach(function(input) {
      const bobot = parseFloat(input.getAttribute('data-bobot') || '0');
      const nilai = parseFloat(input.value || '0');

      if (!isNaN(nilai) && !isNaN(bobot)) {
        totalPembobotan += (nilai * bobot);
        totalBobot += bobot;
      }
    });

    let na = 0;
    if (totalBobot > 0) {
      na = totalPembobotan / totalBobot;
    }

    const spanNA = tr.querySelector('.nilai-akhir');
    const spanHuruf = tr.querySelector('.nilai-huruf');

    if (spanNA) {
      spanNA.textContent = na.toFixed(2);
      spanNA.className = 'badge bg-primary nilai-akhir';
    }
    if (spanHuruf) {
      spanHuruf.textContent = konversiHuruf(na);
      spanHuruf.className = 'badge bg-primary nilai-huruf';
    }
  }

  // --- Simpan satu sel nilai via AJAX ---
  function simpanNilaiCell(input) {
    const nim = input.getAttribute('data-nim');
    const kodeMk = input.getAttribute('data-kode-mk');
    const idCpmk = input.getAttribute('data-id-cpmk');
    const nilai = input.value;

    const formData = new URLSearchParams();
    formData.append('nim', nim);
    formData.append('kode_mk', kodeMk);
    formData.append('id_cpmk', idCpmk);
    formData.append('nilai', nilai);

    fetch(baseUrl + 'nilai/ajax_save_nilai', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(res => res.json())
      .then(res => {
        if (res.status !== 'success') {
          console.error(res.message || 'Gagal menyimpan nilai');
        }
      })
      .catch(err => console.error(err));
  }

  // --- Load Kelas berdasar MK ---
  document.getElementById('kode_mk').addEventListener('change', function() {
    const kodeMk = this.value;
    const selectKelas = document.getElementById('kode_kelas');
    selectKelas.innerHTML = '<option value="">-- Pilih Kelas --</option>';

    if (!kodeMk) return;

    fetch(baseUrl + 'nilai/ajax_get_kelas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
          kode_mk: kodeMk
        })
      })
      .then(res => res.json())
      .then(data => {
        if (Array.isArray(data)) {
          data.forEach(row => {
            const opt = document.createElement('option');
            opt.value = row.kode_kelas;
            opt.textContent = row.nmkelas || row.kode_kelas;
            selectKelas.appendChild(opt);
          });
        }
      })
      .catch(err => console.error(err));
  });

  // --- Tampilkan form nilai ---
  document.getElementById('btn-tampilkan').addEventListener('click', function() {
    const kodeMk = document.getElementById('kode_mk').value;
    const kodeKelas = document.getElementById('kode_kelas').value;

    if (!kodeMk || !kodeKelas) {
      alert('Silakan pilih mata kuliah dan kelas terlebih dahulu.');
      return;
    }

    const wrapper = document.getElementById('wrapper-form-nilai');
    wrapper.innerHTML = '<div class="text-center py-5">Loading...</div>';

    fetch(baseUrl + 'nilai/ajax_load_form', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
          kode_mk: kodeMk,
          kode_kelas: kodeKelas
        })
      })
      .then(res => res.text())
      .then(html => {
        wrapper.innerHTML = html;

        // Hitung NA awal untuk semua baris (kalau ada nilai existing)
        const rows = wrapper.querySelectorAll('#tabel1 tbody tr');
        rows.forEach(tr => hitungNilaiBaris(tr));
      })
      .catch(err => {
        console.error(err);
        wrapper.innerHTML = '<div class="alert alert-danger">Gagal memuat data.</div>';
      });
  });

  // --- Event delegation: blur di input-nilai-cpmk ---
  document.addEventListener('blur', function(e) {
    if (e.target && e.target.classList.contains('input-nilai-cpmk')) {
      const input = e.target;
      simpanNilaiCell(input);

      const tr = input.closest('tr');
      if (tr) hitungNilaiBaris(tr);
    }
  }, true); // useCapture = true supaya blur ketangkep
</script>