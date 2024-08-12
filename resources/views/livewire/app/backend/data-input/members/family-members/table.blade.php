<div>
    <div class="card-header py-2 d-flex flex-wrap justify-content-center justify-content-md-between gap-2">
        <div class="text-muted">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                </select>
                data
            </label>
        </div>
        <div class="text-muted">
            <div class="input-icon">
                <input type="text" wire:model.live.debounce.300ms='search' class="form-control" placeholder="Cari...">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div wire:loading.delay class="container">
        <div class="text-center mt-2">
            <span wire:loading role="status" class="spinner-border spinner-border-sm"></span>&ensp;
            <span wire:loading role="status">Memuat..</span>
        </div>
    </div>

    <div wire:loading.class='invisible' class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Dasawisma
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Wilayah
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            No. KK
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Nama
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            NIK
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Tgl Lahir
                        </div>
                    </th>
                    <th colspan="2" class="text-center">Status</th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Jenis Kelamin
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Pendidikan Terakhir
                        </div>
                    </th>
                    <th rowspan="2">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Pekerjaan
                        </div>
                    </th>
                    @if (auth()->user()->role_id != 3)
                        <th rowspan="2" class="w-1">Aksi</th>
                    @endif
                </tr>
                <tr>
                    <th>
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            di Keluarga
                        </div>
                    </th>
                    <th>
                        <div class="d-flex flex-nowrap justify-content-between align-items-center">
                            Kawin
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php($i = $this->familyMembers->perPage() * $this->familyMembers->currentPage() - ($this->familyMembers->perPage() - 1))

                @forelse ($this->familyMembers as $kkNumber => $familyMembers)
                    @foreach ($familyMembers as $familyMember)
                        <tr wire:key='family-member-{{ $familyMember->id }}' class="text-nowrap">
                            <th class="text-muted">{{ $i }}</th>
                            <td class="text-muted">{{ $familyMember->dasawisma_name }}</td>
                            <td class="text-muted">{{ $familyMember->area }}</td>
                            <td>{{ $familyMember->kk_number }}</td>
                            <td>{{ $familyMember->name }}</td>
                            <td>{{ $familyMember->nik_number }}</td>
                            <td>{{ $familyMember->birth_date }}</td>
                            <td>{{ $familyMember->status }}</td>
                            <td>{{ $familyMember->marital_status }}</td>
                            <td>{{ $familyMember->gender }}</td>
                            <td>{{ $familyMember->last_education }}</td>
                            <td>{{ $familyMember->profession }}</td>
                            @if (auth()->user()->role_id != 3)
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a wire:navigate
                                            href="{{ route('area.data-input.member.family-member.edit', $familyMember->kk_number) }}"
                                            class="form-selectgroup-label bg-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit text-white"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                <path d="M16 5l3 3"></path>
                                            </svg>
                                        </a>
                                        @if (!$loop->first || $familyMember->status != 'Kepala Keluarga')
                                            <livewire:app.backend.data-input.members.family-members.delete :$familyMember :key="'delete-' . $familyMember->id" />
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @php($i++)
                    @endforeach
                @empty
                    <tr>
                        <td colspan="14" class="text-center text-info">Data tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div wire:loading.class='invisible'>
        @if (method_exists($this->familyMembers, 'hasPages'))
            @if ($this->familyMembers->hasPages())
                <div class="card-footer py-2 d-flex justify-content-center align-items-center">
                    {{ $this->familyMembers->links('paginations.custom-simple-pagination-links') }}
                </div>
            @endif
        @endif
    </div>
</div>
