<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Peminjaman Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #D2691E 0%, #C2571A 100%); }
        body { background: linear-gradient(135deg, #FFF8F0 0%, #FAF3E8 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-2" style="color: #5A3A1A;">RoomBook</h1>
            <p class="text-amber-700 font-medium">Daftar Akun Baru</p>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-orange-100">
            <h2 class="text-2xl font-bold mb-6 text-center" style="color: #5A3A1A;">Buat Akun Anda</h2>
            <?php if($errors->any()): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4">
                <div class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Terdapat kesalahan:</div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('register')); ?>" autocomplete="off">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block font-semibold mb-2" style="color: #5A3A1A;">
                        <i class="fas fa-user mr-2" style="color: #D2691E;"></i>Username
                    </label>
                    <input type="text" name="username" value="<?php echo e(old('username')); ?>" required autocomplete="off" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition" style="border-color: #E8C5A5; color: #5A3A1A;" onfocus="this.style.borderColor='#D2691E'" onblur="this.style.borderColor='#E8C5A5'" placeholder="Masukkan username">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-2" style="color: #5A3A1A;">
                        <i class="fas fa-id-card mr-2" style="color: #D2691E;"></i>Nama Lengkap
                    </label>
                    <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required autocomplete="off" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition" style="border-color: #E8C5A5; color: #5A3A1A;" onfocus="this.style.borderColor='#D2691E'" onblur="this.style.borderColor='#E8C5A5'" placeholder="Masukkan nama lengkap">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-2" style="color: #5A3A1A;">
                        <i class="fas fa-lock mr-2" style="color: #D2691E;"></i>Password
                    </label>
                    <input type="password" name="password" required autocomplete="off" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition" style="border-color: #E8C5A5; color: #5A3A1A;" onfocus="this.style.borderColor='#D2691E'" onblur="this.style.borderColor='#E8C5A5'" placeholder="Minimal 6 karakter">
                </div>
                <div class="mb-6">
                    <label class="block font-semibold mb-2" style="color: #5A3A1A;">
                        <i class="fas fa-lock mr-2" style="color: #D2691E;"></i>Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" required autocomplete="off" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none transition" style="border-color: #E8C5A5; color: #5A3A1A;" onfocus="this.style.borderColor='#D2691E'" onblur="this.style.borderColor='#E8C5A5'" placeholder="Masukkan ulang kata sandi">
                </div>
                <button type="submit" class="w-full gradient-bg text-white font-bold py-3 rounded-xl transition transform hover:scale-[1.02] hover:shadow-2xl flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-amber-700">Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="font-bold hover:underline" style="color: #D2691E;">Login disini</a></p>
            </div>
        </div>
        <div class="text-center mt-6 text-amber-700">
            <p class="text-sm">&copy; <?php echo e(date('Y')); ?> RoomBook. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\M S I\P3-UKK\resources\views/auth/register.blade.php ENDPATH**/ ?>