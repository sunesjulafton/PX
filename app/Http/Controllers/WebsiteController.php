<?php

namespace App\Http\Controllers;

use App\User;
use App\Website;
use Illuminate\Http\Request;
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
        $websites = User::find(Auth::user()->id)->websites()->orderBy('website_name')->join('users', 'users.id', '=', 'websites.created_by')
        ->select('websites.*', 'users.email as username')->get();

        
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

    public function store() {
        $data = request()->validate([
            'website_name' => 'required',
            'website_url' => 'required',
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
            'website_name' => 'required',
            'website_url' => 'required'
        ]);
    }

}
