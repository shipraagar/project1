<?php

namespace App\Providers;

use App\Events\SupportMessage;
use App\Events\TenantRegisterEvent;
use App\Listeners\SupportSendMailToAdmin;
use App\Listeners\SupportSendMailToUser;
use App\Listeners\TenantDataSeedListener;
use App\Listeners\TenantDomainCreate;
use App\Models\User;
use App\Observers\TenantRegisterObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SupportMessage::class => [
            SupportSendMailToAdmin::class,
            SupportSendMailToUser::class
        ],

        TenantRegisterEvent::class => [
            TenantDomainCreate::class,
            TenantDataSeedListener::class,
        ]
    ];

    public function boot()
    {
        /* tenant model observer */
        User::observe(TenantRegisterObserver::class);
    }
}
