<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use function Symfony\Component\Translation;


class CategoriesController extends Controller
{

    public function __construct()
    {

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);

        $data = [
            'name' => $request->name,
        ];

        $category = Categories::create($data);
        return response()->json($category, 201);
    }

    public function index()
    {
        $book = Categories::find(1)->books()->get();
        return response()->json($book, 201);

    }

    public function showAllCategories()
    {
        return response()->json(Categories::all());
    }

    public function showOneCategory($id)
    {
        return response()->json(Categories::find($id));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);

        $category = Categories::findOrFail($id);
        $category->update($request->all());
        return response()->json($category, 201);
    }

    public function delete($id)
    {
        Categories::findOrFail($id)->delete();
        return response('delete', 200);
    }


}


