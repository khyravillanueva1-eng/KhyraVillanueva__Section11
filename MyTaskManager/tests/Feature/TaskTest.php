<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_lists_tasks_and_counts_their_statuses(): void
    {
        Task::factory()->create(['task_name' => 'Read chapter', 'status' => 'pending']);
        Task::factory()->create(['task_name' => 'Submit worksheet', 'status' => 'completed']);

        $this->get('/')
            ->assertOk()
            ->assertSee('href="/build/assets/app-', false)
            ->assertDontSee('href="http://localhost:8000/build/assets/', false)
            ->assertSee('action="/tasks"', false)
            ->assertDontSee('action="http://localhost:8000/tasks"', false)
            ->assertSee('Read chapter')
            ->assertSee('Submit worksheet')
            ->assertSee('Pending')
            ->assertSee('Completed')
            ->assertSee('Add a Task')
            ->assertDontSee('Logout');
    }

    public function test_valid_task_is_created_as_pending(): void
    {
        $response = $this->post(route('tasks.store'), [
            'task_name' => 'Finish science project',
            'description' => 'Prepare the final poster.',
            'due_date' => '2026-10-02',
        ]);

        $response->assertStatus(302)
            ->assertHeader('Location', '/');
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Finish science project',
            'description' => 'Prepare the final poster.',
            'status' => 'pending',
            'due_date' => '2026-10-02 00:00:00',
        ]);
    }

    public function test_task_name_is_required_to_create_a_task(): void
    {
        $response = $this->from(route('tasks.index'))->post(route('tasks.store'), [
            'description' => 'A description without a task name.',
        ]);

        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHasErrors('task_name');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_details_can_be_updated(): void
    {
        $task = Task::factory()->create(['task_name' => 'Old title']);

        $response = $this->put(route('tasks.update', $task), [
            'task_name' => 'New title',
            'description' => 'Updated details.',
            'due_date' => '2026-10-10',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'New title',
            'description' => 'Updated details.',
            'due_date' => '2026-10-10 00:00:00',
        ]);
    }

    public function test_task_status_can_be_changed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $response = $this->patch(route('tasks.status', $task), ['status' => 'completed']);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_task_status_rejects_values_other_than_pending_or_completed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $response = $this->patch(route('tasks.status', $task), ['status' => 'in_progress']);

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'pending']);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_task_text_is_escaped_on_the_homepage(): void
    {
        Task::factory()->create(['task_name' => '<script>alert(1)</script>']);

        $this->get('/')
            ->assertOk()
            ->assertSee('<script>alert(1)</script>');
    }
}
