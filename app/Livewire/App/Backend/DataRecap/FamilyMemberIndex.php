<?php

namespace App\Livewire\App\Backend\DataRecap;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Dasawisma;
use App\Helpers\LengthPager;
use App\Models\FamilyMember;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Livewire\Urls\Facades\Url as LivewireUrl;

class FamilyMemberIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $param = '';

    public int $perPage = 5;

    #[Url()]
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
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fm:regencies:page-*");

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
                    $keyCacheFMRegencies = $prefix . ':' . $areaName . ":fm:regencies:page-" . $page;

                    $keys = Redis::keys("$keyCacheFMRegencies:*");

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

                        $familyMembers = LengthPager::paginate($paginationData);
                    } else {
                        $familyMembers = $this->getData()
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

                        if ($familyMembers->isNotEmpty()) {
                            $pageData = $familyMembers->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFMRegencies) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFMRegencies:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFMRegencies:{$value['id']}", config('database.redis.options.ttl'));
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
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fm:districts:by-regency:" . $regencyName . ":page-*");

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
                    $keyCacheFMDistricts = $prefix . ':' . $areaName . ":fm:districts:by-regency:" . $regencyName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFMDistricts:*");

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

                        $familyMembers = LengthPager::paginate($paginationData);
                    } else {
                        $familyMembers = $this->getData()
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

                        if ($familyMembers->isNotEmpty()) {
                            $pageData = $familyMembers->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFMDistricts) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFMDistricts:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFMDistricts:{$value['id']}", config('database.redis.options.ttl'));
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
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fm:villages:by-district:" . $districtName . ":page-*");

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
                    $keyCacheFMVillages = $prefix . ':' . $areaName . ":fm:villages:by-district:" . $districtName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFMVillages:*");

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

                        $familyMembers = LengthPager::paginate($paginationData);
                    } else {
                        $familyMembers = $this->getData()
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

                        if ($familyMembers->isNotEmpty()) {
                            $pageData = $familyMembers->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFMVillages) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFMVillages:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFMVillages:{$value['id']}", config('database.redis.options.ttl'));
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
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fm:dasawismas:by-village:" . $villageName . ":page-*");

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
                    $keyCacheFMDasawismas = $prefix . ':' . $areaName . ":fm:dasawismas:by-village:" . $villageName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFMDasawismas:*");

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

                        $familyMembers = LengthPager::paginate($paginationData);
                    } else {
                        $familyMembers = $this->getData()
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

                        if ($familyMembers->isNotEmpty()) {
                            $pageData = $familyMembers->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFMDasawismas) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFMDasawismas:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFMDasawismas:{$value['id']}", config('database.redis.options.ttl'));
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
                    $keys = Redis::keys($prefix . ':' . $areaName .  ":fm:family-heads:by-dasawisma:" . $dasawismaName . ":page-*");

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
                    $keyCacheFMFamilies = $prefix . ':' . $areaName . ":fm:family-heads:by-dasawisma:" . $dasawismaName . ":page-" . $page;

                    $keys = Redis::keys("$keyCacheFMFamilies:*");

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

                        $familyMembers = LengthPager::paginate($paginationData);
                    } else {
                        $familyMembers = $this->getData()
                            ->addSelect('family_heads.id', 'family_heads.family_head AS name')
                            ->where('dasawismas.slug', '=', $this->param)
                            ->groupBy('family_heads.id')
                            ->orderBy('family_members.family_head_id', 'ASC')
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

                        if ($familyMembers->isNotEmpty()) {
                            $pageData = $familyMembers->toArray();

                            Redis::transaction(function ($redis) use ($pageData, $keyCacheFMFamilies) {
                                foreach ($pageData['data'] as $value) {
                                    $redis->hMSet("$keyCacheFMFamilies:{$value['id']}", [...$value, ...['next_page_url' => $pageData['next_page_url']]]);
                                    $redis->expire("$keyCacheFMFamilies:{$value['id']}", config('database.redis.options.ttl'));
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

            $familyMembers = LengthPager::paginate($paginationData);
        }

        return view('livewire.app.backend.data-recap.family-member-index', [
            'data' => $familyMembers,
        ]);
    }

    private function getData()
    {
        return FamilyMember::query()
            ->selectRaw("
                COUNT(family_members.family_head_id) AS family_members_count,
                COUNT(CASE WHEN family_members.gender = 'Laki-laki' THEN 1 ELSE 0 END) AS gender_males_count,
                COUNT(CASE WHEN family_members.gender = 'Perempuan' THEN 1 ELSE 0 END) AS gender_females_count,
                COUNT(CASE WHEN family_members.marital_status = 'Kawin' THEN 1 ELSE 0 END) AS marries_count,
                COUNT(CASE WHEN family_members.marital_status = 'Belum Kawin' THEN 1 ELSE 0 END) AS singles_count,
                COUNT(CASE WHEN family_members.marital_status = 'Janda' THEN 1 ELSE 0 END) AS widows_count,
                COUNT(CASE WHEN family_members.marital_status = 'Duda' THEN 1 ELSE 0 END) AS widowers_count,
                COUNT(CASE WHEN family_members.profession != 'Belum/Tidak Bekerja' THEN 1 ELSE 0 END) AS workings_count,
                COUNT(CASE WHEN family_members.profession LIKE '%Tidak Bekerja%' THEN 1 ELSE 0 END) AS not_workings_count,
                COUNT(CASE WHEN family_members.last_education = 'TK/PAUD' THEN 1 ELSE 0 END) AS kindergartens_count,
                COUNT(CASE WHEN family_members.last_education = 'SD/MI' THEN 1 ELSE 0 END) AS elementary_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'SLTP/SMP/MTS' THEN 1 ELSE 0 END) AS middle_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'SLTA/SMA/MA/SMK' THEN 1 ELSE 0 END) AS high_schools_count,
                COUNT(CASE WHEN family_members.last_education = 'Diploma' THEN 1 ELSE 0 END) AS associate_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S1' THEN 1 ELSE 0 END) AS bachelor_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S2' THEN 1 ELSE 0 END) AS master_degrees_count,
                COUNT(CASE WHEN family_members.last_education = 'S3' THEN 1 ELSE 0 END) AS post_degrees_count
            ")
            ->join('family_heads', 'family_members.family_head_id', '=', 'family_heads.id')
            ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id');
    }
}
