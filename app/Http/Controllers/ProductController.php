<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::with('category')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function getData(Request $request)
    {
        $products = Product::with('category')->select('products.*');

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function ($product) {
                return $product->category->name ?? 'No Category';
            })
            ->addColumn('is_published', function ($product) {
                return $product->is_published ? 'Published' : 'Not Published';
            })
            ->addColumn('action', function ($product) {
                return '
                    <div class="d-flex">
                        <a href="' . route('products.detail', $product->id) . '" class="btn btn-sm btn-dark mr-2"><i class="fa fa-eye"></i></a>
                        <a href="' . route('products.edit', $product->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fa fa-pencil-alt"></i></a>
                        <form onsubmit="return confirm(\'Apakah Anda Yakin ?\');" action="' . route('products.destroy', $product->id) . '" method="POST">
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
        
        return view('products.create', compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $validatedData = $request->validate([
    //         'cover_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    //         'name' => ['required', 'string', 'max:255'],
    //         'description' => ['required', 'string'],
    //         'is_published' => ['required', 'boolean'],
    //         'category_id' => ['required', 'exists:categories,id'],
    //         'price' => ['required', 'numeric', 'min:0'],
    //         'stock' => ['required', 'integer', 'min:0'],
    //     ]);

    //     $validatedData['cover_image'] = $request->file('cover_image')->store('images', 'public');
    //     Product::create($validatedData);

    //     return to_route('products.index')->with('success', 'products created successfully');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:100',
            'is_published' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'description.required' => 'Description is required.',
            'is_published.boolean' => 'Publish status must be true or false.',
            'category_id.exists' => 'Selected category is invalid.',
            'price.numeric' => 'Price must be a valid number.',
            'stock.integer' => 'Stock must be an integer.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.max' => 'Each image must not exceed 2MB.',
        ]);

        // Simpan data produk
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id, 
            'is_published' => $request->is_published, 
            'stock' => $request->stock, 
        ]);

        // Simpan gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }
    public function detail($id)
    {
        $product = Product::with('images')->findOrFail($id);
        

        return view('products.detail', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:100',
            'is_published' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'description.required' => 'Description is required.',
            'is_published.boolean' => 'Publish status must be true or false.',
            'category_id.exists' => 'Selected category is invalid.',
            'price.numeric' => 'Price must be a valid number.',
            'stock.integer' => 'Stock must be an integer.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.max' => 'Each image must not exceed 2MB.',
        ]);
        

        $product = Product::find($id);

        $removedImages = $request->input('removed_images', []); // ID gambar yang dihapus
    if (!empty($removedImages)) {
        foreach ($removedImages as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image) {
                // Hapus file dari storage
                Storage::delete($image->image_path);
                // Hapus dari database
                $image->delete();
            }
        }
    }

    // Simpan gambar baru
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('product-images', 'public');

            // Simpan ke database
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);
        }
    }

    // Update data produk
    $product->update($validatedData);


    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');

    }

    public function destroy($id)
    {
        $product = Product::find($id);

        // delete image
        Storage::delete('public/' . $product->cover_image);

        $product->delete();

        return back()->with('success', 'product deleted successfully');
    }

    // Search by Category
    public function getByCategory($category)
    {

        $category = Category::where('name', $category)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $products = Product::where('category_id', $category->id)->get();

        return response()->json($products);
    }
}
