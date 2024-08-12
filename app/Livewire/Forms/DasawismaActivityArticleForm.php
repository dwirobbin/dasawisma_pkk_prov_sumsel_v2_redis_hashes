<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\DasawismaActivity;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class DasawismaActivityArticleForm extends Form
{
    public ?DasawismaActivity $dasawismaActivity = NULL;

    public ?string $title = NULL;
    public object|string|null $image = NULL;
    public ?string $body = NULL;
    public ?bool $is_published = false;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:10'],
            'image' => [
                'nullable',
                ValidationRule::when(
                    is_null($this->dasawismaActivity),
                    [
                        'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                        ValidationRule::unique('dasawisma_activities', 'image')
                    ]
                ),
                ValidationRule::when(
                    !is_null($this->dasawismaActivity) && is_object($this->image),
                    [
                        'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                        ValidationRule::unique('dasawisma_activities', 'image')->ignore($this->dasawismaActivity?->id, 'id')
                    ]
                ),
            ],
            'body' => ['required', 'string', 'min:10'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            'image.max' => 'Maksimal ukuran :attribute adalah 2 MB.',
            'image.image' => ':attribute harus berupa gambar.',
            'image.mimes' => ':attribute harus berformat :values.',
            'is_published.boolean' => ':attribute harus bernilai true atau false.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'title' => 'Judul',
            'image' => 'Sampul',
            'body' => 'Deskripsi',
            'is_published' => 'Dipublish',
        ];
    }

    public function setData(DasawismaActivity $dasawismaActivity): void
    {
        $this->dasawismaActivity = $dasawismaActivity;

        $this->title = $dasawismaActivity->title;
        $this->image = $dasawismaActivity->image;
        $this->body = $dasawismaActivity->body;
        $this->is_published = $dasawismaActivity->is_published;
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        $pathImg = 'image/dasawisma-activities';

        try {
            if (is_null($this->dasawismaActivity)) {
                if (is_object($validatedData['image'])) {
                    $imgName = $this->image->store($pathImg, 'public');
                    $validatedData['image'] = str_replace("$pathImg/", '', $imgName);
                }

                DasawismaActivity::query()->create($validatedData + [
                    'author_id' => auth()->id(),
                ]);

                $this->message = 'Artikel Kegiatan Dasawisma berhasil ditambahkan!';
            }

            if (!is_null($this->dasawismaActivity)) {
                if (is_object($validatedData['image'])) {
                    if (Storage::disk('public')->exists($pathImg . '/' . $this->dasawismaActivity->getRawOriginal('image'))) {
                        Storage::disk('public')->delete($pathImg . '/' . $this->dasawismaActivity->getRawOriginal('image'));
                    };

                    $newImg = $this->image->store($pathImg, 'public');
                    $validatedData['image'] = str_replace("$pathImg/", '', $newImg);
                } else {
                    $validatedData['image'] = $this->dasawismaActivity->getRawOriginal('image');
                }

                $this->dasawismaActivity->update($validatedData + [
                    'author_id' => auth()->id(),
                ]);

                $this->message = 'Data Artikel Kegiatan Dasawisma berhasil diperbaharui!';
            }

            $this->response = ['type' => 'success', 'message' => $this->message];
        } catch (\Throwable) {
            $this->response = ['type' => 'error', 'message' => 'Terjadi suatu kesalahan.'];
        } finally {
            $this->reset();
        }

        return $this->response;
    }

    public function resetForm(): void
    {
        $this->reset(['dasawismaActivity', 'title', 'image', 'body', 'is_published']);
        $this->image = null;
    }

    public function resetData(): void
    {
        $this->title = $this->dasawismaActivity->title;
        $this->image = $this->dasawismaActivity->image;
        $this->body = $this->dasawismaActivity->body;
        $this->is_published = $this->dasawismaActivity->is_published;
    }
}
