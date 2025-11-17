<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Peminjaman Ruangan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .gradient-bg {
      background: linear-gradient(135deg, #D2691E 0%, #C2571A 100%);
    }
    body {
      background: linear-gradient(135deg, #FFF8F0 0%, #FAF3E8 100%);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
  <div class="max-w-md w-full">
    <!-- Logo & Brand -->
    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold mb-2" style="color: #5A3A1A;">RoomBook</h1>
      <p class="text-amber-700 font-medium">Sistem Peminjaman Ruangan</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-orange-100">
      <h2 class="text-2xl font-bold mb-6 text-center" style="color: #5A3A1A;">Masuk ke Akun Anda</h2>

      @if(session('success'))
      <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
          <i class="fas fa-check-circle mr-2"></i>
          {{ session('success') }}
        </div>
      </div>
      @endif

      @if($errors->any())
      <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
          <i class="fas fa-exclamation-circle mr-2"></i>
          {{ $errors->first() }}
        </div>
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}" autocomplete="off" id="loginForm">
        @csrf
        
        <div class="mb-5">
          <label class="block font-semibold mb-2" style="color: #5A3A1A;">
            <i class="fas fa-user mr-2" style="color: #D2691E;"></i>Username
          </label>
          <input type="text" name="username" id="username" required 
                 autocomplete="off" 
                 class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition"
                 style="border-color: #E8C5A5; color: #5A3A1A;"
                 onfocus="this.style.borderColor='#D2691E'" 
                 onblur="this.style.borderColor='#E8C5A5'"
                 placeholder="Masukkan username">
        </div>

        <div class="mb-6">
          <label class="block font-semibold mb-2" style="color: #5A3A1A;">
            <i class="fas fa-lock mr-2" style="color: #D2691E;"></i>Password
          </label>
          <input type="password" name="password" id="password" required 
                 autocomplete="off" 
                 class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition"
                 style="border-color: #E8C5A5; color: #5A3A1A;"
                 onfocus="this.style.borderColor='#D2691E'" 
                 onblur="this.style.borderColor='#E8C5A5'"
                 placeholder="Masukkan password">
        </div>

        <button type="submit" class="w-full gradient-bg text-white font-bold py-3 rounded-xl transition transform hover:scale-[1.02] hover:shadow-2xl flex items-center justify-center" onclick="this.form.querySelector('input[name=_token]')?.setAttribute('value','{{ csrf_token() }}')">
          <i class="fas fa-sign-in-alt mr-2"></i>
          Masuk
        </button>
      </form>

      <div class="mt-6 text-center">
        <p class="text-amber-700">Belum punya akun? 
          <a href="{{ route('register') }}" class="font-bold hover:underline" style="color: #D2691E;">Daftar Sekarang</a>
        </p>
      </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-6 text-amber-700">
      <p class="text-sm">&copy; {{ date('Y') }} RoomBook. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
