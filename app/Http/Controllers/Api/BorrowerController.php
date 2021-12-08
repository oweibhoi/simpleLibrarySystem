<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Borrower as BorrowerResource;
use App\Borrower;
use Illuminate\Support\Facades\Validator;


class BorrowerController extends BaseController
{

    public function index()
    {
        $borrower = Borrower::all();
        return $this->handleResponse(BorrowerResource::collection($borrower), 'Borrower have been retrieved!');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'fullname' => 'required',
            'phone_no' => 'required|min:9',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        $borrower = Borrower::create($input);
        return $this->handleResponse(new BorrowerResource($borrower), 'Borrower created!');
    }


    public function show($id)
    {
        $borrower = Borrower::find($id);
        if (is_null($borrower)) {
            return $this->handleError('Borrower not found!');
        }
        return $this->handleResponse(new BorrowerResource($borrower), 'Borrower retrieved.');
    }


    public function update(Request $request, Borrower $borrower)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'fullname' => 'required',
            'phone_no' => 'required|max:9',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $borrower->fullname = $input['fullname'];
        $borrower->phone_no = $input['phone_no'];
        $borrower->email = $input['email'];
        $borrower->save();

        return $this->handleResponse(new BorrowerResource($borrower), 'Borrower successfully updated!');
    }

    public function destroy(Borrower $borrower)
    {
        $borrower->delete();
        return $this->handleResponse([], 'Borrower deleted!');
    }
}
