<?php

namespace App\Observers;

use App\Models\EmployeeDocument;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
   /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
      $user->staff_id = sprintf("%05d",$user->id);
      $user->save();
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
      
    }

    public function deleting(User $user)
    {
      if($user->photo !== 'photos/default.png' && Storage::exists($user->photo)){
        Storage::delete($user->photo);
      }

      $user->employeeDocuments()->get()->each(function(EmployeeDocument $employeeDocument){
        $employeeDocument->delete();
      });
      
    }
    
}
