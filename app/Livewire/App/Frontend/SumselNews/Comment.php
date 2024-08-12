<?php

namespace App\Livewire\App\Frontend\SumselNews;

use Livewire\Component;
use App\Models\SumselNews;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\URL;
use App\Models\UserCommentSumselNews;
use App\Models\UserLikeCommentSumselNews;

class Comment extends Component
{
    public int $perLoad = 5;

    public ?SumselNews $sumselNews;
    public ?UserCommentSumselNews $userComment;

    public string $currentUrl = '';

    public ?string $bodyComment = '', $bodyCommentEditOrReply = '';

    public function mount()
    {
        $this->currentUrl = URL::current();
    }

    #[Computed()]
    public function comments()
    {
        return $this->sumselNews?->commentedByUsers()
            ->with(['user', 'childrens'])
            ->whereNull('comment_id')
            ->latest()
            ->take($this->perLoad)
            ->get();
    }

    public function render()
    {
        return view('livewire.app.frontend.sumsel-news.comment');
    }

    public function goToLogin()
    {
        session()->flash('message', [
            'text' => 'Anda harus masuk terlebih dahulu!',
            'type' => 'danger'
        ]);

        return $this->redirectRoute('auth.login', ['return-url' => $this->currentUrl], navigate: true);
    }

    public function toggleLike(int $commentId)
    {
        $data = ['user_id' => auth()->id(), 'comment_id' => $commentId];

        $like = UserLikeCommentSumselNews::query()->where($data);

        $like->exists() ? $like->delete() : UserLikeCommentSumselNews::create($data);
    }

    // COMMENT
    public function saveComment()
    {
        $validatedData = $this->validate(
            ['bodyComment' => 'required|string|min:3'],
            [
                'bodyComment.required' => ':attribute wajib diisi.',
                'bodyComment.string' => ':attribute harus berupa string.',
                'bodyComment.min' => ':attribute minimal harus berisi :min karakter.',
            ],
            ['bodyComment' => 'Komentar'],
        );

        try {
            $comment = $this->sumselNews->commentedByUsers()->create([
                'body' => $validatedData['bodyComment'],
                'user_id' => auth()->id()
            ]);

            if ($comment->wasRecentlyCreated) {
                session()->flash('message', ['text' => 'Berhasil berkomentar!', 'type' => 'success']);
                $this->dispatch('success-comment');
            }
        } catch (\Exception) {
            session()->flash('message', ['text' => 'Terjadi suatu kesalahan!!', 'type' => 'danger']);
        }

        $this->reset('bodyComment');
        $this->dispatch('remove-alert');
    }

    public function editComment(int $commentId)
    {
        $this->userComment = UserCommentSumselNews::findOrFail($commentId);
        $this->bodyCommentEditOrReply = $this->userComment->body;

        $this->resetValidation();
        // $this->dispatch('success-comment', commentId: $commentId);
    }

    // COMMENT OR REPLY
    public function saveChangeCommentOrReply()
    {
        $validatedData = $this->validate(
            ['bodyCommentEditOrReply' => 'required|string|min:3'],
            [
                'bodyCommentEditOrReply.required' => ':attribute wajib diisi.',
                'bodyCommentEditOrReply.string' => ':attribute harus berupa string.',
                'bodyCommentEditOrReply.min' => ':attribute minimal harus berisi :min karakter.',
            ],
            ['bodyCommentEditOrReply' => 'Komentar'],
        );

        try {
            $successUpdate = $this->userComment->update([
                'body' => $validatedData['bodyCommentEditOrReply'],
            ]);

            if ($successUpdate) {
                session()->flash('message', ['text' => 'Komentar berhasil diperbaharui!', 'type' => 'success']);
                $this->dispatch('success-comment', commentId: $this->userComment->id);
            }
        } catch (\Exception) {
            session()->flash('message', ['text' => 'Terjadi suatu kesalahan!!', 'type' => 'danger']);
        }

        $this->reset('bodyCommentEditOrReply', 'userComment');
        $this->dispatch('remove-alert');
    }

    // REPLY
    public function saveReply()
    {
        $validatedData = $this->validate(
            ['bodyCommentEditOrReply' => 'required|string|min:3'],
            [
                'bodyCommentEditOrReply.required' => ':attribute wajib diisi.',
                'bodyCommentEditOrReply.string' => ':attribute harus berupa string.',
                'bodyCommentEditOrReply.min' => ':attribute minimal harus berisi :min karakter.',
            ],
            ['bodyCommentEditOrReply' => 'Balasan'],
        );

        try {
            $reply = $this->sumselNews->commentedByUsers()->create([
                'body' => $validatedData['bodyCommentEditOrReply'],
                'comment_id' => $this->userComment->id,
                'user_id' => auth()->id()
            ]);

            if ($reply->wasRecentlyCreated) {
                session()->flash('message', ['text' => 'Berhasil dibalas!', 'type' => 'success']);
                $this->dispatch('success-comment', commentId: $this->userComment->id);
            }
        } catch (\Exception) {
            session()->flash('message', ['text' => 'Terjadi suatu kesalahan!!', 'type' => 'danger']);
        }

        $this->reset('bodyCommentEditOrReply', 'userComment');
        $this->dispatch('remove-alert');
    }

    public function replyComment(int $commentId)
    {
        $this->userComment = UserCommentSumselNews::findOrFail($commentId);
        $this->bodyCommentEditOrReply = NULL;

        $this->resetValidation();
        // $this->dispatch('success-comment', commentId: $commentId);
    }

    // Delete comment or reply
    #[On('delete')]
    public function delete(int $id)
    {
        try {
            $successDelete = UserCommentSumselNews::destroy($id);

            if ($successDelete) {
                $comment = UserCommentSumselNews::query()
                    ->whereNull('comment_id')
                    ->latest('id')
                    ->first();

                session()->flash('message', ['text' => 'Komentar berhasil dihapus!', 'type' => 'success']);
                $this->dispatch('success-comment', commentId: $comment->id);
            }
        } catch (\Exception) {
            session()->flash('message', ['text' => 'Terjadi suatu kesalahan!!', 'type' => 'danger']);
        }

        $this->dispatch('remove-alert');
    }

    public function clear()
    {
        $this->reset('bodyComment', 'bodyCommentEditOrReply', 'userComment');
        $this->resetValidation();
    }
}
