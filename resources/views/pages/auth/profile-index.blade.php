<x-app-layout>
    <div class="layout-fluid">

        <div class="page-header">
            <div class="container-xl">
                <livewire:app.auth.profiles.photo :$user />
            </div>
        </div>

        <hr />

        <div class="page-body">
            <div class="container-xl d-flex flex-column justify-content-center">
                <div class="row row-cards">
                    <div class="col-md-12">
                        <div class="card" x-data="{ currentTabProfile: $persist('tabsProfileDetail') }">
                            <div class="card-header">
                                <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                    <li @click.prevent="currentTabProfile = 'tabsProfileDetail'" class="nav-item">
                                        <a href="#tabsProfileDetail" class="nav-link"
                                            :class="currentTabProfile === 'tabsProfileDetail' ? 'active' : ''" data-bs-toggle="tab">
                                            Detail Profile
                                        </a>
                                    </li>
                                    @can(['update-profile'])
                                        <li @click.prevent="currentTabProfile = 'tabsChangePassword'" class="nav-item">
                                            <a href="#tabsChangePassword" class="nav-link"
                                                :class="currentTabProfile === 'tabsChangePassword' ? 'active' : ''" data-bs-toggle="tab">
                                                Ubah Kata Sandi
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div wire:ignore.self class="tab-pane fade show"
                                        :class="currentTabProfile === 'tabsProfileDetail' ? 'active' : ''" id="tabsProfileDetail">
                                        <livewire:app.auth.profiles.bio-data :$user />
                                    </div>
                                    @can(['update-profile'])
                                        <div wire:ignore.self class="tab-pane fade show"
                                            :class="currentTabProfile === 'tabsChangePassword' ? 'active' : ''" id="tabsChangePassword">
                                            <livewire:app.auth.profiles.password :$user />
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const showAlert = (message, type) => {
                const wrapper = document.createElement('div');

                if (type == 'success') {
                    wrapper.innerHTML = [
                        `<div class="alert alert-important alert-${type} d-flex align-items-center alert-dismissible mt-3 mb-0 mx-2 mx-lg-3" role="alert">`,
                        '   <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24"',
                        '       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                        '       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>',
                        '       <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>',
                        '       <path d="M9 12l2 2l4 -4"></path>',
                        '   </svg>',
                        `   <div>${message}</div>`,
                        '   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>',
                        '</div>'
                    ].join('');
                } else {
                    wrapper.innerHTML = [
                        `<div class="alert alert-important alert-${type} d-flex align-items-center alert-dismissible mt-3 mb-0 mx-2 mx-lg-3" role="alert">`,
                        '   <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24"',
                        '       stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                        '       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>',
                        '       <circle cx="12" cy="12" r="9"></circle>',
                        '       <line x1="12" y1="8" x2="12" y2="12"></line>',
                        '       <line x1="12" y1="16" x2="12.01" y2="16"></line>',
                        '   </svg>',
                        `   <div>${message}</div>`,
                        '   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>',
                        '</div>'
                    ].join('');
                }

                const alertComponent = document.querySelector('.layout-fluid');
                alertComponent.appendChild(wrapper);
            }

            Livewire.on('show-alert', (event) => {
                showAlert(event.text, event.type);

                setTimeout(() => {
                    bootstrap.Alert.getOrCreateInstance('.alert').close();
                }, 5000);
            });
        </script>
    </x-slot>
</x-app-layout>
