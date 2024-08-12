<?php

namespace App\Traits;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::saving(function (self $model) {
            $sluggable = $model->sluggable ?? 'title';
            $slugColumn = $model->slugColumn ?? 'slug';
            $newSlug = $model->incrementField($sluggable, $slugColumn, $model->{$sluggable});

            $model->{$slugColumn} = $model->slug == $newSlug ? $model->slug : $newSlug;
        });
    }

    private function incrementField($sluggable, $slugColumn, $value)
    {
        $slug = str($value)->slug();

        $currentDataModel = $this->query()->where($slugColumn, '=', $this->slug)->latest()->first([$sluggable, $slugColumn]);

        if (isset($this->{$sluggable}) && strcasecmp($currentDataModel?->{$sluggable}, $this->{$sluggable}) == 0) { // is_same
            return $currentDataModel->slug;
        }

        if ($this->query()->where($slugColumn, '=', str($value)->slug())->exists()) {

            $max = $this->query()->where($slugColumn, 'LIKE', str($value)->slug() . '-%')->latest()->value($slugColumn);
            if (!is_null($max)) {
                if (is_numeric($max[-1])) {
                    return preg_replace_callback('/(\d+)$/', function ($matches) use ($value, $max) {
                        switch (true) {
                            case $matches[1] == $max[-1]:
                                return $max[-1] + 1;
                                break;
                            case $value[-1] == $matches[1]: // for edit
                                return $value;
                                break;
                            case is_numeric($max[-1]):
                                return $matches[1] + 1;
                                break;
                            default:
                                return $matches[1] . '-' . $matches[1] + 1;
                                break;
                        }
                    }, $max);
                }

                if ($slug[-1] != '-') {
                    // $lastWord = substr($max, strrpos($max, '-') + 1);
                    $lastSlugWithNumber = $this->query()
                        ->where('slug', '!=', $currentDataModel->slug)
                        ->latest()
                        ->value($slugColumn);

                    return $slug . '-' . $lastSlugWithNumber[-1] + 1;
                }
            } else {
                return "{$slug}-2";
            }
        }

        return $slug;
    }
}
