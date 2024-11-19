<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Maria Capitango',
            'email' =>'marcelosetmark@gmail.com',
            'user_title' =>'Administrador Geral',
            'user_type' => 1,
            'password' => Hash::make('Maria2024#'),
            'privileges' =>json_encode([
                'users' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'enrollments' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'registrations' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'courses' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'shifts' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'course-contents' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'summary-calendar' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'classes' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'payments' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'products' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ],
                'audits' => [
                    'get' => 1,
                    'store' => 1,
                    'put' => 1,
                    'delete' => 1
                ]
            ]),
            'settings' => json_encode([
                'twofa' => false, // Booleano como string
                'endSessionInact' => 10 // Número inteiro
            ]),
            'account_status' => 0,
            'created_at' => now()
        ]);
    }
}
