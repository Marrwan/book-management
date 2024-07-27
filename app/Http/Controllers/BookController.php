<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return Inertia::render('Books/Index', ['books' => $books]);
    }

    public function create()
    {
        return Inertia::render('Books/Create');
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'published_year' => 'required|integer|between:1900,2099',
        'genre' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
//         return response()->json($validator->errors(), 422);
        // return Inertia::render('Books/Create', [
        //         'errors' => $validator->errors(),
        //         'book' => $request->all(),
        //     ]);
        return redirect()->route('books.create')->with('flash', [
            'message' => 'Book updated successfully!',
            'error' => $validator->errors(),
            'type' => 'error'
        ]);
    }

        Book::create($request->all());
        return redirect()->route('books.index')->with('flash',['message' => 'Book added successfully!', 'type'=> 'success']);
        // Inertia::render('Books/Index', , 200);
    }


    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', ['book' => $book]);
    }

    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [ 
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'published_year' => 'required|integer|between:1900,2099',
        'genre' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('flash', [
                'message' => 'Validation errors occurred.',
                'type' => 'error'
            ]);
            
        // return response()->json(['errors' => $validator->errors()], 422);
        // return Inertia::render('Books/Edit', [
        //     'book' => $request->all(),
        //     'errors' => $validator->errors(),
        // ])->with('error', 'Validation errors occurred.');
       
    }
    Log::info($request);
    // Update the book
    // $book = Book::findOrFail($id);
    $book->update($request->all());

    // return redirect()->route('books.index')->with('success_message', 'Book updated successfully!');
    // return response()->json(['message' => 'Book updated successfully!'], 200);
    return redirect()->route('books.index')->with('flash', [
        'message' => 'Book updated successfully!',
        'type' => 'success'
    ]);
    }

    public function destroy(Book $book)
    {
        Log::info($book);
        $book->delete();
        return redirect()->route('books.index');
    }
}
