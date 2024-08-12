<?php

namespace App\Livewire\App\Frontend\DasawismaActivities;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\DasawismaActivity;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\URL;
use App\Models\UserCommentDasawismaActivity;
use App\Models\UserLikeCommentDasawismaActivity;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class Comment extends Component
{
    public int $perLoad = 5;

    public ?DasawismaActivity $dasawismaActivity;
    public ?UserCommentDasawismaActivity $userComment;

    public string $currentUrl = '';

    public ?string $bodyComment = '', $bodyCommentEditOrReply = '';

    public function mount(): void
    {
        $this->currentUrl = URL::current();
    }

    #[Computed()]
    public function comments(): Collection|SupportCollection
    {
        return $this->dasawismaActivity->commentedByUsers()
            ->with(['user', 'childrens'])
            ->whereNull('comment_id')
            ->latest()
            ->take($this->perLoad)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.app.frontend.dasawisma-activities.comment');
    }

    public function goToLogin(): void
    {
        flash_message('Anda harus masuk terlebih dahulu.', 'fail');

        $this->redirectRoute('auth.login', ['return-url' => $this->currentUrl], navigate: true);
    }

    public function toggleLike(int $commentId): void
    {
        $data = ['user_id' => auth()->id(), 'comment_id' => $commentId];

        $like = UserLikeCommentDasawismaActivity::query()->where($data);

        $like->exists() ? $like->delete() : UserLikeCommentDasawismaActivity::query()->create($data);
    }

    // COMMENT
    public function saveComment(): void
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
            $comment = $this->dasawismaActivity->commentedByUsers()->create([
                'body' => $validatedData['bodyComment'],
                'user_id' => auth()->id()
            ]);

            if ($comment->wasRecentlyCreated) {
                flash_message('Berhasil berkomentar.', 'success');
                $this->dispatch('success-comment');
            }
        } catch (\Exception $ex) {
            flash_message('Terjadi suatu kesalahan.', 'fail');
        }

        $this->reset('bodyComment');
        $this->dispatch('remove-alert');
    }

    public function editComment(int $commentId): void
    {
        $this->userComment = UserCommentDasawismaActivity::findOrFail($commentId);
        $this->bodyCommentEditOrReply = $this->userComment->body;

        $this->resetValidation();
        // $this->dispatch('success-comment', commentId: $commentId);
    }

    // COMMENT OR REPLY
    public function saveChangeCommentOrReply(): void
    {
        $validatedData = $this->validate(
            ['bodyCommentEditOrReply' => 'required|string|min:3'],
            [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa string.',
                'min' => 'Minimal panjang :attribute harus :min karakter.',
            ],
            ['bodyCommentEditOrReply' => 'Komentar'],
        );

        try {
            $successUpdate = $this->userComment->update([
                'body' => $validatedData['bodyCommentEditOrReply'],
            ]);

            if ($successUpdate) {
                flash_message('Komentar berhasil diperbaharui.', 'success');
                $this->dispatch('success-comment', commentId: $this->userComment->id);
            }
        } catch (\Throwable) {
            flash_message('Terjadi suatu kesalahan.', 'fail');
        }

        $this->reset('bodyCommentEditOrReply', 'userComment');
        $this->dispatch('remove-alert');
    }

    // REPLY
    public function saveReply(): void
    {
        $validatedData = $this->validate(
            ['bodyCommentEditOrReply' => 'required|string|min:3'],
            [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa string.',
                'min' => ':attribute minimal harus berisi :min karakter.',
            ],
            ['bodyCommentEditOrReply' => 'Balasan'],
        );

        try {
            $reply = $this->dasawismaActivity->commentedByUsers()->create([
                'body' => $validatedData['bodyCommentEditOrReply'],
                'comment_id' => $this->userComment->id,
                'user_id' => auth()->id()
            ]);

            if ($reply->wasRecentlyCreated) {
                flash_message('Berhasil membalas.', 'success');
                $this->dispatch('success-comment', commentId: $this->userComment->id);
            }
        } catch (\Throwable) {
            flash_message('Terjadi suatu kesalahan.', 'fail');
        }

        $this->reset('bodyCommentEditOrReply', 'userComment');
        $this->dispatch('remove-alert');
    }

    public function replyComment(int $commentId): void
    {
        $this->userComment = UserCommentDasawismaActivity::findOrFail($commentId);
        $this->bodyCommentEditOrReply = NULL;

        $this->resetValidation();
        // $this->dispatch('success-comment', commentId: $commentId);
    }

    // Delete comment or reply
    #[On('delete')]
    public function delete(int $id): void
    {
        try {
            $successDelete = UserCommentDasawismaActivity::query()->destroy($id);

            if ($successDelete) {
                $comment = UserCommentDasawismaActivity::query()
                    ->whereNull('comment_id')
                    ->latest('id')
                    ->first();

                flash_message('Komentar berhasil dihapus.', 'success');
                $this->dispatch('success-comment', commentId: $comment->id);
            }
        } catch (\Throwable) {
            flash_message('Terjadi suatu kesalahan.', 'fail');
        } finally {
            $this->dispatch('remove-alert');
        }
    }

    public function clear(): void
    {
        $this->reset('bodyComment', 'bodyCommentEditOrReply', 'userComment');
        $this->resetValidation();
    }
}
