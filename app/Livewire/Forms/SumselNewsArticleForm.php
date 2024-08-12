<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\SumselNews;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class SumselNewsArticleForm extends Form
{
    public ?SumselNews $sumselNews = NULL;

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
                    is_null($this->sumselNews),
                    [
                        'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                        ValidationRule::unique('sumsel_news', 'image')
                    ]
                ),
                ValidationRule::when(
                    !is_null($this->sumselNews) && is_object($this->image),
                    [
                        'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                        ValidationRule::unique('sumsel_news', 'image')->ignore($this->sumselNews?->id, 'id')
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

    public function setData(SumselNews $sumselNews)
    {
        $this->sumselNews = $sumselNews;

        $this->title = $sumselNews->title;
        $this->image = $sumselNews->image;
        $this->body = $sumselNews->body;
        $this->is_published = $sumselNews->is_published;
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        $pathImg = 'image/sumsel-news';

        try {
            if (is_null($this->sumselNews)) {
                if (is_object($validatedData['image'])) {
                    $imgName = $this->image->store($pathImg, 'public');
                    $validatedData['image'] = str_replace("$pathImg/", '', $imgName);
                }

                SumselNews::query()->create($validatedData + [
                    'author_id' => auth()->id(),
                ]);

                $this->message = 'Artikel Berita Sumsel berhasil ditambahkan!';
            }

            if (!is_null($this->sumselNews)) {
                if (is_object($validatedData['image'])) {
                    if (Storage::disk('public')->exists($pathImg . '/' . $this->sumselNews->getRawOriginal('image'))) {
                        Storage::disk('public')->delete($pathImg . '/' . $this->sumselNews->getRawOriginal('image'));
                    };

                    $newImg = $this->image->store($pathImg, 'public');
                    $validatedData['image'] = str_replace("$pathImg/", '', $newImg);
                } else {
                    $validatedData['image'] = $this->sumselNews->getRawOriginal('image');
                }

                $this->sumselNews->update($validatedData + [
                    'author_id' => auth()->id(),
                ]);

                $this->message = 'Data Artikel Berita Sumsel berhasil diperbaharui!';
            }

            $this->response = ['type' => 'success', 'message' => $this->message];
        } catch (\Exception) {
            $this->response = ['type' => 'error', 'message' => 'Terjadi suatu kesalahan!!'];
        } finally {
            $this->reset();
        }

        return $this->response;
    }

    public function resetForm(): void
    {
        $this->reset('sumselNews', 'title', 'image', 'body', 'is_published');
        $this->image = null;
    }

    public function resetData(): void
    {
        $this->title = $this->sumselNews->title;
        $this->image = $this->sumselNews->image;
        $this->body = $this->sumselNews->body;
        $this->is_published = $this->sumselNews->is_published;
    }
}
