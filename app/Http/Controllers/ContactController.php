<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\ContactRequest;
use App\Models\Contact as ModelsContact;
use App\Services\Contact as ServiceContact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contactService = new ServiceContact;
        return $contactService->dataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        try {
            DB::beginTransaction();
            ModelsContact::create([...$request->validated(), 'user_id' => auth()->user()->id]);

            DB::commit();

            return Response::redirect('contact.show.all');
        } catch (Exception $e) {

            dd($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelsContact $contact)
    {
        return view('contacts.form', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, ModelsContact $contact)
    {
        try {
            foreach ($request->validated() as $key => $value) {
                $contact->{$key} = $value;
            }

            $contact->save();
            return Response::redirect('contact.show.all');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsContact $contact)
    {
        if ($contact->user_id === auth()->user()->id) {
            $contact->delete();
        }

        return response()->json(['status' => true]);
    }
}
