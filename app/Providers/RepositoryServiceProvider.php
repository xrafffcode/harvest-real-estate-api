<?php

namespace App\Providers;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\BannerRepositoryInterface;
use App\Interfaces\FloorPlanRepositoryInterface;
use App\Interfaces\PropertyAmenityRepositoryInterface;
use App\Interfaces\PropertyCategoryRepositoryInterface;
use App\Interfaces\PropertyRepositoryInterface;
use App\Interfaces\PropertyTypeRepositoryInterface;
use App\Interfaces\TestimonialRepositoryInterface;
use App\Interfaces\WebConfigurationRepositoryInterface;
use App\Repositories\AgentRepository;
use App\Repositories\BannerRepository;
use App\Repositories\FloorPlanRepository;
use App\Repositories\PropertyAmenityRepository;
use App\Repositories\PropertyCategoryRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;
use App\Repositories\TestimonialRepository;
use App\Repositories\WebConfigurationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(WebConfigurationRepositoryInterface::class, WebConfigurationRepository::class);
        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(PropertyAmenityRepositoryInterface::class, PropertyAmenityRepository::class);
        $this->app->bind(PropertyCategoryRepositoryInterface::class, PropertyCategoryRepository::class);
        $this->app->bind(PropertyTypeRepositoryInterface::class, PropertyTypeRepository::class);
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(PropertyTypeRepositoryInterface::class, PropertyTypeRepository::class);
        $this->app->bind(FloorPlanRepositoryInterface::class, FloorPlanRepository::class);
        $this->app->bind(TestimonialRepositoryInterface::class, TestimonialRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
