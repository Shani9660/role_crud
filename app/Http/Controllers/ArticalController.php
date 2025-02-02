<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ArticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Artical::latest()->paginate(1);
        return view('artical.list',[
            'articles' => $articles
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artical.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3', 

        ]);

        if($validator->passes()){

            $artical = new Artical();
            $artical->title = $request->title;
            $artical->text = $request->text;
            $artical->author = $request->author;
            $artical->save();

            return redirect()->route('articals.index')->with('success', 'articals added successfully');
        }else{
            return redirect()->route('articals.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articles = Artical::find($id);
        return view('artical.edit',[
            'articles' => $articles
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $articles = Artical::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3', 

        ]);

        if($validator->passes()){

            $articles = new Artical();
            $articles->title = $request->title;
            $articles->text = $request->text;
            $articles->author = $request->author;
            $articles->save();

            return redirect()->route('articals.index')->with('success', 'Articals updated successfully');
        }else{
            return redirect()->route('articals.edit',$id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $articles = Artical::find($id);

        if ($articles === null) {
            session()->flash('error', 'Article not found');
            return response()->json([
                'status' => false
            ]);
        }
        $articles->delete();

        session()->flash('success', 'Article delete successfully');
        return response()->json([
            'status' => true
        ]);
        
    }
}
