<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    public function users()
    {
        return $this->hasOne('App\User');
    }

    public function full() {
      if(is_a($this->users, 'Illuminate\Database\Eloquent\Collection')) {
        return false;
      }
      return $this->users->count >= 3;
    }

    public function next($id) {
      $users = $this->users;
      if ($users[0]->id === $id) {
        return $users[1]->id;
      } else if ($users[1] === $id) {
        return $users[2]->id;
      } else {
        return $users[0]->id;
      }
    }
}
