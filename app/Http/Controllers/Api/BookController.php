<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Book as BookResource;
use App\Book;
use Illuminate\Support\Facades\Validator;


class BookController extends BaseController
{

    public function index()
    {
        $books = Book::all();
        return $this->handleResponse(BookResource::collection($books), 'Books have been retrieved!');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'authors' => 'required',
            'publisher' => 'required',
            'published_date' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        $book = Book::create($input);
        return $this->handleResponse(new BookResource($book), 'Book created!');
    }


    public function show($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->handleError('Book not found!');
        }
        return $this->handleResponse(new BookResource($book), 'Book retrieved.');
    }


    public function update(Request $request, Book $book)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'authors' => 'required',
            'publisher' => 'required',
            'published_date' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $book->title = $input['title'];
        $book->description = $input['description'];
        $book->authors = $input['authors'];
        $book->publisher = $input['publisher'];
        $book->published_date = $input['published_date'];
        $book->save();

        return $this->handleResponse(new BookResource($book), 'Book successfully updated!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return $this->handleResponse([], 'Book deleted!');
    }
}
