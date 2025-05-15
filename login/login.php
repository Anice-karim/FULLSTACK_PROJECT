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



<div x-data="{ show: false }" class="mt-4">
  <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>

  <!-- Flex container for input and icon -->
  <div class="flex items-center">
    <!-- Password input -->
    <input
      :type="show ? 'text' : 'password'"
      id="password"
      name="password"
      class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
      placeholder="••••••••"
      required
    />

    <!-- Eye icon button (outside input but inline right) -->
    <button
      type="button"
      @click="show = !show"
      class="ml-3 text-gray-500 hover:text-purple-600"
      :aria-label="show ? 'Hide password' : 'Show password'"
    >
      <!-- Eye open -->
      <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>

      <!-- Eye slash -->
      <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.387-4.337M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
      </svg>
    </button>
  </div>
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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  </body>
</html>
