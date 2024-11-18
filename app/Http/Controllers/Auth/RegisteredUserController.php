<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\traits\savephoto;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use savephoto;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validation = $request->validated();
    

        if($request->hasFile('image')){
            //using saveimage method in  savephoto trait 
            $image = $this->SaveImage($validation['image'],'users\uploads\avaters',600,600)  ;
            // insert new user in database(users table)
            $user = User::create([
                'name' => $validation['name'],
                'email' => $validation['email'],
                'password' => Hash::make($validation['password']),
                'image'=>$image,
                'bio'=>$validation['bio']

            ]);
       }else{
            $user = User::create([
                'name' => $validation['name'],
                'email' => $validation['email'],
                'password' => Hash::make($validation['password']),
                'bio'=>$validation['bio']
                

            ]);
       }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
