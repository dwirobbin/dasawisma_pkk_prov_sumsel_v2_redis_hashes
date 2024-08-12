<?php

namespace App\Livewire\App\Backend;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Models\FamilyActivity;
use App\Models\FamilyBuilding;
use App\Models\FamilySizeMember;
use Illuminate\Database\Eloquent\Builder;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Home extends Component
{
    public $dasawismaSelected = '';

    public function placeholder()
    {
        return view('placeholder');
    }

    public function render()
    {
        // dd(auth()->user()->admin->regency_id);

        $dataDropdown['dasawismas'] = Dasawisma::query()
            ->select(['id', 'name', 'regency_id'])
            // ->when(
            //     auth()->user()->role_id == 2 && auth()->user()->admin->village_id != NULL,
            //     function (Builder $query) {
            //         $query->where('village_id', '=', auth()->user()->admin->village_id);
            //     }
            // )
            // ->when(
            //     auth()->user()->role_id == 2 && auth()->user()->admin->district_id != NULL,
            //     function (Builder $query) {
            //         $query->where('district_id', '=', auth()->user()->admin->district_id);
            //     }
            // )
            // ->when(
            //     auth()->user()->role_id == 2 && auth()->user()->admin->regency_id != NULL,
            //     function (Builder $query) {
            //         $query->where('regency_id', '=', auth()->user()->admin->regency_id);
            //     }
            // )
            // ->when(
            //     auth()->user()->role_id == 2 && auth()->user()->admin->province_id != NULL,
            //     function (Builder $query) {
            //         $query->where('province_id', '=', auth()->user()->admin->province_id);
            //     }
            // )
            ->orderBy('dasawismas.id')
            ->get();

        // dd($dataDropdown['dasawismas']);

        $familyBuildings = FamilyBuilding::query()
            ->selectRaw("
                COUNT(CASE WHEN family_buildings.staple_food = 'Beras' THEN 1 END) AS rice_foods_count,
                COUNT(CASE WHEN family_buildings.staple_food = 'Non Beras' THEN 1 END) AS etc_rice_foods_count,
                COUNT(family_buildings.have_toilet) AS have_toilets_count,
                COUNT(CASE WHEN family_buildings.water_src LIKE '%PDAM%' THEN 1 END) AS pdam_waters_count,
                COUNT(CASE WHEN family_buildings.water_src LIKE '%Sumur%' THEN 1 END) AS well_waters_count,
                COUNT(CASE WHEN family_buildings.water_src LIKE '%Sungai%' THEN 1 END) AS river_waters_count,
                COUNT(CASE WHEN family_buildings.water_src LIKE '%Lainnya%' THEN 1 END) AS etc_waters_count,
                COUNT(family_buildings.have_landfill) AS have_landfills_count,
                COUNT(family_buildings.have_sewerage) AS have_sewerages_count,
                COUNT(family_buildings.pasting_p4k_sticker) AS pasting_p4k_stickers_count,
                COUNT(CASE WHEN family_buildings.house_criteria = 'Sehat' THEN 1 END) AS healthy_criterias_count,
                COUNT(CASE WHEN family_buildings.house_criteria = 'Kurang Sehat' THEN 1 END) AS no_healthy_criterias_count
            ")
            ->join('family_heads', 'family_buildings.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id')
            ->where('dasawismas.name', '=', $this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name)
            ->groupBy('dasawismas.id')
            ->orderBy('dasawismas.id', 'ASC')
            ->get();


        $familyMembers = FamilyMember::query()
            ->selectRaw("
                COUNT(family_members.family_head_id) AS family_members_count,
                COUNT(CASE WHEN family_members.gender = 'Laki-laki' THEN 1 END) AS gender_males_count,
                COUNT(CASE WHEN family_members.gender = 'Perempuan' THEN 1 END) AS gender_females_count,
                COUNT(CASE WHEN family_members.marital_status = 'Kawin' THEN 1 END) AS marries_count,
                COUNT(CASE WHEN family_members.marital_status = 'Belum Kawin' THEN 1 END) AS singles_count,
                COUNT(CASE WHEN family_members.marital_status = 'Janda' THEN 1 END) AS widows_count,
                COUNT(CASE WHEN family_members.marital_status = 'Duda' THEN 1 END) AS widowers_count,
                COUNT(CASE WHEN family_members.profession != 'Belum/Tidak Bekerja' THEN 1 END) AS workings_count,
                COUNT(CASE WHEN family_members.profession LIKE '%Tidak Bekerja%' THEN 1 END) AS not_workings_count,
                COUNT(CASE WHEN family_members.last_education = 'TK/PAUD' THEN 1 END) AS kindergartens_count,
                COUNT(CASE WHEN family_members.last_education = 'SD/MI' THEN 1 END) AS elementary_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'SLTP/SMP/MTS' THEN 1 END) AS middle_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'SLTA/SMA/MA/SMK' THEN 1 END) AS high_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'Diploma' THEN 1 END) AS associate_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S1' THEN 1 END) AS bachelor_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S2' THEN 1 END) AS master_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S3' THEN 1 END) AS post_degrees_count
            ")
            ->join('family_heads', 'family_members.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id')
            ->where('dasawismas.name', '=', $this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name)
            ->groupBy('dasawismas.id')
            ->orderBy('dasawismas.id', 'ASC')
            ->get();

        $familySizeMembers = FamilySizeMember::query()
            ->selectRaw("
                SUM(toddlers_number) AS toddlers_sum,
                SUM(pus_number) AS pus_sum,
                SUM(wus_number) AS wus_sum,
                SUM(blind_people_number) AS blind_peoples_sum,
                SUM(pregnant_women_number) AS pregnant_womens_sum,
                SUM(breastfeeding_mother_number) AS breastfeeding_mothers_sum,
                SUM(elderly_number) AS elderlies_sum
            ")
            ->join('family_heads', 'family_size_members.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id')
            ->where('dasawismas.name', '=', $this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name)
            ->groupBy('dasawismas.id')
            ->orderBy('dasawismas.id', 'ASC')
            ->get();

        $familyActivities = FamilyActivity::query()
            ->selectRaw("
                COUNT(CASE WHEN family_activities.up2k_activity IS NOT NULL THEN 1 END) AS up2k_activities_count,
                COUNT(CASE WHEN family_activities.env_health_activity IS NOT NULL THEN 1 END) AS env_health_activities_count
            ")
            ->join('family_heads', 'family_activities.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id')
            ->where('dasawismas.name', '=', $this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name)
            ->groupBy('dasawismas.id')
            ->orderBy('dasawismas.id', 'ASC')
            ->get();

        $dataRecap = [];

        foreach ($familyBuildings as $familyBuilding) {
            $dataRecap['data_recap_family_buildings'] = [
                'Beras'              => $familyBuilding->rice_foods_count,
                'Non Beras'          => $familyBuilding->etc_rice_foods_count,
                'Air PDAM'           => $familyBuilding->pdam_waters_count,
                'Air Sumur'          => $familyBuilding->well_waters_count,
                'Air Sungai'         => $familyBuilding->river_waters_count,
                'Air Lainnya'        => $familyBuilding->etc_waters_count,
                'Punya Toilet'       => $familyBuilding->have_toilets_count,
                'Punya TPS'          => $familyBuilding->have_landfills_count,
                'Punya SPAL'         => $familyBuilding->have_sewerages_count,
                'Tempel Stiker P4K'  => $familyBuilding->pasting_p4k_stickers_count,
                'Rumah Sehat'        => $familyBuilding->healthy_criterias_count,
                'Rumah Kurang Sehat' => $familyBuilding->no_healthy_criterias_count,
            ];
        }

        foreach ($familyMembers as $familyMember) {
            $dataRecap['data_recap_family_members'] = [
                'Angg. Keluarga'    => $familyMember->family_members_count,
                'Laki-laki'         => $familyMember->gender_males_count,
                'Perempuan'         => $familyMember->gender_females_count,
                'Menikah'           => $familyMember->marries_count,
                'Belum Menikah'     => $familyMember->singles_count,
                'Janda'             => $familyMember->widows_count,
                'Duda'              => $familyMember->widowers_count,
                'Sudah Bekerja'     => $familyMember->workings_count,
                'Belum Bekerja'     => $familyMember->not_workings_count,
                'TK'                => $familyMember->kindergartens_count,
                'SD'                => $familyMember->elementary_schools_count,
                'SMP'               => $familyMember->middle_schools_count,
                'SMA'               => $familyMember->high_schools_count,
                'Diploma'           => $familyMember->associate_degrees_count,
                'S1'                => $familyMember->bachelor_degrees_count,
                'S2'                => $familyMember->master_degrees_count,
                'S3'                => $familyMember->post_degrees_count,
            ];
        }

        foreach ($familySizeMembers as $familySizeMember) {
            $dataRecap['data_recap_family_numbers'] = [
                'Balita'        => (int) $familySizeMember->toddlers_sum,
                'PUS'           => (int) $familySizeMember->pus_sum,
                'WUS'           => (int) $familySizeMember->wus_sum,
                'Org Buta'      => (int) $familySizeMember->blind_peoples_sum,
                'Ibu Hamil'     => (int) $familySizeMember->pregnant_womens_sum,
                'Ibu Menyusui'  => (int) $familySizeMember->breastfeeding_mothers_sum,
                'Lansia'        => (int) $familySizeMember->elderlies_sum,
            ];
        }

        foreach ($familyActivities as $familyActivity) {
            $dataRecap['data_recap_family_activities'] = [
                'Usaha Peningkatan Pendapatan Keluarga' => $familyActivity->up2k_activities_count,
                'Kegiatan Usaha Kesehatan Lingkungan'   => $familyActivity->env_health_activities_count,
            ];
        }

        //  familyBuildingChart
        $familyBuildingChart = (new ColumnChartModel());
        $familyBuildingChart->setTitle($this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name);
        foreach ($dataRecap['data_recap_family_buildings'] as $key => $value) {
            $familyBuildingChart->addColumn($key, $value, fake()->hexColor());
        }
        $familyBuildingChart
            ->withDataLabels()
            ->setAnimated(true)
            ->withoutLegend()
            ->setLegendVisibility(false)
            ->withGrid();

        // familyMemberChart
        $familyMemberChart = (new ColumnChartModel());
        $familyMemberChart->setTitle($this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name);
        foreach ($dataRecap['data_recap_family_members'] as $key => $value) {
            $familyMemberChart->addColumn($key, $value, fake()->hexColor());
        }
        $familyMemberChart
            ->withDataLabels()
            ->setAnimated(true)
            ->withoutLegend()
            ->setLegendVisibility(false)
            ->withGrid();

        // familyNumberChart
        $familyNumberChart = (new PieChartModel());
        $familyNumberChart->setTitle($this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name);
        foreach ($dataRecap['data_recap_family_numbers'] as $key => $value) {
            $familyNumberChart->addSlice($key, $value, fake()->hexColor());
        }
        $familyNumberChart
            ->asPie()
            ->withDataLabels()
            ->setAnimated(true)
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter();

        // familyActivityChart
        $familyActivityChart = (new PieChartModel());
        $familyActivityChart->setTitle($this->dasawismaSelected ?: $dataDropdown['dasawismas'][0]->name);
        foreach ($dataRecap['data_recap_family_activities'] as $key => $value) {
            $familyActivityChart->addSlice($key, $value, fake()->hexColor());
        }
        $familyActivityChart
            ->asPie()
            ->withDataLabels()
            ->setAnimated(true)
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter();

        return view('livewire.app.backend.home', [
            'dataDropdown'  => $dataDropdown,
            'familyBuildingChart' => $familyBuildingChart,
            'familyMemberChart' => $familyMemberChart,
            'familyNumberChart' => $familyNumberChart,
            'familyActivityChart' => $familyActivityChart,
        ]);
    }
}
