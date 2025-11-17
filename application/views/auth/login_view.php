<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login Sistem OBE</title>
  <link rel="stylesheet" crossorigin href="<?php echo base_url('assets/'); ?>compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="<?php echo base_url('assets/'); ?>compiled/css/app-dark.css">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header text-center bg-primary text-white">
            <h5 class="text-white">Login Sistem OBE</h5>
          </div>
          <div class="card-body">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            <form action="<?= site_url('login/auth'); ?>" method="post">
              <div class="mb-3 mt-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>