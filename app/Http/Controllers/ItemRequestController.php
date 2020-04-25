<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemRequest;
use App\Item;
use Auth;
use Gate;

class ItemRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('itemRequestViewAll');
        $itemRequests = ItemRequest::all()->toArray();
        return view('itemRequests.index', compact('itemRequests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itemRequest = ItemRequest::find($id);
        if(!$itemRequest)
        {
            abort(404);
        }
        Gate::authorize('itemRequestShow', $itemRequest);
        return view('itemRequests.show', compact('itemRequest'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item = Item::find($request->input('itemId'));
        if(!$item)
        {
            abort(400);
        }
        Gate::authorize('itemRequestCreate', $item);
        return view('itemRequests.create', compact('item'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function approve(int $itemRequestId)
    {
        return $this->judge($itemRequestId, 'approved');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reject(int $itemRequestId)
    {
        return $this->judge($itemRequestId, 'rejected');
    }

    /**
     * @param Request $request
     * @param String $state
     * @return \Illuminate\Http\Response
     */
    private function judge(int $itemRequestId, String $state)
    {
        $itemRequest = ItemRequest::find($itemRequestId);
        Gate::authorize('itemRequestJudge', $itemRequest);

        if(!$itemRequest)
        {
            $lable = $itemRequestId ? $itemRequestId : 'null';
            abort(400, "Cannot process request: ItemRequest \"{$lable}\" was not found");
        }
        else if (! in_array($state, config('enums.itemRequestStates')))
        {
            abort(400, "Cannot process request: The requested itemRequest state \"{$state}\" is not recognised");
        }
        else if($itemRequest->state != 'open')
        {
            abort(400, "Cannot process request: ItemRequest {$itemRequestId} can not be set to state \"{$state}\" as is not currently open");
        }


        $itemRequest->state = $state;
        $itemRequest->updated_at = now();

        $itemRequest->save();

        return redirect()->action('ItemRequestController@show', [$itemRequest->id]);

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $item = Item::find($request->itemId);
        if($item) {
            if(Gate::denies('itemRequestCreate', $item))
            {
                return back()->withErrors(['Missing a required permission to create item request']);
            }
            // form validation
            $itemRequest = $this->validate(request(), [
                'message' => 'required',
            ]);

            // create a Vehicle object and set its values from the input
            $itemRequest = new ItemRequest;
            $itemRequest->claim_userid = auth()->user()->id;
            $itemRequest->item_id = $request->itemId;
            $itemRequest->message = $request->input('message');
            $itemRequest->created_at = now();

            // save the Vehicle object
            $itemRequest->save();
            // generate a redirect HTTP response with a success message
            return back()->with('success', 'Item request has been added');
        }
        else
        {
            return back()->withErrors(["Cannot find item {$request->item_id}"]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemRequest = ItemRequest::find($id);
        Gate::authorize('itemRequestEdit', $itemRequest);
        return view('itemRequests.edit',compact('itemRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $itemRequest = ItemRequest::find($id);
        if(Gate::denies('requestEdit', $itemRequest))
        {
            return back()->withErrors(['Missing a required permission to edit this item request']);
        }

        $itemRequest->message = $request->input('message');
        $itemRequest->updated_at = now();

        $itemRequest->save();
        return redirect("itemrequests/{$itemRequest->id}")->with('success','Item request has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemRequest = ItemRequest::find($id);
        if(Gate::denies('requestDelete', $itemRequest))
        {
            return back()->withErrors(['Missing a required permission to delete this item request']);
        }
        $itemRequest->delete();
        return redirect('itemrequests')->with('success','Request has been deleted');
    }
}
