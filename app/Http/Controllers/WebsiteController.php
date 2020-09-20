<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Account;
use App\Website;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebsiteController extends Controller
{


    use SoftDeletes;

    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('website.create');
    }

    public function index()
    {
        
        //$websites = Website::orderBy('website_name')->get()->where('user_id', Auth::user()->websites->pivot->user_id)->sortDesc();
        
        /*
        $websites = User::find(Auth::user()->id)->websites()->orderBy('name')->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username', 'users.name as created_by')->get();
        */

        $website_ids = [];

        /* fetch users websites */
        $websites = Website::where('created_by', Auth::user()->id)->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username', 'users.name as created_by')->get();

        foreach($websites as $website) {
            array_push($website_ids, $website->id);
        }


        if(!isSet($websites)) {
            $websites = array();
        }

        /* fetch accounts websites */
        $accounts = Auth::user()->accounts()->get();
        foreach($accounts as $account) {
            
            $user = User::find($account->id);
            $current_websites = Website::where('created_by', $user->id)->join('users', 'users.id', '=', 'websites.created_by')
            ->select('websites.*', 'users.email as username', 'users.name as created_by')->get();
            foreach($current_websites as $website) {
                if (!in_array($website->id, $website_ids)) {
                    $websites->push($website);
                }
            }
            
        }
        
        //dd(Account::where('user_id', Auth::user()->id));
        
        //$websites = 
        
        /*
        $users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();
        */



        
        //$websites = Auth::user()->websites;
        //dd($websites);
        return view('website.index', compact('websites'));
    }

    public function store(Request $request) {
        
        $data = request()->validate([
            'name' => 'required',
            'url' => 'required',
            'created_by' => 'required',
        ]);

        

        // $data['user_id'] = auth()->user()->id;
        // $questionnaire = \App\Questionnaire::create($data);
        $website = auth()->user()->websites()->create($data);
        //return redirect('/websites/'.$website->id);
        return redirect('/websites');
    }
    
    public function show(Website $website) {
        /*
        $website->load('websites');
        $website = \App\Website::findOrFail($website->id);
        */
        //dd($website);
        return view('website.show', compact('website'));
    }

    public function edit(Website $website) {
        return view('website.edit', compact('website'));
    }

    public function update(Website $website) {
        $website->update($this->validatedData());
        return redirect('/websites');
    }

    public function destroy(Website $website) {
        //$website->answers()->delete();
        $website->delete();
        return redirect('/websites');
    }

    protected function validatedData() {
        return request()->validate([
            'name' => 'required',
            'url' => 'required'
        ]);
    }

    public function manageusers(Website $website) {
    
        
        
        /*
        $users = DB::table('users')
            ->join('user_website', 'users.id', '=', 'user_website.user_id')
            ->join('websites', 'websites.id', '=', 'user_website.website_id')
            ->select('users.*')
            ->where('websites.id', '=', $webiste_id)
            ->get();
        */
        //$users = $website->users();

        $users = Website::find($website->id)->users()->orderBy('name')->get();

        

        return view('website.manageusers', compact('users', 'website'));
    }

    public function removeuser(Website $website, Request $request) {
        $user = $request['user_id'];
        User::find($user)->websites()->detach($website->id);
        $users = Website::find($website->id)->users()->orderBy('name')->get();
        return view('website.manageusers', compact('users', 'website'));
    }

    /*
    public function adduser(Website $website, Request $request) {

        $user_id = $request['user_id'];
        $website_id = $website->id;


        $data = request()->validate([
            'website_id' => $website_id,
            'user_id' => $user_id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        dd($data);

        // $data['user_id'] = auth()->user()->id;
        // $questionnaire = \App\Questionnaire::create($data);

        $users = DB::table('user_website').create($data);
            

    }
    */
    public function inviteuser(Website $website) {

        $roles = Role::all();
        /* exclude account owner*/
        $roles = $roles->except(1);

        return view('website.inviteuser',compact('website', 'roles'));
    }

    public function storeuser(Request $request) {
        
        

        $data = request()->validate([
            'email' => 'required',
            'role' => 'required'
        ]);

        


        $email = $request['email'];
        $website_id = $request['website_id'];
        $invited_by = $request['invited_by'];
        
        //$website->id = $request['website_id'];
        //$website->invited_by = $request['invited_by'];
        //$website->created_at = Carbon::now()->toDateTimeString();

        $user = User::where('email', $email)->first();
        

        /* if user exists */
        if(!empty($user)) {
            
            //$website = Website::where('id', $website_id)->first();
            $website = Website::find($request['website_id']);
            $userexist = $website->users()->find($user->id);
            /* if user has access to website */
            if(isset($userexist)) {
                $role = $website->users()->find($userexist->id)->roles()->first();
                dd($role->name);

                /* check role for website if given higher remove old and set new */
                $role_id = $role->id;            
                if($role_id > $request['role']) {
                    $user->roles()->detach($role);
                    $user->roles()->attach($data['role']);
                    dd("ändrat");
                }
                else {
                    dd("This user is already invited as ");
                }
            }
            else {

                //if website created by account where user is invited to

                $accounts =  $user->accounts()->get();
                foreach($accounts as $account) {
                    dd($account->users()->websites()->get());
                }

                

                //$role = $website->users()->find($user->id)->roles()->first();
            }
            
            
            
            
            /*
            $role = Role::where('id', $data['role'])->first();
            if($user->hasRole($role->slug)) {
                dd("User already has role " . $role->name);
            }
            else {
                $user->roles()->attach($data['role']);
            }    
            */

            $user->websites()->attach($website_id, ['invited_by' => $invited_by]);
           
            

            //$user->websites()->attach([
                
                /*
                'user_id' => $user->id,
                'website_id' => $website_id,
                'invited_by' => $invited_by
                */

                
                
                //]);

            /*
            $website = Website::find($website_id);
            
            $website->users[0]->user_id = $user->id;
            $website->users[0]->invited_by = $invited_by;
            $website->users[0]->created_at = Carbon::now()->toDateTimeString();
            dd($website);
            $website->push();
            */
            


            //->push($user);



            //$user->websites()->create([
            


            //]);    

            //User::find($user->id)->websites()->save($website_id);
        }
        else {
            /* create user and send email */


            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('dalle2001'),
                'activated_at' => Carbon::now()->toDateTimeString(),
            ]);


            $account = Account::where('email', Auth::user()->email)->first();
            $account->users()->attach($user->id);


        } 
        

        //if(User::find($user))
        


        //User::find($user)
        /*
        $user = $request['user_id'];
        User::find($user)->websites()->detach($website->id);
        $users = Website::find($website->id)->users()->orderBy('name')->get();
        return view('website.manageusers', compact('users', 'website'));

        // $data['user_id'] = auth()->user()->id;
        // $questionnaire = \App\Questionnaire::create($data);

        $website = auth()->user()->websites()->create($data);
        //return redirect('/websites/'.$website->id);
        */

        return redirect('/websites');
        
    }


}
