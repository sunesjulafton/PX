<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        $types = ['admin', 'user', 'guest'];
        return view('user.create', compact('types'));
    }

    public function index()
    {
        //$websites = Website::orderBy('website_name')->get()->where('user_id', Auth::user()->websites->pivot->user_id)->sortDesc();
        /*$websites = User::find(Auth::user()->id)->websites()->orderBy('website_name')->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username')->get();
        */


        /*
        $users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();
        */

        $users = DB::table('users')->get();

        //dd($users);
        //$websites = Auth::user()->websites;
        //dd($websites);
        return view('user.index', compact('users'));
    }

    public function edit(User $user) {
        return view('user.edit', compact('user'));
    }

   
    public function store() {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type'=> 'required',
            
        ]);
        // $data['user_id'] = auth()->user()->id;
        // $questionnaire = \App\Questionnaire::create($data);

        
        //dd($data);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'activated_at' => Carbon::now()->toDateTimeString(),
            
        ]);

        
        
        //return redirect('/websites/'.$website->id);
        return redirect('/users');
    }


    public function update(User $user) {
        $user->update($this->validatedData());
        return redirect('/users');
    }

    public function destroy(User $user) {
        //$website->answers()->delete();
        $user->delete();
        return redirect('/users');
    }

    protected function validatedData() {
        return request()->validate([
            'name' => 'required',
        ]);
    }
}
