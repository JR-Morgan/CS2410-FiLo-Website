<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemCreateRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Validation\Rule;
use App\Item;
use Auth;
use Gate;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $items = collect();
        $allItems = Item::all();
        $filterColumns = ['category', 'color'];
        $searchString = $request->input("searchString");

        foreach($allItems as $item)
        {
            $passesFilter = true;
            if($request->input("filter"))
            {
                foreach($filterColumns as $filterColumn)
                {
                    $passesFilter = $passesFilter && $request->input("{$filterColumn}_{$item->$filterColumn}");
                }
            }

            if($passesFilter
            &&(!$searchString || preg_match("/{$searchString}/i", $item->title)))
            {
                $items->push($item);
            }
        }

        $activeFilters = array();
        foreach($filterColumns as $filterColumn)
        {
            $activeFilters["{$filterColumn}"] = [];
            $ucfSuffix = ucfirst($filterColumn);
            foreach(config("enums.item{$ucfSuffix}") as $filter)
            {
                if(!$request->input("filter") || $request->input("{$filterColumn}_{$filter}"))
                {
                    array_push($activeFilters["{$filterColumn}"], "{$filter}");
                }
            }
        }

        return view('items.index', compact('items', 'activeFilters', 'searchString'));
    }

    public function create()
    {
        Gate::authorize('itemCreate');
        return view('items.create');
    }

    public function store(ItemCreateRequest $request)
    {
        $item = new Item;
        $item->title = $request->input('title');
        $item->category = $request->input('category');
        $item->found_userid = auth()->user()->id;
        $item->found_time = $request->input('found_time');
        $item->found_location = $request->input('found_location');
        $item->color = $request->input('color');
        $item->description = $request->input('description');
        $item->created_at = now();


        $images = "";
        $counter = 0;
        while($request->hasFile("image{$counter}"))
        {
            $fileNameWithExt = $request->file("image{$counter}")->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("image{$counter}")->getClientOriginalExtension();
            //TODO sanitise '%'
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file("image{$counter}")->storeAs('public/images', $fileNameToStore);
            $images = "{$images}{$fileNameToStore}|";

            $counter++;
        }
        //Removes the last | from the end of the string
        $images = substr($images, 0, -1);

        $item->image = $images;

        $item->save();
        // generate a redirect HTTP response with a success message
        return back()->with('success', 'Item has been added');
    }

    public function show($id)
    {
        $item = Item::find($id);
        if(!$item)
        {
            abort(404);
        }
        Gate::authorize('itemShowDetails', $item);
        return view('items.show',compact('item'));
    }

    public function edit(int $id)
    {
        $item = Item::find($id);
        if(!$item)
        {
            abort(404);
        }
        Gate::authorize('itemEdit', $item);
        return view('items.edit', compact('item'));
    }

    public function update(ItemUpdateRequest $request, $id)
    {
        $item = Item::find($id);
        if(!$item)
        {
            return back()->withErrors(["Cannot find item"]);
        }
        if(Gate::denies('itemCreate'))
        {
            return back()->withErrors(['Missing a required permission to edit item']);
        }

        $item->title = $request->input('title');
        $item->category = $request->input('category');
        $item->found_time = $request->input('found_time');
        $item->found_location = $request->input('found_location');
        $item->color = $request->input('color');
        $item->description = $request->input('description');
        $item->updated_at = now();


        $images = "";
        $counter = 0;
        while($request->hasFile("image{$counter}"))
        {
            $fileNameWithExt = $request->file("image{$counter}")->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("image{$counter}")->getClientOriginalExtension();
            //TODO sanitise '%'
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file("image{$counter}")->storeAs('public/images', $fileNameToStore);
            $images = "{$images}{$fileNameToStore}|";

            $counter++;
        }
        //Removes the last | from the end of the string
        $images = substr($images, 0, -1);

        $item->image = $images;

        //Handles the uploading of the image
        $item->save();
        return redirect()->back()->with('success','Item has been updated');
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if(!$item)
        {
            abort(400, "Cannot process request: Item was not found");
        }
        if(Gate::denies('itemDelete', $item))
        {
            return back()->withErrors(['Missing a required permission to delete this item']);
        }
        $item->delete();
        return redirect('items')->with('success','Item has been deleted');
    }
}
