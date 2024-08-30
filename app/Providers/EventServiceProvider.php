<?php

namespace App\Providers;

use App\Listeners\checklistListener;
use App\Listeners\UpdatechecklistListener;

use App\Events\backend\EventPayments;
use App\Events\frontend\checklistEvents;
use App\Events\frontend\LogDataContract;
use App\Events\frontend\LogDataCusTag;
use App\Events\frontend\LogDataAsset;
use App\Events\frontend\MsTeamsEvent;
use App\Listeners\frontend\LogDataCusListener;
use App\Listeners\frontend\LogDataCusTagListener;
use App\Listeners\frontend\LogDataContractListener;
use App\Listeners\frontend\LogDataAssetListener;
use App\Listeners\frontend\MsTeamsListener;

use App\Listeners\backend\UpdateStatINVListener;
use App\Listeners\backend\UpdateContractListener;

use App\Events\api\sendNotificationApp;
use App\Listeners\api\noti_PaymentDue;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        checklistEvents::class => [
            checklistListener::class,
            UpdatechecklistListener::class,
        ],
        EventPayments::class => [
            UpdateStatINVListener::class,
            UpdateContractListener::class
        ],
        LogDataAsset::class => [
            LogDataAssetListener::class,
        ],
        LogDataCusTag::class => [
            LogDataCusTagListener::class,
        ],
        LogDataCus::class => [
            LogDataCusListener::class,
        ],
        LogDataContract::class => [
            LogDataContractListener::class,
        ],
        MsTeamsEvent::class => [
            MsTeamsListener::class,
        ],
        sendNotificationApp::class => [
            noti_PaymentDue::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
