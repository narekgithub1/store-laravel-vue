<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authors;
use function Symfony\Component\Translation;


class AuthorsController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $book = Authors::find(1)->books()->get();
        return response()->json($book);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);

        $data = [
            'name' => $request->name,
        ];

        $author = Authors::create($data);
        return response()->json($author, 201);
    }

    public function showAllAuthors()
    {
        return response()->json(Authors::all());
    }

    public function showOneAuthor($id)
    {
        return response()->json(Authors::find($id));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);
        $author = Authors::findOrFail($id);
        $author->update($request->all());
        return response()->json($author, 201);
    }

    public function delete($id)
    {
        Authors::findOrFail($id)->delete();
        return response('delete', 200);
    }


}


