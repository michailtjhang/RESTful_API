<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index() 
    {
        $books = Book::all();

        return BookResource::collection($books);
    }

    public function show($id) 
    {
        $book = Book::findOrFail($id);

        return new BookResource(true, 'Detail Book', $book);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'author'=> 'required',
            'pages'=> 'required',
            'description'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 442);
        }

        $book = Book::create([
             'title' => $request->title,
             'author' => $request->author,
             'pages' => $request->pages,
             'description' => $request->description,
        ]);
        
        return new BookResource(true, 'Data Book berhasil Ditambahkan', $book);
    }

    public function update(Request $request, String $id)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'author'=> 'required',
            'pages'=> 'required',
            'description'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 442);
        }

        $book = DB::table('books')->where('id', $id)->update([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'pages' => $request->input('pages'),
            'description' => $request->input('description'),
       ]);

       return new BookResource(true, 'Data Book berhasil Diubah', $book);
    }

    public function destroy(String $id)
    {
        $book = DB::table('books')->where('id', $id);
        $book->delete();
        
        return new BookResource(true, 'Data Book berhasil Dihapus', $book);
    }
}
