<?php

namespace App\Observers;

use App\Models\MatterRelationSchema;
use Illuminate\Support\Carbon;

class MatterRelationSchemaObserver
{
    /**
     *Handle the MatterRelationSchema "creating" event
     */
    public function creating(MatterRelationSchema $schema): void
    {
        MatterRelationSchema::whereNull('expired_at')->update(['expired_at' => Carbon::now()]);
    }


    /**
     * Handle the MatterRelationSchema "created" event.
     */
    public function created(MatterRelationSchema $matterRelationSchema): void
    {
//        $matterRelationSchema->expired_at = Carbon::now()->addYear();
//        $matterRelationSchema->save();
    }

    /**
     * Handle the MatterRelationSchema "updated" event.
     */
    public function updated(MatterRelationSchema $matterRelationSchema): void
    {
        //
    }

    /**
     * Handle the MatterRelationSchema "deleted" event.
     */
    public function deleted(MatterRelationSchema $matterRelationSchema): void
    {
        //
    }

    /**
     * Handle the MatterRelationSchema "restored" event.
     */
    public function restored(MatterRelationSchema $matterRelationSchema): void
    {
        //
    }

    /**
     * Handle the MatterRelationSchema "force deleted" event.
     */
    public function forceDeleted(MatterRelationSchema $matterRelationSchema): void
    {
        //
    }
}
