<?php

namespace App\Http\Controllers;

use App\User;
use App\Website;
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
        $websites = User::find(Auth::user()->id)->websites()->orderBy('name')->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username', 'users.name as created_by')->get();

        
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
        return view('website.inviteuser',compact('website'));
    }

    public function storeuser(Request $request) {
        
        

        $data = request()->validate([
            'email' => 'required',
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
