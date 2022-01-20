<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation;


class BookController extends Controller
{

    public function __construct()
    {

    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'name' => 'required',
                'amount' => 'required|numeric',
                'count' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                ($errors = $validator->errors());
            }
            $data = [
                'name' => $request->name,
                'amount' => $request->amount,
                'count' => $request->count,
                'seller_id' => auth()->user()->id
            ];
            $book = Book::create($data);
            $book->authors()->attach($request->auther_ids);
            $book->categories()->attach($request->category_ids);
            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            return response()->json([
                $errors], 400);
        }
    }

    public function payBook(Request $response, $id)
    {
        $book = (Book::find($id));
    }

    public function showAllBook()
    {
        return response()->json(Book::paginate(5));
    }

    public function showOneBook($id)
    {
        return response()->json(Book::find($id));
    }

    public function update($id, Request $request)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update($request->all());
            $book->authors()->attach($request->auther_ids);
            $book->categories()->attach($request->category_ids);
            return response()->json($book);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()], 204);
        }
    }

    public function delete($id)
    {
        Book::findOrFail($id)->delete();
        return response([
            "message" => "Book successfully deleted"
        ]);
    }

    public function showMyBook()
    {
        $userId = auth()->user()->id;
        $myBooks = Book::where('seller_id', '=', $userId)->paginate(5);

//        $books = Contact::with('books')->find(auth()->user()->id);
        return response()->json($myBooks, 201);
    }

    public function searchBook(Request $request)
    {
        $myBooks = Book::where('name', 'ILIKE', '%' . $request->keyword . '%')->paginate(5);
        return response()->json($myBooks);
    }

}


