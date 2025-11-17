<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - RoomBook</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Premium Terracotta + Sage Theme */
    .gradient-bg {
      background: linear-gradient(135deg, #D2691E 0%, #C2571A 100%); /* Terracotta gradient */
    }
    .sidebar-bg {
      background: linear-gradient(180deg, #FFF8F0 0%, #FAF3E8 100%); /* Warm cream */
    }
    .menu-item {
      transition: all 0.2s ease;
    }
    .menu-item:hover {
      transform: translateX(3px);
    }
    .glass-effect {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.9);
    }
    
    /* Global Gray to Terracotta/Sage Theme Override */
    .text-gray-300 { color: #E8C5A5 !important; } /* light terracotta */
    .text-gray-400 { color: #8B9D83 !important; } /* sage */
    .text-gray-500 { color: #6B7F61 !important; } /* darker sage */
    .text-gray-600 { color: #8B4513 !important; } /* saddle brown */
    .text-gray-700 { color: #6B4423 !important; } /* dark terracotta */
    .text-gray-800 { color: #5A3A1A !important; } /* espresso */
    .text-gray-900 { color: #3E2A1A !important; } /* dark espresso */
    
    .bg-gray-50 { background-color: #FFF8F0 !important; } /* warm cream */
    .bg-gray-100 { background-color: #F5E6D3 !important; } /* light beige */
    .bg-gray-200 { background-color: #E8D5C4 !important; } /* beige */
    .bg-gray-300 { background-color: #D4C4B0 !important; } /* tan */
    .bg-gray-500 { background-color: #8B9D83 !important; } /* sage */
    .bg-gray-600 { background-color: #6B7F61 !important; } /* darker sage */
    .bg-gray-700 { background: linear-gradient(135deg, #D2691E 0%, #C2571A 100%) !important; } /* terracotta gradient */
    .bg-gray-800 { background: linear-gradient(135deg, #D2691E 0%, #C2571A 100%) !important; } /* terracotta gradient */
    .bg-gray-900 { background: linear-gradient(135deg, #C2571A 0%, #A0461A 100%) !important; } /* darker terracotta */
    
    .border-gray-100 { border-color: #F5E6D3 !important; }
    .border-gray-200 { border-color: #E8D5C4 !important; }
    .border-gray-300 { border-color: #D4C4B0 !important; }
    
    .hover\:bg-gray-50:hover { background-color: #FFF8F0 !important; }
    .hover\:bg-gray-100:hover { background-color: #F5E6D3 !important; }
    .hover\:bg-gray-600:hover { background-color: #5A665A !important; }
    .hover\:bg-gray-900:hover { background: linear-gradient(135deg, #C2571A 0%, #A0461A 100%) !important; }
    
    .focus\:border-gray-500:focus { border-color: #D2691E !important; }
    
    /* Override indigo colors to terracotta */
    .border-indigo-500 { border-color: #D2691E !important; }
    .bg-indigo-100 { background-color: #F5E6D3 !important; }
    .text-indigo-600 { color: #D2691E !important; }
    
    /* Override emerald to sage */
    .border-emerald-500 { border-color: #8B9D83 !important; }
    .bg-emerald-100 { background-color: #E8F0E5 !important; }
    .text-emerald-600 { color: #6B7F61 !important; }
    
    /* Sidebar Responsive Styles */
    .sidebar-container {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      will-change: transform, margin-left;
    }
    
    /* Mobile & Tablet - Fixed Overlay */
    @media (max-width: 1024px) {
      .sidebar-container {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 50;
        transform: translateX(-100%);
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
      }
      
      .sidebar-container.sidebar-open {
        transform: translateX(0);
      }
      
      .sidebar-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(2px);
      }
    }
    
    /* Desktop - Slide sidebar */
    @media (min-width: 1025px) {
      .sidebar-container {
        position: relative;
        transform: translateX(0);
      }
      
      .sidebar-container:not(.sidebar-open) {
        margin-left: -288px;
      }
      
      .sidebar-overlay {
        display: none !important;
      }
    }
    
    /* Hamburger Menu */
    .hamburger-menu {
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hamburger-menu:hover {
      transform: scale(1.1);
      background-color: rgba(255, 255, 255, 0.3);
    }
    
    .hamburger-menu:active {
      transform: scale(0.95);
    }
    
    /* Menu Item Animation */
    .menu-item {
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .menu-item:hover {
      transform: translateX(4px);
    }
    
    /* Smooth scroll */
    * {
      scroll-behavior: smooth;
    }
    
    /* Content transition when sidebar opens/closes */
    .flex-1.flex.flex-col {
      transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Desktop Sidebar Toggle - Tambahan untuk visibility */
    @media (min-width: 1025px) {
      body[x-data] .sidebar-container {
        transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
      }
    }
  </style>
</head>
<body style="background-color: #FAF3E0;" class="text-[15px] md:text-[16px]" x-data="{ sidebarOpen: true }">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="sidebar-overlay lg:hidden"
         style="display: none;">
    </div>
    
    <!-- Sidebar -->
    <aside class="sidebar-container w-72 sidebar-bg border-r-2 border-orange-100 shadow-lg flex flex-col"
           :class="{ 'sidebar-open': sidebarOpen }">
      
      <div class="p-6 border-b border-orange-100">
        <div class="flex items-center justify-center mb-2">
          <div class="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center shadow-md">
            <i class="fas fa-door-open text-white text-2xl"></i>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-amber-900 text-center mb-1">RoomBook</h1>
        <p class="text-xs text-amber-700 text-center bg-orange-50 rounded-lg py-1 px-3">Sistem Peminjaman Ruangan</p>
      </div>
      <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
        @php $role = Auth::user()->role ?? 3; @endphp
        
        <a href="/dashboard" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('dashboard') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
          <div class="flex items-center">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('dashboard') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
              <i class="fas fa-home text-xl"></i>
            </div>
            <span class="ml-3">Dashboard</span>
          </div>
          @if(Request::is('dashboard'))
          <i class="fas fa-chevron-right"></i>
          @endif
        </a>
        
        @if($role === 1)
          <!-- Menu Admin -->
          <a href="{{ route('bookings.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('bookings*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('bookings*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-clipboard-list text-xl"></i>
              </div>
              <span class="ml-3">Kelola Peminjaman</span>
            </div>
            @if(Request::is('bookings*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('rooms.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('rooms*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('rooms*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-door-open text-xl"></i>
              </div>
              <span class="ml-3">Kelola Ruangan</span>
            </div>
            @if(Request::is('rooms*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('reports.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('reports*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('reports*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-chart-bar text-xl"></i>
              </div>
              <span class="ml-3">Laporan</span>
            </div>
            @if(Request::is('reports*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('schedule.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            @if(Request::is('schedule*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('jadwal-reguler.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('jadwal-reguler*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('jadwal-reguler*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar-check text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Reguler</span>
            </div>
            @if(Request::is('jadwal-reguler*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('users.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('users*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('users*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-users text-xl"></i>
              </div>
              <span class="ml-3">Kelola Pengguna</span>
            </div>
            @if(Request::is('users*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('staff.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('staff*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('staff*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-user-tie text-xl"></i>
              </div>
              <span class="ml-3">Kelola Petugas</span>
            </div>
            @if(Request::is('staff*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
        @elseif($role === 2)
          <!-- Menu Petugas -->
          <a href="{{ route('bookings.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('bookings*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('bookings*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-clipboard-check text-xl"></i>
              </div>
              <span class="ml-3">Kelola Peminjaman</span>
            </div>
            @if(Request::is('bookings*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('reports.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('reports*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('reports*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-chart-bar text-xl"></i>
              </div>
              <span class="ml-3">Laporan</span>
            </div>
            @if(Request::is('reports*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('schedule.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            @if(Request::is('schedule*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('jadwal-reguler.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('jadwal-reguler*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('jadwal-reguler*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar-check text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Reguler</span>
            </div>
            @if(Request::is('jadwal-reguler*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
        @else
          <!-- Menu User/Peminjam -->
          <a href="{{ route('user.slot-booking.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('user/slot-booking') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('user/slot-booking') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar-plus text-xl"></i>
              </div>
              <span class="ml-3">Pengajuan Pinjaman</span>
            </div>
            @if(Request::is('user/slot-booking'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
          <a href="{{ route('schedule.index') }}" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium' }}">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50' }}">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            @if(Request::is('schedule*'))
            <i class="fas fa-chevron-right"></i>
            @endif
          </a>
        @endif
      </nav>
      <!-- Logout button di bagian bawah -->
      <div class="p-4 border-t border-orange-100 bg-orange-50">
        <!-- Form logout wajib POST agar lolos proteksi CSRF; tambahkan id agar bisa dipicu via link/JS -->
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="flex items-center px-4 py-3 text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl w-full font-semibold transition-all hover:shadow-md">
            <div class="w-10 h-10 rounded-lg bg-white bg-opacity-20 flex items-center justify-center">
              <i class="fas fa-sign-out-alt text-xl"></i>
            </div>
            <span class="ml-3">Keluar</span>
          </button>
        </form>
        <!-- Fallback optional: link yang memanggil submit form tanpa buka GET /logout (menghindari 419) -->
        <div class="mt-2 text-center">
          <a href="{{ route('logout.get') }}" class="text-xs text-red-600 hover:underline">(Klik sini jika tombol tidak bekerja)</a>
        </div>
      </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="gradient-bg px-4 md:px-8 py-4 md:py-6 sticky top-0 z-30 shadow-2xl">
        <div class="flex items-center justify-between gap-3">
          <!-- Title (Kiri) - Hidden on mobile -->
          <div class="hidden md:block">
            <h1 class="text-xl md:text-2xl font-bold text-white drop-shadow-lg">@yield('title')</h1>
            <p class="text-xs md:text-sm text-orange-100 font-medium">@yield('subtitle', 'Sistem Peminjaman Ruangan')</p>
          </div>
          
          <!-- Spacer untuk mobile agar menu tetap di kanan -->
          <div class="flex-1 md:hidden"></div>
          
          <!-- Hamburger + User Info (Kanan, berdekatan) -->
          <div class="flex items-center gap-2 md:gap-3 ml-auto">
            <!-- Hamburger Menu -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="hamburger-menu w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-lg text-white hover:bg-white hover:bg-opacity-30 flex-shrink-0">
              <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- User Profile Dropdown -->
            <div class="relative" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
              <button @click="profileOpen = !profileOpen" 
                      class="flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-sm px-2 md:px-3 py-2 rounded-xl hover:bg-opacity-30 transition-all group">
                <div class="text-right hidden md:block">
                  <p class="text-xs font-bold text-white leading-tight">{{ Auth::user()->nama ?? 'User' }}</p>
                  <p class="text-[10px] text-orange-100 font-medium">
                    @php $r = Auth::user()->role ?? 1; @endphp
                    {{ $r==1?'Admin':($r==2?'Petugas':'User') }}
                  </p>
                </div>
                <div class="w-9 h-9 md:w-10 md:h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-sm md:text-base font-bold shadow-lg border-2 border-white/50 group-hover:scale-110 transition-transform">
                  {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
                </div>
                <i class="fas fa-chevron-down text-white text-xs transition-transform duration-300 hidden md:block" :class="{ 'rotate-180': profileOpen }"></i>
              </button>
              
              <!-- Dropdown Menu -->
              <div x-show="profileOpen" 
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 translate-y-2"
                   x-transition:enter-end="opacity-100 translate-y-0"
                   x-transition:leave="transition ease-in duration-150"
                   x-transition:leave-start="opacity-100 translate-y-0"
                   x-transition:leave-end="opacity-0 translate-y-2"
                   class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border border-orange-100 overflow-hidden z-50"
                   style="display: none;">
                <!-- Header dengan Gradient -->
                <div class="gradient-bg px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/30 rounded-full flex items-center justify-center text-white text-lg font-bold border-2 border-white/50">
                      {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                      <p class="text-sm font-bold text-white">{{ Auth::user()->nama ?? 'User' }}</p>
                      <p class="text-xs text-orange-100">
                        @php $r = Auth::user()->role ?? 1; @endphp
                        {{ $r==1?'Administrator':($r==2?'Petugas':'Pengguna') }}
                      </p>
                    </div>
                  </div>
                </div>
                
                <!-- Menu Items -->
                <div class="py-2 px-3 space-y-2">
                  <!-- Edit Profile -->
                  <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center group-hover:shadow-md transition-shadow">
                      <i class="fas fa-user-circle text-orange-600 text-lg"></i>
                    </div>
                    <div>
                      <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors">Edit Profil</p>
                      <p class="text-xs text-gray-500">Kelola akun Anda</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-gradient-to-br from-orange-50 to-amber-50">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
