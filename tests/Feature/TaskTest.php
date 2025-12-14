<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    // Цей трейт автоматично очищує базу після кожного тесту.
    // Твоя реальна база даних не постраждає!
    use RefreshDatabase;

    // Сценарій 1: Чи може юзер бачити свої задачі?
    public function test_authenticated_user_can_see_dashboard()
    {
        // 1. Arrange (Підготовка): Створюємо юзера
        $user = User::factory()->create();

        // 2. Act (Дія): Логінимось і йдемо на дашборд
        $response = $this->actingAs($user)->get('/dashboard');

        // 3. Assert (Перевірка): Очікуємо статус 200 (OK)
        $response->assertStatus(200);
    }

    // Сценарій 2: Чи захищений дашборд від гостей?
    public function test_guest_cannot_see_dashboard()
    {
        // 1. Act: Йдемо на дашборд БЕЗ логіна
        $response = $this->get('/dashboard');

        // 2. Assert: Нас має перекинути на логін (302 Redirect)
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    // Сценарій 3: Створення задачі
    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'New Automated Task',
        ]);

        // Перевіряємо, що нас перекинули назад на дашборд
        $response->assertRedirect(route('dashboard'));

        // Перевіряємо, що запис з'явився в базі даних
        $this->assertDatabaseHas('tasks', [
            'title' => 'New Automated Task',
            'user_id' => $user->id
        ]);
    }
}