<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\AuthUserRepository;
use App\Repositories\AuthUserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\DoctorRepository;
use App\Repositories\GouvernoratRepository;
use App\Repositories\GouvernoratRepositoryInterface;
use App\Repositories\PositionRepository;
use App\Repositories\PositionRepositoryInterface;
use App\Repositories\SpecializationRepository;
use App\Repositories\SpecializationRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(SpecializationRepositoryInterface::class, SpecializationRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(AuthUserRepositoryInterface::class, AuthUserRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(GouvernoratRepositoryInterface::class, GouvernoratRepository::class);
    }

    public function boot()
    {
        //
    }
}
