<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Exception;



class SocialAuthLinkedinController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin')->stateless()->redirect();
    }


    public function callback()
    {

        try {
            $linkdinUser = Socialite::driver('linkedin')->stateless()->user();
            $existUser = User::where('email',$linkdinUser->email)->first();
            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->nom = $linkdinUser->last_name;
                $user->prenom = $linkdinUser->first_name;
                $user->email = $linkdinUser->email;
                $user->picture = $linkdinUser->avatar;
                $user->linkedin_id = $linkdinUser->id;
                $user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
                return redirect(route('chooseRole', ["id" => $user->id]));
            }
            return redirect()->to(route('accueil'));
        }
        catch (\InvalidArgumentException $e) {
            dump(Socialite::driver('linkedin')->user());
            exit(1);
        }
    }
}
