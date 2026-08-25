<?php

namespace App\Providers;

use App\Models\LessonPlan;
use App\Policies\LessonPlanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(LessonPlan::class, LessonPlanPolicy::class);
    }
}