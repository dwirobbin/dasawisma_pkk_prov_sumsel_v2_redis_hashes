<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateUniqueName
{
    public static function bootGenerateUniqueName(): void
    {
        static::saving(function ($model) {
            $name = $model->name;
            $model->name = $model->generateUniqueName((string) $name);
        });
    }

    public function generateUniqueName(string $name): string
    {
        // Check if the name already has a number at the end
        $originalName = $name;
        $nameNumber = null;

        if (preg_match('/-(\d+)$/', $name, $matches)) {
            $nameNumber = $matches[1];
            $name = Str::replaceLast("-$nameNumber", '', $name);
        }

        // Check if the modified name already exists in the table
        $existingNames = $this->getExistingNames($name, $this->getTable());

        if (!in_array($name, $existingNames)) {
            // Name is unique, no need to append numbers
            return $name . ($nameNumber ? "-$nameNumber" : '');
        }

        // Increment the number until a unique Name is found
        $i = $nameNumber ? ($nameNumber + 1) : 2;
        $uniqueNameFound = false;

        while (!$uniqueNameFound) {
            $newName = $name . '-' . $i;

            if (!in_array($newName, $existingNames)) {
                // Unique Name found
                return $newName;
            }

            $i++;
        }

        // Fallback: return the original Name with a random number appended
        return $originalName . '-' . mt_rand(1000, 9999);
    }

    private function getExistingNames(string $name, string $table): array
    {
        return $this->where('name', 'LIKE', $name . '%')
            ->where('id', '!=', $this->id ?? null) // Exclude the current model's ID
            ->pluck('name')
            ->toArray();
    }
}
