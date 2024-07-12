<?php

namespace Database\Factories;

use App\Enums\ActivityLogs\ActivityLogsEventEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ActivityLog>
 */
final class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $boolean = fake()->boolean(50);
        return [
            'user_id'      => null,
            'is_anonymous' => $boolean,
            'is_console'   => !$boolean,
            'model_class'  => "\App\Models\User",
            'model_id'     => 1,
            'event'        => \collect(ActivityLogsEventEnum::toArray())->random()->value,
            'data'         => [],
            'created_at'   => now(),
        ];
    }
}
