<div id="content" class="mx-auto" style="max-width:500px;">
    @include('livewire.create-todo')
    @include('livewire.todo-search')
    <div id="todos-list">
        @foreach ($todos as $todo)
        @include('livewire.todo-list')
        @endforeach

        <div class="my-2">
            {{$todos->links()}}
            <!-- Pagination goes here -->
        </div>
    </div>
</div>