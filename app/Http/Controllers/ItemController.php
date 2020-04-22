<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Auth;
use Gate;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all()->toArray();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('itemCreate');
        return view('items.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Gate::denies('itemCreate'))
        {
            return back()->withErrors(['Missing a required permission to create item']);
        }
        // form validation
        $item = $this->validate(request(), [
            'found_time' => 'required|date',
            'found_location' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);
        //Handles the uploading of the image
        if ($request->hasFile('image'))
        {
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Just gets the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Gets thefilename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Uploads the image
            $path =$request->file('image')->storeAs('public/images', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'noimage.jpg';
        }
        // create a Vehicle object and set its values from the input
        $item = new Item;
        $item->category = $request->input('category');
        $item->found_userid = auth()->user()->id;;
        $item->found_time = $request->input('found_time');
        $item->found_location = $request->input('found_location');
        $item->color = $request->input('color');
        $item->image = $fileNameToStore;
        $item->description = $request->input('description');
        $item->created_at = now();

        // save the Vehicle object
        $item->save();
        // generate a redirect HTTP response with a success message
        return back()->with('success', 'Item has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        Gate::authorize('itemShowDetails', $item);
        return view('items.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        Gate::authorize('itemEdit', $item);
        return view('items.edit',compact('item'));
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

        $item = Item::find($id);
        if(Gate::denies('itemEdit', $item))
        {
            return back()->withErrors(['Missing a required permission to edit this item']);
        }
        $this->validate(request(), [
            'found_location' => 'required',
            'found_time' =>'required'
        ]);
        $item->category = $request->input('category');
        $item->found_time = $request->input('found_time');
        $item->found_location = $request->input('found_location');
        $item->color = $request->input('color');
        $item->description = $request->input('description');
        $item->updated_at = now();
        //Handles the uploading of the image
        if ($request->hasFile('image'))
        {
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Just gets the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Gets the filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Uploads the image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'noimage.jpg';
        }
        $item->image = $fileNameToStore;
        $item->save();
        return redirect('items')->with('success','Item has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);$item->delete();
        if(Gate::denies('itemDelete', $item))
        {
            return back()->withErrors(['Missing a required permission to delete this item']);
        }
        return redirect('items')->with('success','Item has been deleted');
    }
}
