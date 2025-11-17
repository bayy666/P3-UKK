<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title'); ?> - RoomBook</title>
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
      transition: transform 0.3s ease-in-out, margin-left 0.3s ease-in-out;
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
      }
      
      .sidebar-container.sidebar-open {
        transform: translateX(0);
      }
      
      .sidebar-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
        transition: opacity 0.3s ease-in-out;
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
      transition: all 0.3s ease;
    }
    
    .hamburger-menu:hover {
      transform: scale(1.1);
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
        <?php $role = Auth::user()->role ?? 3; ?>
        
        <a href="/dashboard" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('dashboard') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
          <div class="flex items-center">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('dashboard') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
              <i class="fas fa-home text-xl"></i>
            </div>
            <span class="ml-3">Dashboard</span>
          </div>
          <?php if(Request::is('dashboard')): ?>
          <i class="fas fa-chevron-right"></i>
          <?php endif; ?>
        </a>
        
        <?php if($role === 1): ?>
          <!-- Menu Admin -->
          <a href="<?php echo e(route('bookings.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('bookings*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('bookings*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-clipboard-list text-xl"></i>
              </div>
              <span class="ml-3">Kelola Peminjaman</span>
            </div>
            <?php if(Request::is('bookings*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('rooms.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('rooms*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('rooms*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-door-open text-xl"></i>
              </div>
              <span class="ml-3">Kelola Ruangan</span>
            </div>
            <?php if(Request::is('rooms*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('reports.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('reports*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('reports*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-chart-bar text-xl"></i>
              </div>
              <span class="ml-3">Laporan</span>
            </div>
            <?php if(Request::is('reports*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('schedule.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            <?php if(Request::is('schedule*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('jadwal-reguler.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('jadwal-reguler*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('jadwal-reguler*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar-check text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Reguler</span>
            </div>
            <?php if(Request::is('jadwal-reguler*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('users.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('users*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('users*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-users text-xl"></i>
              </div>
              <span class="ml-3">Kelola Pengguna</span>
            </div>
            <?php if(Request::is('users*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('staff.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('staff*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('staff*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-user-tie text-xl"></i>
              </div>
              <span class="ml-3">Kelola Petugas</span>
            </div>
            <?php if(Request::is('staff*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
        <?php elseif($role === 2): ?>
          <!-- Menu Petugas -->
          <a href="<?php echo e(route('bookings.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('bookings*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('bookings*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-clipboard-check text-xl"></i>
              </div>
              <span class="ml-3">Kelola Peminjaman</span>
            </div>
            <?php if(Request::is('bookings*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('reports.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('reports*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('reports*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-chart-bar text-xl"></i>
              </div>
              <span class="ml-3">Laporan</span>
            </div>
            <?php if(Request::is('reports*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('schedule.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            <?php if(Request::is('schedule*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('jadwal-reguler.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('jadwal-reguler*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('jadwal-reguler*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar-check text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Reguler</span>
            </div>
            <?php if(Request::is('jadwal-reguler*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
        <?php else: ?>
          <!-- Menu User/Peminjam -->
          <a href="<?php echo e(route('user.slot-booking.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('user/slot-booking') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('user/slot-booking') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar-plus text-xl"></i>
              </div>
              <span class="ml-3">Pengajuan Pinjaman</span>
            </div>
            <?php if(Request::is('user/slot-booking')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
          <a href="<?php echo e(route('schedule.index')); ?>" class="menu-item flex items-center justify-between px-4 py-3 rounded-xl transition-all <?php echo e(Request::is('schedule*') ? 'gradient-bg text-white font-semibold shadow-md' : 'text-amber-800 hover:bg-orange-50 font-medium'); ?>">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e(Request::is('schedule*') ? 'bg-white bg-opacity-20' : 'bg-orange-50'); ?>">
                <i class="fas fa-calendar text-xl"></i>
              </div>
              <span class="ml-3">Jadwal Ruangan</span>
            </div>
            <?php if(Request::is('schedule*')): ?>
            <i class="fas fa-chevron-right"></i>
            <?php endif; ?>
          </a>
        <?php endif; ?>
      </nav>
      <!-- Logout button di bagian bawah -->
      <div class="p-4 border-t border-orange-100 bg-orange-50">
        <!-- Form logout wajib POST agar lolos proteksi CSRF; tambahkan id agar bisa dipicu via link/JS -->
        <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="flex items-center px-4 py-3 text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl w-full font-semibold transition-all hover:shadow-md">
            <div class="w-10 h-10 rounded-lg bg-white bg-opacity-20 flex items-center justify-center">
              <i class="fas fa-sign-out-alt text-xl"></i>
            </div>
            <span class="ml-3">Keluar</span>
          </button>
        </form>
        <!-- Fallback optional: link yang memanggil submit form tanpa buka GET /logout (menghindari 419) -->
        <div class="mt-2 text-center">
          <a href="<?php echo e(route('logout.get')); ?>" class="text-xs text-red-600 hover:underline">(Klik sini jika tombol tidak bekerja)</a>
        </div>
      </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="gradient-bg px-4 md:px-8 py-4 md:py-6 sticky top-0 z-30 shadow-2xl">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3 md:gap-4 flex-1">
            <!-- Hamburger Menu -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="hamburger-menu w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-lg text-white hover:bg-white hover:bg-opacity-30 flex-shrink-0">
              <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- User Info (Tampil di semua ukuran, sebelah hamburger) -->
            <div class="flex items-center gap-2 md:gap-3 bg-white bg-opacity-20 backdrop-blur-sm px-3 md:px-4 py-2 rounded-xl flex-shrink-0">
              <div class="w-8 h-8 md:w-10 md:h-10 bg-white/30 rounded-full flex items-center justify-center text-white text-sm md:text-base font-bold shadow-md border-2 border-white/30">
                <?php echo e(strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1))); ?>

              </div>
              <div class="text-left">
                <p class="text-xs md:text-sm font-bold text-white leading-tight"><?php echo e(Auth::user()->nama ?? 'User'); ?></p>
                <p class="text-[10px] md:text-xs text-orange-100 font-medium">
                  <?php $r = Auth::user()->role ?? 1; ?>
                  <?php echo e($r==1?'Admin':($r==2?'Petugas':'User')); ?>

                </p>
              </div>
            </div>
            
            <!-- Title (Tersembunyi di mobile, muncul di tablet+) -->
            <div class="hidden lg:block">
              <h1 class="text-xl md:text-2xl font-bold text-white drop-shadow-lg"><?php echo $__env->yieldContent('title'); ?></h1>
              <p class="text-xs md:text-sm text-orange-100 font-medium"><?php echo $__env->yieldContent('subtitle', 'Sistem Peminjaman Ruangan'); ?></p>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-gradient-to-br from-orange-50 to-amber-50">
        <?php echo $__env->yieldContent('content'); ?>
      </main>
    </div>
  </div>
</body>
</html>
<?php /**PATH C:\Users\M S I\P3-UKK\resources\views/layouts/admin.blade.php ENDPATH**/ ?>