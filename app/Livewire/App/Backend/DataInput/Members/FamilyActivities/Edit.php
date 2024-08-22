<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyActivities;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyActivity;

class Edit extends Component
{
    public array $dasawismas = [];

    public ?FamilyActivity $familyActivity = NULL;

    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL;
    public array $up2k_activities = [], $current_up2k_activities = [];
    public array $env_health_activities = [], $current_env_health_activities = [];

    public function mount(?FamilyActivity $familyActivity = NULL)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get()->toArray();

        if (preg_match_all('~\(([^()]*)\)~', $familyActivity->up2k_activity, $matches)) {
            $this->current_up2k_activities = $matches[1]; // Get Group 1 values
        } else {
            $this->current_up2k_activities = explode(',', $familyActivity->up2k_activity);
        }

        if (preg_match_all('~\(([^()]*)\)~', $familyActivity->env_health_activity, $matches)) {
            $this->current_env_health_activities = $matches[1]; // Get Group 1 values
        } else {
            $this->current_env_health_activities = explode(',', $familyActivity->env_health_activity);
        }

        $this->fill([
            'dasawisma_id' => $familyActivity->dasawisma_id,
            'kk_number' => $familyActivity->kk_number,
            'family_head' => $familyActivity->family_head,
        ]);

        foreach ($this->current_up2k_activities as $itemUp2kActivity) {
            array_push($this->up2k_activities, [
                'name' => $itemUp2kActivity,
            ]);
        }

        foreach ($this->current_env_health_activities as $itemEnvHealthActivity) {
            array_push($this->env_health_activities, [
                'name' => $itemEnvHealthActivity,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-activities.edit');
    }

    public function addUp2kActivity()
    {
        $this->up2k_activities[] = [
            'name'  => '',
        ];
    }

    public function removeUp2kActivity($index)
    {
        unset($this->up2k_activities[$index]);
        $this->up2k_activities = array_values($this->up2k_activities);
    }

    public function addEnvHealthActivity()
    {
        $this->env_health_activities[] = [
            'name'  => '',
        ];
    }

    public function removeEnvHealthActivity($index)
    {
        unset($this->env_health_activities[$index]);
        $this->env_health_activities = array_values($this->env_health_activities);
    }

    public function saveChange()
    {
        $this->validate(
            [
                'up2k_activities'               => ['nullable', 'array'],
                'up2k_activities.*.name'        => ['nullable', 'string', 'min:5'],
                'env_health_activities'         => ['nullable', 'array'],
                'env_health_activities.*.name'  => ['nullable', 'string', 'min:5'],
            ],
            [
                'string' => ':attribute :position harus berupa string.',
                'min'    => ':attribute :position harus setidaknya terdiri dari :min karakter.',
            ],
            [
                'up2k_activities.*.name'        => 'Kegiatan UP2K',
                'env_health_activities.*.name'    => 'Kegiatan Usaha Kesehatan Lingkungan',
            ]
        );

        try {
            $this->familyActivity->update([
                'up2k_activity'         => $this->multiImplode($this->up2k_activities, ','),
                'env_health_activity'   => $this->multiImplode($this->env_health_activities, ','),
            ]);

            toastr_success('Data berhasil diperbaharui.');
        } catch (\Throwable $th) {
            toastr_error($th->getMessage());
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }

    private function multiImplode(array $array, string $glue)
    {
        $prefix = '(';
        $suffix = ')';
        $gluedString = '';

        foreach ($array as $item) {
            if (is_array($item)) {
                $gluedString .= $prefix . $this->multiImplode($item, $glue) . $suffix . $glue;
            } else {
                $gluedString .= $item . $glue;
            }
        }

        $gluedString = substr($gluedString, 0, 0 - strlen($glue));

        return $gluedString;
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
