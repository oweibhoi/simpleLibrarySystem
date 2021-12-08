<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\BorrowList as BorrowListResource;
use App\BorrowList;
use Illuminate\Support\Facades\Validator;


class BorrowListController extends BaseController
{

    public function index()
    {
        $borrowList = BorrowList::join('books', 'books.id', '=', 'borrow_lists.bookID')
            ->join('borrowers', 'borrowers.ID', '=', 'borrow_lists.borrowerID')
            ->where('borrow_lists.isReturn', 0)
            ->get(['borrow_lists.*', 'books.title', 'borrowers.fullname']);

        return $this->handleResponse(BorrowListResource::collection($borrowList), 'Borrow list have been retrieved!');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'bookID' => 'required',
            'borrowerID' => 'required',
            'borrowed_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        $input['isReturn'] = 0;
        $borrowlist = BorrowList::create($input);
        return $this->handleResponse(new BorrowListResource($borrowlist), 'Borrowed transaction created!');
    }


    public function show($id)
    {
        $borrowList = BorrowList::join('books', 'books.id', '=', 'borrow_lists.bookID')
            ->join('borrowers', 'borrowers.ID', '=', 'borrow_lists.borrowerID')
            ->where('borrow_lists.isReturn', 0)
            ->get(['borrow_lists.*', 'books.title', 'borrowers.fullname'])
            ->find($id);

        if (is_null($borrowList)) {
            return $this->handleError('Borrowed transaction not found!');
        }
        return $this->handleResponse(new BorrowListResource($borrowList), 'Borrowed transaction retrieved.');
    }


    public function update(Request $request, BorrowList $borrowList)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'bookID' => 'required',
            'borrowerID' => 'required',
            'borrowed_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $borrowList->bookID = $input['bookID'];
        $borrowList->borrowerID = $input['borrowerID'];
        $borrowList->borrowed_date = $input['borrowed_date'];
        $borrowList->save();

        return $this->handleResponse(new BorrowListResource($borrowList), 'Borrowed transaction successfully updated!');
    }

    public function destroy(BorrowList $borrowList)
    {
        $borrowList->delete();
        return $this->handleResponse([], 'Borrowed transaction deleted!');
    }
}
