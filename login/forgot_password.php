<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.8.11/tailwind.min.css"
      integrity="sha512-KO1h5ynYuqsFuEicc7DmOQc+S9m2xiCKYlC3zcZCSEw0RGDsxcMnppRaMZnb0DdzTDPaW22ID/gAGCZ9i+RT/w=="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/stylelogin.css" />
    <title>Forgot Password</title>
    <link rel="icon" href="../img/icon.svg" type="image/svg+xml">
  </head>
  <body class="min-h-screen flex items-center justify-center px-4">
    <div class="background" id="background"></div>

    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">
      <?php
      session_start();
      $msg = $_SESSION['msg'] ?? '';
      unset($_SESSION['msg']); // clear after displaying
      ?>
      <h1 class="text-4xl font-bold text-blue-400 text-center mb-8">Forgot Password</h1>
      <p class="text-gray-600 text-center mb-6">Enter your email address below and we'll send you a new password.</p>
      
      <?php if ($msg): ?>
        <div class="<?= strpos($msg, 'sent') !== false ? 'text-green-500' : 'text-red-500' ?> text-center mb-4"><?= $msg ?></div>
      <?php endif; ?>

      <form method="POST" action="reset_password_process.php" class="space-y-6">
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input
            type="email"
            id="email"
            class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            placeholder="you@example.com"
            name="email"
            required
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full py-3 rounded-lg bg-blue-300 hover:bg-blue-700 text-white font-semibold transition duration-300"
          name="reset_password_btn"
        >
          Send New Password
        </button>
        
        <!-- Back to Login -->
        <div class="text-center mt-4">
          <a href="login.php" class="text-sm text-blue-500 hover:text-blue-700 hover:underline">
            Back to Login
          </a>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  </body>
</html>
