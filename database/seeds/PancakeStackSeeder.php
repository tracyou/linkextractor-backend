<?php

use App\Enums\RoleNameEnum;
use App\Enums\UserStatusEnum;
use App\Models\Company;
use App\Models\Pancake;
use App\Models\PancakeStack;
use App\Models\User;
use Illuminate\Database\Seeder;

class PancakeStackSeeder extends Seeder
{
    public function run(): void
    {
        $this->createPancakes();
        $this->createPancakeStacks();
    }

    protected function createPancakes(): void
    {
        Pancake::factory()->count(60)->create();
    }

    protected function createPancakeStacks(): void
    {
        $pancakeStack1 = PancakeStack::factory()->create(['name' => 'Pancake Stack 1']);
        $pancakeStack2 = PancakeStack::factory()->create(['name' => 'Pancake Stack 2']);

        $pancakes = Pancake::all();

        $pancakes->take(20)->each(function (Pancake $pancake) use ($pancakeStack1) {
            $pancake->stack()->associate($pancakeStack1);
            $pancake->save();
        });

        $pancakes->skip(20)->take(20)->each(function (Pancake $pancake) use ($pancakeStack2) {
            $pancake->stack()->associate($pancakeStack2);
            $pancake->save();
        });
    }
}
