<?php

namespace App\Livewire\App\Backend\DataRecap;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Dasawisma;
use App\Helpers\LengthPager;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\FamilyActivity;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Livewire\Urls\Facades\Url as LivewireUrl;

class FamilyActivityIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $param = '';

    public int $perPage = 5;

    #[Url]
    public string $search = '';

    public ?string $currentUrl = NULL;

    public function mount()
    {
        $this->currentUrl = LivewireUrl::current();
    }

    public function placeholder()
    {
        return view('placeholder');
    }

    public function paginationView(): string
    {
        return 'paginations.custom-pagination-links';
    }

    public function render()
    {
        $param = match (true) {
            str_contains($this->currentUrl, '/index') => 'index',
            str_contains($this->currentUrl, '/area-code') && strlen($this->param) == 4 => $this->param,
            str_contains($this->currentUrl, '/area-code') && strlen($this->param) == 7 => $this->param,
            str_contains($this->currentUrl, '/area-code') && strlen($this->param) == 10 => $this->param,
            default => 'dasawisma'
        };

        $user = auth()->user();

        $prefix = 'data-recap';
        $areaName = 'sumatera-selatan';
        $page = $this->getPage() ?? 1;

        if ($user->role_id === 2) { // Admin
            if ($user->admin->province_id != null && $user->admin->regency_id == null) {
                // Provinsi
                $areaName = $user->admin->province->slug;
            } else if ($user->admin->regency_id != null && $user->admin->district_id == null) {
                // Kabupaten Kota
                $areaName = $user->admin->regency->slug;
            } else if ($user->admin->district_id != null && $user->admin->village_id == null) {
                // Kecamatan
                $areaName = $user->admin->district->slug;
            } else if ($user->admin->village_id != null) {
                // Kelurahan
                $areaName = $user->admin->village->slug;
            }
        }

        $filteredDataFromRedis = [];
        $filteredDataFromMysql = [];

        switch (true) {
            case $param == 'index': // regencies
                // Jika ada pencarian
                if ($this->search != '') {
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fa:regencies:page-*");

                    // Ambil semua data dari Redis
                    $data = array_reduce($keys, function ($carry, $key) {
                        $cachedData[] = Redis::hGetAll($key);

                        return is_array($cachedData) && isset($cachedData)
                            ? array_merge($carry, $cachedData)
                            : $carry;
                    }, []);

                    // Cari data pada redis
                    $filteredDataFromRedis = array_filter($data, fn($item) => stripos($item['name'], $this->search) !== false);

                    // jika data pencarian tidak ditemukan pada redis, cari di database utama
                    if (empty($filteredDataFromRedis)) {
                        $filteredDataFromMysql = $this->getData()
                            ->addSelect('regencies.id', 'regencies.name')
                            ->join('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
                            ->where('dasawismas.province_id', '=', 16)
                            ->when($this->search != '', function (Builder $query) {
                                $query->where('regencies.name', 'LIKE', '%' . trim($this->search) . '%');
                            })
                            ->groupBy('regencies.id')
                            ->orderBy('dasawismas.regency_id', 'ASC');
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data yang sesuai dengan halaman sekarang
                    $keyCacheFARegencies = $prefix . ':' . $areaName . ":fa:regencies:page-" . $page;

                    $keys = Redis::keys("$keyCacheFARegencies:*");

                    if (!empty($keys)) {
                        foreach ($keys as $value) {
                            $data[] = Redis::hGetAll($value);
                        }

                        // Extract all next_page_url values
                        $nextPageUrls = array_column($data, 'next_page_url');

                        // Check if all next_page_url values are empty
                        $allEmpty = array_reduce($nextPageUrls, fn($carry, $url) => $carry && empty($url), true);

                        $paginationData = [
                            'data' => $data,
                            'total' => count($data),
                            'per_page' => $this->perPage,
                            'current_page' => $page,
                            'hasMore' => $allEmpty ? false : true,
                        ];

                        $familyActivities = LengthPager::paginate($paginationData);
                    } else {
                        $familyActivities = $this->getData()
                            ->addSelect('regencies.id', 'regencies.name')
                            ->join('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
                            ->where('dasawismas.province_id', '=', 16)
                            ->groupBy('regencies.id')
                            ->orderBy('dasawismas.regency_id', 'ASC')
                            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                            })
                            ->simplePaginate($this->perPage);

                        if ($familyActivities->isNotEmpty()) {
                            $pageData = $familyActivities->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFARegencies) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFARegencies:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFARegencies:{$value['id']}", config('database.redis.options.ttl'));
                                }
                            });
                        }
                    }
                }
                break;
            case strlen($param) == 4: // districts
                $regencyName = Regency::where('id', '=', $param)->value('slug');

                // Jika ada pencarian
                if ($this->search != '') {
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fa:districts:by-regency:" . $regencyName . ":page-*");

                    // Ambil semua data dari Redis
                    $data = array_reduce($keys, function ($carry, $key) {
                        $cachedData[] = Redis::hGetAll($key);

                        return is_array($cachedData) && isset($cachedData)
                            ? array_merge($carry, $cachedData)
                            : $carry;
                    }, []);

                    // Cari data pada redis
                    $filteredDataFromRedis = array_filter($data, fn($item) => stripos($item['name'], $this->search) !== false);

                    // jika data pencarian tidak ditemukan pada redis, cari di database utama
                    if (empty($filteredDataFromRedis)) {
                        $filteredDataFromMysql = $this->getData()
                            ->addSelect('districts.id', 'districts.name')
                            ->join('districts', 'dasawismas.district_id', '=', 'districts.id')
                            ->where('dasawismas.regency_id', '=', $this->param)
                            ->when($this->search != '', function (Builder $query) {
                                $query->where('districts.name', 'LIKE', '%' . trim($this->search) . '%');
                            })
                            ->groupBy('districts.id')
                            ->orderBy('dasawismas.regency_id', 'ASC');
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data yang sesuai dengan halaman sekarang
                    $keyCacheFADistricts = $prefix . ':' . $areaName . ":fa:districts:by-regency:" . $regencyName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFADistricts:*");

                    if (!empty($keys)) {
                        foreach ($keys as $value) {
                            $data[] = Redis::hGetAll($value);
                        }

                        // Extract all next_page_url values
                        $nextPageUrls = array_column($data, 'next_page_url');

                        // Check if all next_page_url values are empty
                        $allEmpty = array_reduce($nextPageUrls, fn($carry, $url) => $carry && empty($url), true);

                        $paginationData = [
                            'data' => $data,
                            'total' => count($data),
                            'per_page' => $this->perPage,
                            'current_page' => $page,
                            'hasMore' => $allEmpty ? false : true,
                        ];

                        $familyActivities = LengthPager::paginate($paginationData);
                    } else {
                        $familyActivities = $this->getData()
                            ->addSelect('districts.id', 'districts.name')
                            ->join('districts', 'dasawismas.district_id', '=', 'districts.id')
                            ->where('dasawismas.regency_id', '=', $this->param)
                            ->groupBy('districts.id')
                            ->orderBy('dasawismas.regency_id', 'ASC')
                            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                            })
                            ->simplePaginate($this->perPage);

                        if ($familyActivities->isNotEmpty()) {
                            $pageData = $familyActivities->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFADistricts) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFADistricts:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFADistricts:{$value['id']}", config('database.redis.options.ttl'));
                                }
                            });
                        }
                    }
                }
                break;
            case strlen($param) == 7: // villages
                $districtName = District::where('id', '=', $param)->value('slug');

                // Jika ada pencarian
                if ($this->search != '') {
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fa:villages:by-district:" . $districtName . ":page-*");

                    // Ambil semua data dari Redis
                    $data = array_reduce($keys, function ($carry, $key) {
                        $cachedData[] = Redis::hGetAll($key);

                        return is_array($cachedData) && isset($cachedData)
                            ? array_merge($carry, $cachedData)
                            : $carry;
                    }, []);

                    // Cari data pada redis
                    $filteredDataFromRedis = array_filter($data, fn($item) => stripos($item['name'], $this->search) !== false);

                    // jika data pencarian tidak ditemukan pada redis, cari di database utama
                    if (empty($filteredDataFromRedis)) {
                        $filteredDataFromMysql = $this->getData()
                            ->addSelect('villages.id', 'villages.name')
                            ->join('villages', 'dasawismas.village_id', '=', 'villages.id')
                            ->where('dasawismas.district_id', '=', $this->param)
                            ->when($this->search != '', function (Builder $query) {
                                $query->where('villages.name', 'LIKE', '%' . trim($this->search) . '%');
                            })
                            ->groupBy('villages.id')
                            ->orderBy('dasawismas.district_id', 'ASC');
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data yang sesuai dengan halaman sekarang
                    $keyCacheFAVillages = $prefix . ':' . $areaName . ":fa:villages:by-district:" . $districtName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFAVillages:*");

                    if (!empty($keys)) {
                        foreach ($keys as $value) {
                            $data[] = Redis::hGetAll($value);
                        }

                        // Extract all next_page_url values
                        $nextPageUrls = array_column($data, 'next_page_url');

                        // Check if all next_page_url values are empty
                        $allEmpty = array_reduce($nextPageUrls, fn($carry, $url) => $carry && empty($url), true);

                        $paginationData = [
                            'data' => $data,
                            'total' => count($data),
                            'per_page' => $this->perPage,
                            'current_page' => $page,
                            'hasMore' => $allEmpty ? false : true,
                        ];

                        $familyActivities = LengthPager::paginate($paginationData);
                    } else {
                        $familyActivities = $this->getData()
                            ->addSelect('villages.id', 'villages.name')
                            ->join('villages', 'dasawismas.village_id', '=', 'villages.id')
                            ->where('dasawismas.district_id', '=', $this->param)
                            ->groupBy('villages.id')
                            ->orderBy('dasawismas.district_id', 'ASC')
                            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                            })
                            ->simplePaginate($this->perPage);

                        if ($familyActivities->isNotEmpty()) {
                            $pageData = $familyActivities->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFAVillages) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFAVillages:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFAVillages:{$value['id']}", config('database.redis.options.ttl'));
                                }
                            });
                        }
                    }
                }
                break;
            case strlen($param) == 10: // dasawisma's
                $villageName = Village::where('id', '=', $param)->value('slug');

                // Jika ada pencarian
                if ($this->search != '') {
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fa:dasawismas:by-village:" . $villageName . ":page-*");

                    // Ambil semua data dari Redis
                    $data = array_reduce($keys, function ($carry, $key) {
                        $cachedData[] = Redis::hGetAll($key);

                        return is_array($cachedData) && isset($cachedData)
                            ? array_merge($carry, $cachedData)
                            : $carry;
                    }, []);

                    // Cari data pada redis
                    $filteredDataFromRedis = array_filter($data, fn($item) => stripos($item['name'], $this->search) !== false);

                    // jika data pencarian tidak ditemukan pada redis, cari di database utama
                    if (empty($filteredDataFromRedis)) {
                        $filteredDataFromMysql = $this->getData()
                            ->addSelect('dasawismas.id', 'dasawismas.name', 'dasawismas.slug')
                            ->where('dasawismas.village_id', '=', $this->param)
                            ->when($this->search != '', function (Builder $query) {
                                $query->where('dasawismas.name', 'LIKE', '%' . trim($this->search) . '%');
                            })
                            ->groupBy('dasawismas.id')
                            ->orderBy('dasawismas.village_id', 'ASC');
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data yang sesuai dengan halaman sekarang
                    $keyCacheFADasawismas = $prefix . ':' . $areaName . ":fa:dasawismas:by-village:" . $villageName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFADasawismas:*");

                    if (!empty($keys)) {
                        foreach ($keys as $value) {
                            $data[] = Redis::hGetAll($value);
                        }

                        // Extract all next_page_url values
                        $nextPageUrls = array_column($data, 'next_page_url');

                        // Check if all next_page_url values are empty
                        $allEmpty = array_reduce($nextPageUrls, fn($carry, $url) => $carry && empty($url), true);

                        $paginationData = [
                            'data' => $data,
                            'total' => count($data),
                            'per_page' => $this->perPage,
                            'current_page' => $page,
                            'hasMore' => $allEmpty ? false : true,
                        ];

                        $familyActivities = LengthPager::paginate($paginationData);
                    } else {
                        $familyActivities = $this->getData()
                            ->addSelect('dasawismas.id', 'dasawismas.name', 'dasawismas.slug')
                            ->where('dasawismas.village_id', '=', $this->param)
                            ->groupBy('dasawismas.id')
                            ->orderBy('dasawismas.village_id', 'ASC')
                            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                            })
                            ->simplePaginate($this->perPage);

                        if ($familyActivities->isNotEmpty()) {
                            $pageData = $familyActivities->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFADasawismas) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFADasawismas:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFADasawismas:{$value['id']}", config('database.redis.options.ttl'));
                                }
                            });
                        }
                    }
                }
                break;
            case $param == 'dasawisma': // family_heads
                $dasawismaName = Dasawisma::where('slug', '=', $this->param)->value('slug');

                // Jika ada pencarian
                if ($this->search != '') {
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fa:family-heads:by-dasawisma:" . $dasawismaName . ":page-*");

                    // Ambil semua data dari Redis
                    $data = array_reduce($keys, function ($carry, $key) {
                        $cachedData[] = Redis::hGetAll($key);

                        return is_array($cachedData) && isset($cachedData)
                            ? array_merge($carry, $cachedData)
                            : $carry;
                    }, []);

                    // Cari data pada redis
                    $filteredDataFromRedis = array_filter($data, fn($item) => stripos($item['name'], $this->search) !== false);

                    // jika data pencarian tidak ditemukan pada redis, cari di database utama
                    if (empty($filteredDataFromRedis)) {
                        $filteredDataFromMysql = $this->getData()
                            ->addSelect('family_heads.id', 'family_heads.family_head AS name')
                            ->where('dasawismas.slug', '=', $this->param)
                            ->when($this->search != '', function (Builder $query) {
                                $query->where('family_heads.family_head', 'LIKE', '%' . trim($this->search) . '%');
                            })
                            ->groupBy('family_heads.id')
                            ->orderBy('family_members.family_id', 'DESC');
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data yang sesuai dengan halaman sekarang
                    $keyCacheFAFamilies = $prefix . ':' . $areaName . ":fa:family-heads:by-dasawisma:" . $dasawismaName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFAFamilies:*");

                    if (!empty($keys)) {
                        foreach ($keys as $value) {
                            $data[] = Redis::hGetAll($value);
                        }

                        // Extract all next_page_url values
                        $nextPageUrls = array_column($data, 'next_page_url');

                        // Check if all next_page_url values are empty
                        $allEmpty = array_reduce($nextPageUrls, fn($carry, $url) => $carry && empty($url), true);

                        $paginationData = [
                            'data' => $data,
                            'total' => count($data),
                            'per_page' => $this->perPage,
                            'current_page' => $page,
                            'hasMore' => $allEmpty ? false : true,
                        ];

                        $familyActivities = LengthPager::paginate($paginationData);
                    } else {
                        $familyActivities = $this->getData()
                            ->addSelect([
                                'family_heads.id',
                                'family_heads.family_head AS name',
                                'family_activities.up2k_activity',
                                'family_activities.env_health_activity'
                            ])
                            ->where('dasawismas.slug', '=', $this->param)
                            ->groupBy('family_heads.id')
                            ->orderBy('family_activities.family_head_id', 'ASC')
                            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                            })
                            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                                $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                            })
                            ->simplePaginate($this->perPage);

                        if ($familyActivities->isNotEmpty()) {
                            $pageData = $familyActivities->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFAFamilies) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFAFamilies:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFAFamilies:{$value['id']}", config('database.redis.options.ttl'));
                                }
                            });
                        }
                    }
                }
                break;
        }

        if ($this->search != '') {
            if (empty($filteredDataFromRedis)) {
                $filteredDataFromMysql = $filteredDataFromMysql
                    ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                        $query->where('dasawismas.village_id', '=', $user->admin->village_id);
                    })
                    ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                        $query->where('dasawismas.district_id', '=', $user->admin->district_id);
                    })
                    ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                        $query->where('dasawismas.regency_id', '=', $user->admin->regency_id);
                    })
                    ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                        $query->where('dasawismas.province_id', '=', $user->admin->province_id);
                    })
                    ->limit($this->perPage)
                    ->get()
                    ->toArray();
            }

            $mergedData = array_merge($filteredDataFromRedis, $filteredDataFromMysql);

            // Menghapus duplikat berdasarkan 'name'
            $uniqueData = [];
            foreach ($mergedData as $item) {
                $uniqueData[$item['name']] = $item; // Menggunakan 'name' sebagai kunci
            }

            // Mengembalikan array hanya dengan nilai (tanpa kunci)
            $uniqueData = array_values($uniqueData);

            $paginationData = [
                'data' => $uniqueData,
                'total' => count($uniqueData),
                'per_page' => $this->perPage,
                'current_page' => $page,
                'hasMore' => count($uniqueData) > $this->perPage,
            ];

            $familyActivities = LengthPager::paginate($paginationData);
        }

        return view('livewire.app.backend.data-recap.family-activity-index', [
            'data' => $familyActivities,
        ]);
    }

    private function getData()
    {
        return FamilyActivity::query()
            ->selectRaw("
                SUM(CASE
                    WHEN ISNULL(NULLIF(family_activities.up2k_activity, ''))
                    THEN 0
                    WHEN family_activities.up2k_activity NOT LIKE '(%%)'
                    THEN 1
                    ELSE LENGTH(family_activities.up2k_activity) - LENGTH(REPLACE(family_activities.up2k_activity, ')', ''))
                END) AS up2k_activities_sum,
                SUM(CASE
                    WHEN ISNULL(NULLIF(family_activities.env_health_activity, ''))
                    THEN 0
                    WHEN family_activities.env_health_activity NOT LIKE '(%%)'
                    THEN 1
                    ELSE LENGTH(family_activities.env_health_activity) - LENGTH(REPLACE(family_activities.env_health_activity, ')', ''))
                END) AS env_health_activities_sum
            ")
            ->join('family_heads', 'family_activities.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id');
    }
}
