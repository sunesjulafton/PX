<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //$websites = Website::orderBy('website_name')->get()->where('user_id', Auth::user()->websites->pivot->user_id)->sortDesc();
        /*$websites = User::find(Auth::user()->id)->websites()->orderBy('website_name')->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username')->get();
        */

        $account =  Auth::user()->accounts()->where('email', Auth::user()->email)->first();
        if(!empty($account)) {
            $users = Account::find($account->id)->users()->orderBy('name')->get();
        }
        return view('account.index', compact('users'));
    }

    public function create() {

        $roles = Role::all();
        /* exclude account owner*/
        $roles = $roles->except(1);
        return view('account.create', compact('roles'));
    }

    public function store() {

        
        $user = User::where('email', request()->email)->first();

        if(isSet($user)) {

            
            $data = request()->validate([
                'role'=> 'required',
            ]);
            
            // $data['user_id'] = auth()->user()->id;
            // $questionnaire = \App\Questionnaire::create($data);

        }
        else {
            $data = request()->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'role'=> 'required',
            ]);

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('dalle2001'),
                'activated_at' => Carbon::now()->toDateTimeString(),
            ]);


            $account = Account::where('email', Auth::user()->email)->first();
            $account->users()->attach($user->id);
        }

        
        $role = Role::where('id', $data['role'])->first();
        if($user->hasRole($role->slug)) {
            dd("User already has role " . $role->name);
        }
        else {
            $user->roles()->attach($data['role']);
        }    
        
        

        



        /* Send invitation email
        $to_name = $data['name'];
        $to_email = $data['email'];
        $data = array('name'=>$data['name'], "body" => "You've got an invite to collaborate in PX");
            


        Mail::send('account.invitemail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('PX invitation');
            $message->from(env('MAIL_FROM_ADDRESS'),env('APP_NAME'));
        });
        */

        
        //return redirect('/websites/'.$website->id);
        return redirect('/accounts');
    }

}
