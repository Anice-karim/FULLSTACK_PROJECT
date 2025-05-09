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
    <title>Login</title>
    <link rel="icon" href="../img/icon.svg" type="image/svg+xml">
  </head>
  <body>
  <body class="min-h-screen flex items-center justify-center px-4">
    <div class="background" id="background"></div>

    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">
      <h1 class="text-4xl font-bold text-blue-400 text-center mb-8">Login / Register</h1>

      <form method="POST" action="logincode.php" class="space-y-6">
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            id="email"
            class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            placeholder="you@example.com"
            name="email"
            required
          />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            id="password"
            class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            placeholder="••••••••"
            name="password"
            required
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full py-3 rounded-lg bg-blue-300 hover:bg-blue-700 text-white font-semibold transition duration-300"
          name="login_btn"
        >
          Submit
        </button>
      </form>
    </div>
    <script>
        const password = document.getElementById('password')
        const background = document.getElementById('background')

        password.addEventListener('input', (e) => {
        const input = e.target.value
        const length = input.length
        const blurValue = 20 - length * 2
        background.style.filter = `blur(${blurValue}px)`
        })
    </script>
  </body>
</html>
