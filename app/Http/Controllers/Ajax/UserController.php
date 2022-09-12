<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function search(Request $request)
  {
    $users = User::query()
      ->where('is_admin', false)
      ->where('first_name', 'like', "%{$request->query('q')}%")
      ->orWhere('last_name', 'like', "%{$request->query('q')}%")
      ->orWhere('email', 'like', "%{$request->query('q')}%")
      ->orWhere('phone', 'like', "%{$request->query('q')}%")
      ->orWhere('staff_id', 'like', "%{$request->query('q')}%")
      ->get(['id', 'first_name', 'last_name'])->map(fn ($item) => [
        'id' => $item->id,
        'text' => $item->name
      ]);
    return $users->toArray();
  }

  public function index(Request $request)
  {
    return [
      'users' => User::with('departments', 'branch', 'designation')
        ->where('is_admin', false)
        ->when($request->has('q'), function ($query) use($request) {
          $query->where('first_name', 'like', "%{$request->query('q')}%")
            ->orWhere('last_name', 'like', "%{$request->query('q')}%")
            ->orWhere('email', 'like', "%{$request->query('q')}%")
            ->orWhere('phone', 'like', "%{$request->query('q')}%")
            ->orWhere('staff_id', 'like', "%{$request->query('q')}%");
        })
        ->latest()
        ->paginate()
    ];
  }

  public function destroy(User $user)
  {
    $user->delete();
  }
}
