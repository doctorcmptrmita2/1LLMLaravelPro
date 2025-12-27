<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin kullanıcısı oluştur veya güncelle
        $admin = User::firstOrCreate(
            ['email' => 'admin@codexflow.dev'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin123!'),
                'api_key' => 'cf_' . bin2hex(random_bytes(32)),
                'plan' => 'agency',
                'status' => 'active',
                'is_admin' => true,
            ]
        );

        // Eğer kullanıcı zaten varsa, admin yetkisi ver
        if (!$admin->is_admin) {
            $admin->update(['is_admin' => true]);
        }

        $this->command->info('Admin kullanıcısı oluşturuldu/güncellendi!');
        $this->command->info('Email: admin@codexflow.dev');
        $this->command->info('Şifre: Admin123!');
        $this->command->warn('⚠️  Production\'da şifreyi değiştirmeyi unutmayın!');
    }
}

