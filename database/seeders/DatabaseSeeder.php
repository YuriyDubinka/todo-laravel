<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Створюємо конкретного юзера для тестів (щоб ми знали логін/пароль)
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Пароль буде: password
        ]);

        // 2. Створюємо для нього 5 категорій
        $categories = \App\Models\Category::factory(5)->create([
            'user_id' => $user->id
        ]);

        // 3. Для кожної категорії створюємо по 10 завдань
        foreach ($categories as $category) {
            \App\Models\Task::factory(10)->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
        
        // 4. І ще 5 завдань "без категорії" (category_id = null)
        \App\Models\Task::factory(5)->create([
            'user_id' => $user->id,
            'category_id' => null
        ]);
    }
}
