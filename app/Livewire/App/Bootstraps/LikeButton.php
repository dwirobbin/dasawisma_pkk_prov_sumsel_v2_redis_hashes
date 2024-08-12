<?php

namespace App\Livewire\App\Bootstraps;

use App\Models\DasawismaActivity;
use App\Models\SumselNews;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class LikeButton extends Component
{
    #[Reactive]
    public Model $model;

    public string $currentUrl = '';

    public function mount(): void
    {
        $this->currentUrl = URL::current();
    }

    public function render(): View
    {
        return view('livewire.app.bootstraps.like-button');
    }

    public function toggleLike(): void
    {
        if (auth()->guest()) {
            flash_message('Anda harus masuk terlebih dahulu.', 'fail');

            $this->redirectRoute('auth.login', ['return-url' => $this->currentUrl], navigate: true);

            return;
        }

        $user = auth()->user();

        if ($this->model instanceof DasawismaActivity) {
            if ($user->hasLikedArticles($this->model)) {
                $user->likeDasawismaActivities()->detach($this->model);

                return;
            }

            $user->likeDasawismaActivities()->attach($this->model);
        }

        if ($this->model instanceof SumselNews) {
            if ($user->hasLikedArticles($this->model)) {
                $user->likeSumselNews()->detach($this->model);

                return;
            }

            $user->likeSumselNews()->attach($this->model);
        }
    }
}
