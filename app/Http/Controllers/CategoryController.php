<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category ::paginate(5);

        return view('categories.index', compact('categories'));
    }

    public function getData(Request $request)
    {
        $categories = Category::select('categories.*');

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return '
                    <div class="d-flex">
                    <a href="' . route('categories.edit', $category->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fa fa-pencil-alt"></i></a>

                        <form onsubmit="return confirm(\'Apakah Anda Yakin ?\');" action="' . route('categories.destroy', $category->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();
        // return view('categories.create');
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

       Category::create($validatedData);

        return to_route('categories.index')->with('success', 'categories created successfully');
    }
    // public function detail($id)
    // {
    //     $categories = Category::find($id);
    //     return view('categories.detail', compact('categories'));
    // }

    public function edit($id)
    {
        $categories = Category::find($id);

        return view('categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $categories = Category::find($id);

        $categories->update($validatedData);

        return to_route('categories.index')->with('success', 'categorie updated successfully');
    }

    public function destroy($id)
    {
        $categorie = Category::find($id);

        // delete image
        Storage::delete('public/' . $categorie->cover_image);

        $categorie->delete();

        return back()->with('success', 'categorie deleted successfully');
    }
}
