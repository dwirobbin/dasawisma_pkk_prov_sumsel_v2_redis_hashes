<?php

namespace App\Livewire\App\Partials;

use Livewire\Component;
use Livewire\Attributes\On;

class TopRight extends Component
{
    #[On('refresh-top-right')]
    public function render()
    {
        return view('livewire.app.partials.top-right');
    }

    public function logoutHandler()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirectRoute('home', navigate: true);
    }
}
