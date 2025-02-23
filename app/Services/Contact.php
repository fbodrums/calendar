<?php

namespace App\Services;

use App\Traits\Encrypt;
use DataTables\Editor;
use DataTables\Editor\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Contact
{
    public function dataTable(Request $request)
    {

        $user = Auth::user();

        Editor::inst(getConnectionDataTable(), 'contacts', 'id')
            ->fields(
                Field::inst('id'),
                Field::inst('name'),
                Field::inst('document'),
                Field::inst('street'),
                Field::inst('number'),
                Field::inst('complement'),
                Field::inst('neighborhood'),
                Field::inst('city'),
                Field::inst('state'),
                Field::inst('country'),
                Field::inst('lat'),
                Field::inst('lng'),
                Field::inst('zip'),
            )
            ->where('user_id', $user->id)
            ->where(function ($q) use ($request) {


                if (!empty($request->filter)) {
                    foreach ($request->filter as $filter => $value) {
                        // dump([$filter, $value]);
                        if (!empty($value)) {
                            $q->where($filter, "%{$value}%", 'LIKE');
                        }
                    }
                }
            })
            ->process($request->all())
            ->json();
    }
}
