<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\MailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\DasawismaActivityController;
use App\Http\Controllers\Backend\RoleController as BackendRoleController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Backend\PermissionController as BackendPermissionController;
use App\Http\Controllers\Backend\SumselNewsController as BackendSumselNewsController;
use App\Http\Controllers\Backend\DasawismaActivityController as BackendDasawismaActivityController;
use App\Http\Controllers\Backend\DasawismaController as BackendDasawismaController;
use App\Http\Controllers\Backend\DataInput\FamilyActivityController;
use App\Http\Controllers\Backend\DataInput\FamilyBuildingController;
use App\Http\Controllers\Backend\DataInput\FamilyHeadController;
use App\Http\Controllers\Backend\DataInput\FamilyMemberController;
use App\Http\Controllers\Backend\DataInput\FamilySizeMemberController;
use App\Http\Controllers\Backend\DataInput\MemberController as BackendMemberController;
use App\Http\Controllers\Backend\DataRecap\FamilyBuildingController as DataRecapFamilyBuildingController;
use App\Http\Controllers\Backend\DataRecap\FamilySizeMemberController as DataRecapFamilySizeMemberController;
use App\Http\Controllers\Backend\DataRecap\FamilyMemberController as DataRecapFamilyMemberController;
use App\Http\Controllers\Backend\DataRecap\FamilyActivityController as DataRecapFamilyActivityController;
use App\Http\Controllers\Backend\HomeController;

Route::view('/', 'pages.frontend.home-index')->name('home');

Route::prefix('/dasawisma-activities')->name('dasawisma_activity.')->group(function () {
    Route::controller(DasawismaActivityController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{dasawismaActivity:slug}/detail', 'show')->name('show');
    });
});

Route::prefix('/sumsel-news')->name('sumsel_news.')->group(function () {
    Route::controller(DasawismaActivityController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{sumselNews:slug}/detail', 'show')->name('show');
    });
});

Route::view('/org-structure', 'pages.frontend.org-structure-index')->name('org_structure');

Route::view('/about-us', 'pages.frontend.about-us-index')->name('about_us');

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::view('/login', 'pages.auth.login-index')->name('login');
        Route::view('/login/notice', 'pages.auth.emails.verification-login-via-token')->name('login.token.notice');
        Route::get('/login/{username}', [AuthController::class, 'loginViaToken'])->name('login.token');
        Route::view('/register', 'pages.auth.register-index')->name('register');
    });


    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', ProfileController::class)->name('profile');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/auth/verify-email')->as('verification.')->controller(MailVerificationController::class)->group(function () {
        Route::get('/', 'show')->name('notice');
        Route::get('/not-yet', 'notYet')->name('not-yet');
        Route::get('/invalid', 'invalid')->name('invalid');
        Route::get('/verified', 'verified')->name('verified');
        Route::get('/{id}/{hash}', 'verify')->middleware(['signed'])->name('verify');
    });
});

Route::middleware(['guest'])->group(function () {
    Route::prefix('/auth/forgot-password')->as('password.')->controller(ForgotPasswordController::class)->group(function () {
        Route::get('/', 'create')->name('request');
        Route::get('/notice', 'notice')->name('notice');
    });

    Route::prefix('/auth/reset-password')->as('password.')->controller(ResetPasswordController::class)->group(function () {
        Route::get('/invalid', 'invalid')->name('invalid');
        Route::get('/{token}', 'create')->name('reset');
    });
});

Route::prefix('/area')->name('area.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', HomeController::class)->name('dashboard');

    Route::prefix('/data-input')->as('data-input.')->group(function () {
        Route::prefix('/dasawisma')->as('dasawisma.')->controller(BackendDasawismaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{dasawisma:slug}/edit', 'edit')->name('edit');
        });

        Route::prefix('/member')->as('member.')->group(function () {
            Route::controller(BackendMemberController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
            });

            Route::get('/family-heads/{familyHead:kk_number}/edit', FamilyHeadController::class)->name('family-head.edit');
            Route::get('/family-buildings/{kk_number}/edit', FamilyBuildingController::class)->name('family-building.edit');
            Route::get('/family-size-members/{kk_number}/edit', FamilySizeMemberController::class)->name('family-size-member.edit');
            Route::get('/family-members/{kk_number}/edit', FamilyMemberController::class)->name('family-member.edit');
            Route::get('/families-activities/{kk_number}/edit', FamilyActivityController::class)->name('family-activity.edit');
        });
    });

    Route::prefix('/data-recap')->as('data-recap.')->group(function () {
        Route::prefix('family-buildings')->as('family-buildings.')->controller(DataRecapFamilyBuildingController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/area-code/{code}', 'index')->name('show-area');
            Route::get('/dasawisma/{slug}', 'index')->name('show-dasawisma');
        });

        Route::prefix('family-size-members')->as('family-size-members.')->controller(DataRecapFamilySizeMemberController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/area-code/{code}', 'index')->name('show-area');
            Route::get('/dasawisma/{slug}', 'index')->name('show-dasawisma');
        });

        Route::prefix('family-members')->as('family-members.')->controller(DataRecapFamilyMemberController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/area-code/{code}', 'index')->name('show-area');
            Route::get('/dasawisma/{slug}', 'index')->name('show-dasawisma');
        });

        Route::prefix('family-activities')->as('family-activities.')->controller(DataRecapFamilyActivityController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/area-code/{code}', 'index')->name('show-area');
            Route::get('/dasawisma/{slug}', 'index')->name('show-dasawisma');
        });
    });

    Route::prefix('/dasawisma-activities')->controller(BackendDasawismaActivityController::class)->name('dasawisma_activity.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{dasawismaActivity:slug}/edit', 'edit')->name('edit');
        });

    Route::prefix('/sumsel-news')->controller(BackendSumselNewsController::class)->name('sumsel_news.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{sumselNews:slug}/edit', 'edit')->name('edit');
        });

    Route::prefix('/users')->controller(BackendUserController::class)->name('users.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{user:username}/edit', 'edit')->name('edit');
        });

    Route::prefix('/roles')->controller(BackendRoleController::class)->name('roles.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{role:slug}/edit', 'edit')->name('edit');
        });

    Route::prefix('/permissions')->controller(BackendPermissionController::class)->name('permissions.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{permission:slug}/edit', 'edit')->name('edit');
        });
});
