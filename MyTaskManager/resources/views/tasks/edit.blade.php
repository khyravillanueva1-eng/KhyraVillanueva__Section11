@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <section class="page-heading">
        <p class="eyebrow">Task details</p>
        <h1>Edit task</h1>
        <p class="subtitle">Update the task name, details, or due date.</p>
    </section>

    <section class="form-panel edit-panel">
        <form method="POST" action="{{ route('tasks.update', $task, absolute: false) }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="task_name">Task name</label>
                <input id="task_name" name="task_name" type="text" value="{{ old('task_name', $task->task_name) }}" maxlength="255" required>
                @error('task_name') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="description">Description <span class="task-meta">(optional)</span></label>
                <textarea id="description" name="description" maxlength="2000">{{ old('description', $task->description) }}</textarea>
                @error('description') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="due_date">Due date <span class="task-meta">(optional)</span></label>
                <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                @error('due_date') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-actions">
                <button class="button button-primary" type="submit">Save changes</button>
                <a class="text-button" href="{{ route('tasks.index', absolute: false) }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection