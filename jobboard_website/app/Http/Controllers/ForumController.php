<?php

namespace App\Http\Controllers;

use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
   function afficherUnForum($id){
       if (Auth::check()){
           $forum = Forum::find($id);
           return view("forum/afficherUnForum",["forum"=>$forum]);
       }
       return redirect(route('login'));

   }
}
