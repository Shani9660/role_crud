<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArticalRepositoryInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
         return[
            new Middleware('permission:view articals', only: ['index']),
            new Middleware('permission:edit articals', only: ['edit']),
            new Middleware('permission:create articals', only: ['create']),
            new Middleware('permission:destory articals', only: ['destroy']),

         ];
    }
    protected $articalRepository;

   
    public function __construct(ArticalRepositoryInterface $articalRepository)
    {
        $this->articalRepository = $articalRepository;
    }

    public function index()
    {
        $articles = $this->articalRepository->index(10);
        return view('artical.list', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return view('artical.create');
    }

    public function store(Request $request)
    {
        $articles = $this->articalRepository->create($request);

        if ($articles instanceof \Illuminate\Support\Facades\Validator) {
            return redirect()->route('articals.create')->withInput()->withErrors($articles);
        }

        return redirect()->route('articals.index')->with('success', 'Article added successfully');
    }

    public function edit(string $id)
    {
        $articles  = $this->articalRepository->edit($id);
        if (!$articles ) {
            session()->flash('error', 'Article not found');
            return redirect()->route('articals.index');
        }

        return view('artical.edit', [
            'articles' => $articles 
        ]);
    }

    public function update(Request $request, string $id)
    {
        $articles = $this->articalRepository->update($request, $id);

        if ($articles instanceof \Illuminate\Support\Facades\Validator) {
            return redirect()->route('articals.edit', $id)->withInput()->withErrors($articles);
        }

        return redirect()->route('articals.index')->with('success', 'Article updated successfully');
    }

    public function destroy(Request $request)
    {
        $deleted = $this->articalRepository->destroy($request->id);

        if ($deleted) {
            session()->flash('success', 'Article deleted successfully');
            return response()->json(['status' => true]);
        } else {
            session()->flash('error', 'Article not found');
            return response()->json(['status' => false]);
        }
    }
}

