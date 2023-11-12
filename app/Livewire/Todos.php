<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Todo;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;

class Todos extends Component
{
    use WithPagination;

    #[Rule('required|max:50')]
    public $title;

    public $search;

    #[Rule('required|max:50')]
    public $editingTodoTitle;

    public $editingTodoId;

    public function createTodo()
    {
        $this->validateOnly('title');
        Todo::create([
            'title' => $this->title
        ]);
        $this->reset(['title']);
        Session::flash('success', 'Todo saved successfully');
    }

    public function deleteTodo($todoId)
    {
        Todo::find($todoId)->delete();
    }

    public function toggleTodo($todoId)
    {
        $todo = Todo::find($todoId);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function editTodo($todoId)
    {
        $this->editingTodoId = $todoId;
        $this->editingTodoTitle = Todo::find($todoId)->title;
    }

    public function updateTodo($todoId)
    {
        $this->validateOnly('editingTodoTitle');
        $todo = Todo::find($todoId);
        $todo->title = $this->editingTodoTitle;
        $todo->save();
        $this->cancelEditing();
    }

    public function cancelEditing()
    {
        $this->reset('editingTodoId', 'editingTodoTitle');
    }
    public function render()
    {
        $todos = Todo::where('title', 'like', "%{$this->search}%")->paginate(3);
        return view('livewire.todos', compact('todos'));
    }
}
