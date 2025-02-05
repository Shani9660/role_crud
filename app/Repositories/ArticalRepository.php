<?php

namespace App\Repositories;

use App\Models\Artical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticalRepository implements ArticalRepositoryInterface
{
    public function index(int $perPage)
    {
        return Artical::latest()->paginate($perPage);
    }
    
    public function create(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3', 
        ]);

        // If validation fails, return the validator instance
        if ($validator->fails()) {
            return $validator;
        }

        // Create a new article
        $artical = new Artical();
        $artical->title = $request->title;
        $artical->text = $request->text;
        $artical->author = $request->author;
        $artical->save();

        return $artical;
    }

    public function edit(string $id)
    {
        return Artical::find($id);
    }

    public function update(Request $request, string $id)
    {
        $article = Artical::find($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3', 
        ]);

        // If validation fails, return the validator instance
        if ($validator->fails()) {
            return $validator;
        }

        // Update the article details
        $article->title = $request->title;
        $article->text = $request->text;
        $article->author = $request->author;
        $article->save();

        return $article;
    }

    public function destroy(string $id)
    {
        $article = Artical::find($id);
        if ($article !== null) {
            $article->delete();
            return true;
        }
        return false;
    }
}
