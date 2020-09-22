<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Contact;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class ContactController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = new Contact();
        $contacts = $contact->orderBy('contact_id')->get();

        return view('admin.contact.list', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.contact.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('contact.create'))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $contact = new Contact();
        $contact->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('contact.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact  $contact)
    {
        return View('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact  $contact)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('contact.edit', ['contact_id' => $contact->contact_id]))
                ->withErrors($validation)
                ->withInput();
        }

        $contact->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('contact.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact  $contact)
    {
        $contact->delete();

        return redirect(route('contact.index'));
    }
}
