<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Title;

new
#[Title('Products')]
class extends Component{

}
?>

<div>
    <h1 class="text-2xl font-semibold">Welcome, {{ auth()->user()->name }}</h1>
</div>
