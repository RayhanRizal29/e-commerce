@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<body style="background-color: #eeeeee">

    <div >
        {{-- <div class="card"> --}}
            <div class="card-header"><h4>Edit Product</h4></div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="font-weight-bold" for="images">Gambar Produk</label>
                        <input class="form-control @error('images') is-invalid @enderror" type="file" name="images[]" id="images" multiple value="{{ old('images', $product->images)}}">
                            @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div id="image-preview" style="margin-top: 10px;">
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="font-weight-bold">Category</label>
                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Price</label>
                        <div>
                            <input id="name" name="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" autocomplete="price" autofocus>

                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Stock</label>
                        <div>
                            <input id="name" name="stock" type="number" class="form-control @error('name') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" autocomplete="stock" autofocus>

                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Description</label>
                        <div>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{!! old('description', $product->description) !!}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="is_published" class="font-weight-bold">Status</label>
                        <div>
                            <select id="is_published" class="form-control" name="is_published">
                                <option value="1" @selected(old('is_published', $product->is_published == 1))>Published</option>
                                <option value="0" @selected(old('is_published', $product->is_published == 0))>Not Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

<script>
    const fileInput = document.getElementById('images');
    const previewDiv = document.getElementById('image-preview');

    fileInput.addEventListener('change', function (event) {
        const files = event.target.files; // Ambil semua file yang dipilih
        previewDiv.innerHTML = ''; // Kosongkan preview sebelumnya

        Array.from(files).forEach((file, index) => {
            if (file) {
                // Buat elemen untuk setiap gambar
                const wrapper = document.createElement('div');
                wrapper.style.display = 'inline-block';
                wrapper.style.marginRight = '10px';
                wrapper.style.textAlign = 'center';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = `Preview Image ${index + 1}`;
                img.style.maxWidth = '100px';
                img.style.marginBottom = '5px';

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.type = 'button';
                removeButton.style.display = 'block';
                removeButton.style.backgroundColor = '#ff4d4d';
                removeButton.style.color = 'white';
                removeButton.style.border = 'none';
                removeButton.style.padding = '5px 10px';
                removeButton.style.cursor = 'pointer';
                removeButton.style.borderRadius = '3px';

                // Event listener untuk hapus gambar tertentu
                removeButton.addEventListener('click', function () {
                    const fileArray = Array.from(fileInput.files);
                    fileArray.splice(index, 1); // Hapus file dari array
                    const dataTransfer = new DataTransfer();
                    fileArray.forEach(file => dataTransfer.items.add(file)); // Tambahkan kembali file ke input
                    fileInput.files = dataTransfer.files;

                    // Update preview
                    previewDiv.innerHTML = '';
                    fileInput.dispatchEvent(new Event('change'));
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeButton);
                previewDiv.appendChild(wrapper);
            }
        });
    });

</script>
</body>

</html>
@endsection