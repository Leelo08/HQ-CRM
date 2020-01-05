<?php

namespace App\Listener;

use App\Events\NewCompanyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCompanyMail;


class NewCompanyListener implements ShouldQueue
{
    public function handle($event)
    {
        sleep(10);
        
        Mail::to('admin@admin.com')->send(new NewCompanyMail($event->newCompany));
    }
}
