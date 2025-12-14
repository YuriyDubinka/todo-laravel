<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            // Перетворюємо true/false на зрозумілий статус
            'status' => $this->is_completed ? 'done' : 'todo',
            // Якщо є категорія — показуємо ім'я, якщо ні — null
            'category' => $this->category ? $this->category->name : null,
        ];
    }
}
