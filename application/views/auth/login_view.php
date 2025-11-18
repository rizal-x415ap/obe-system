<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sistem OBE</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f7f7f7;
      /* Putih polos */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: #ffffff;
      width: 100%;
      max-width: 420px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      animation: muncul 0.5s ease-out;
    }

    @keyframes muncul {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white;
      text-align: center;
      padding: 2rem 1.5rem;
    }

    .login-header h3 {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .login-header p {
      font-size: 0.95rem;
      opacity: 0.9;
    }

    .login-body {
      padding: 2.5rem 2rem;
    }

    /* Alert error dari PHP */
    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
      padding: 14px 16px;
      border-radius: 10px;
      border-left: 5px solid #ef4444;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #1f2937;
      font-size: 0.95rem;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f9fafb;
    }

    input:focus {
      outline: none;
      border-color: #4f46e5;
      background: #ffffff;
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }

    .btn-masuk {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-masuk:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
    }

    /* Responsive */
    @media (max-width: 480px) {
      .login-header {
        padding: 1.8rem 1.2rem;
      }

      .login-header h3 {
        font-size: 1.6rem;
      }

      .login-body {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-card">
    <div class="login-header">
      <h3>Login Sistem OBE</h3>
      <p>Masuk menggunakan User ID dan Password</p>
    </div>

    <div class="login-body">

      <?php if (!empty($error)): ?>
        <div class="alert-danger">
          <?= htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form action="<?= site_url('login/auth'); ?>" method="post">
        <div class="form-group">
          <label for="userid">User ID</label>
          <input type="text" name="userid" id="userid" placeholder="Masukkan User ID Anda" required autocomplete="username">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Masukkan password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn-masuk">Masuk</button>
      </form>
    </div>
  </div>

</body>

</html>