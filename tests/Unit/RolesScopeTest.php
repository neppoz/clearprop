<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Income;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RolesScopeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_applies_scope_for_non_admin_or_non_manager()
    {
        $user = User::factory()->create(['role' => 'is_member']);
        Income::factory()->create(['user_id' => $user->id]); // Record visible to user
        Income::factory()->create(['user_id' => 2]); // Record not visible to user

        $this->actingAs($user);

        $incomes = Income::all();
        $this->assertCount(1, $incomes);
        $this->assertEquals($user->id, $incomes->first()->user_id);
    }

    /** @test */
    public function it_does_not_apply_scope_for_admins()
    {
        $admin = User::factory()->create(['role' => 'is_admin']);
        Income::factory()->create(['user_id' => 1]);
        Income::factory()->create(['user_id' => 2]);

        $this->actingAs($admin);

        $incomes = Income::all();
        $this->assertCount(2, $incomes); // Admin sees all records
    }

    /** @test */
    public function it_does_not_apply_scope_for_managers()
    {
        $manager = User::factory()->create(['role' => 'is_manager']);
        Income::factory()->create(['user_id' => 1]);
        Income::factory()->create(['user_id' => 2]);

        $this->actingAs($manager);

        $incomes = Income::all();
        $this->assertCount(2, $incomes); // Manager sees all records
    }

    /** @test */
    public function it_applies_created_by_id_filter_if_column_exists()
    {
        $user = User::factory()->create(['role' => 'is_member']);
        Schema::shouldReceive('hasColumn')
            ->with('incomes', 'created_by_id')
            ->andReturn(true);

        Income::factory()->create(['user_id' => 2, 'created_by_id' => $user->id]); // Record visible to user
        Income::factory()->create(['user_id' => 2, 'created_by_id' => 2]); // Record not visible to user

        $this->actingAs($user);

        $incomes = Income::all();
        $this->assertCount(1, $incomes);
        $this->assertEquals($user->id, $incomes->first()->created_by_id);
    }

    /** @test */
    public function it_ignores_created_by_id_filter_if_column_does_not_exist()
    {
        $user = User::factory()->create(['role' => 'is_member']);
        Schema::shouldReceive('hasColumn')
            ->with('incomes', 'created_by_id')
            ->andReturn(false);

        Income::factory()->create(['user_id' => $user->id]); // Record visible to user
        Income::factory()->create(['user_id' => 2]); // Record not visible to user

        $this->actingAs($user);

        $incomes = Income::all();
        $this->assertCount(1, $incomes);
        $this->assertEquals($user->id, $incomes->first()->user_id);
    }

    /** @test */
    public function it_applies_instructor_id_filter_if_column_exists()
    {
        $user = User::factory()->create(['role' => 'is_member']);
        Schema::shouldReceive('hasColumn')
            ->with('incomes', 'instructor_id')
            ->andReturn(true);

        Income::factory()->create(['user_id' => 2, 'instructor_id' => $user->id]); // Record visible to user
        Income::factory()->create(['user_id' => 2, 'instructor_id' => 2]); // Record not visible to user

        $this->actingAs($user);

        $incomes = Income::all();
        $this->assertCount(1, $incomes);
        $this->assertEquals($user->id, $incomes->first()->instructor_id);
    }

    /** @test */
    public function it_ignores_instructor_id_filter_if_column_does_not_exist()
    {
        $user = User::factory()->create(['role' => 'is_member']);
        Schema::shouldReceive('hasColumn')
            ->with('incomes', 'instructor_id')
            ->andReturn(false);

        Income::factory()->create(['user_id' => $user->id]); // Record visible to user
        Income::factory()->create(['user_id' => 2]); // Record not visible to user

        $this->actingAs($user);

        $incomes = Income::all();
        $this->assertCount(1, $incomes);
        $this->assertEquals($user->id, $incomes->first()->user_id);
    }
}
