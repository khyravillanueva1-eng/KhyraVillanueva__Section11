@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <section class="page-heading heading-with-note">
        <div>
            <h1>My Tasks</h1>
        </div>
    </section>

    <section class="stats" aria-label="Task summary">
        <div class="stat stat-total">
            <span class="stat-icon icon-list" aria-hidden="true"></span>
            <span><span class="stat-label">Total Tasks</span><strong>{{ $tasks->count() }}</strong></span>
        </div>
        <div class="stat stat-pending">
            <span class="stat-icon icon-clock" aria-hidden="true"></span>
            <span><span class="stat-label">Pending</span><strong>{{ $pendingCount }}</strong></span>
        </div>
        <div class="stat stat-completed">
            <span class="stat-icon icon-check" aria-hidden="true">&#10003;</span>
            <span><span class="stat-label">Completed</span><strong>{{ $completedCount }}</strong></span>
        </div>
    </section>

    <section class="form-panel add-panel" aria-labelledby="add-task-heading">
        <h2 id="add-task-heading">Add a Task</h2>
        <div class="task-form-grid">
            <form method="POST" action="{{ route('tasks.store', absolute: false) }}">
                @csrf
                <div class="field field-name">
                    <label for="task_name">Task name</label>
                    <input id="task_name" name="task_name" type="text" value="{{ old('task_name') }}" placeholder="Enter task name..." maxlength="255" required>
                    @error('task_name') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field field-description">
                    <label for="description">Description (optional)</label>
                    <textarea id="description" name="description" placeholder="Enter description..." maxlength="2000">{{ old('description') }}</textarea>
                    @error('description') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field field-due-date">
                    <label for="due_date">Due date (optional)</label>
                    <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}">
                    @error('due_date') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <button class="button button-primary add-task-button" type="submit"><span aria-hidden="true">+</span> Add Task</button>
            </form>
        </div>
    </section>

    <section class="task-list-panel" aria-labelledby="task-list-heading">
        <div class="section-heading">
            <h2 id="task-list-heading">All Tasks</h2>
            <span class="task-meta">{{ $tasks->count() }} {{ \Illuminate\Support\Str::plural('task', $tasks->count()) }}</span>
        </div>

        @if ($tasks->isEmpty())
            <p class="empty-state">No tasks yet. Add your first one here.</p>
        @else
            <div class="task-list">
                @foreach ($tasks as $task)
                    <article class="task-row">
                        <div>
                            <h3 class="task-title">{{ $task->task_name }}</h3>
                            @if ($task->description)
                                <p class="task-description">{{ $task->description }}</p>
                            @endif
                            <div class="task-meta">
                                <span class="status {{ $task->status === 'completed' ? 'status-completed' : '' }}">{{ $task->status }}</span>
                                @if ($task->due_date)
                                    <span>Due {{ $task->due_date->format('M j, Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="task-actions">
                            <form method="POST" action="{{ route('tasks.status', $task, absolute: false) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $task->status === 'completed' ? 'pending' : 'completed' }}">
                                <button class="text-button" type="submit">{{ $task->status === 'completed' ? 'Reopen' : 'Mark done' }}</button>
                            </form>
                            <a class="text-button" href="{{ route('tasks.edit', $task, absolute: false) }}">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task, absolute: false) }}" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-button text-button-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection