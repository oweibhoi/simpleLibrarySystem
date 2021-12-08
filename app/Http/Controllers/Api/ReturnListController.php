<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ReturnList as ReturnListResource;
use App\BorrowList;
use Illuminate\Support\Facades\Validator;


class ReturnListController extends BaseController
{

    public function index()
    {
        $returnList = BorrowList::join('books', 'books.id', '=', 'borrow_lists.bookID')
            ->join('borrowers', 'borrowers.ID', '=', 'borrow_lists.borrowerID')
            ->where('borrow_lists.isReturn', 1)
            ->get(['borrow_lists.*', 'books.title', 'borrowers.fullname']);

        return $this->handleResponse(ReturnListResource::collection($returnList), 'Return list have been retrieved!');
    }

    public function show($id)
    {
        $returnList = BorrowList::join('books', 'books.id', '=', 'borrow_lists.bookID')
            ->join('borrowers', 'borrowers.ID', '=', 'borrow_lists.borrowerID')
            ->where('borrow_lists.isReturn', 1)
            ->get(['borrow_lists.*', 'books.title', 'borrowers.fullname'])
            ->find($id);

        if (is_null($returnList)) {
            return $this->handleError('Return transaction not found!');
        }
        return $this->handleResponse(new ReturnListResource($returnList), 'Return transaction retrieved.');
    }


    public function return($id)
    {
        $borrowList = BorrowList::find($id);

        if ($borrowList->isReturn > 0) {
            return $this->handleError('Not allowed. Book is already returned');
        }

        $borrowList->isReturn = 1;
        $borrowList->save();

        return $this->handleResponse(new ReturnListResource($borrowList), 'Borrowed book successfully returned!');
    }
}
