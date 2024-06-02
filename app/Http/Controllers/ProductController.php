<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductReqest;
use App\Models\Chapter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function createProduct()
    {
        $chapters = Chapter::with('categories')->get();
        return view('product.create', compact('chapters'));
    }
    public function createProductPost(CreateProductReqest $request)
    {
        // Handle file uploads
        $gallery = [];
        if($request->hasFile('gallery')) {
            foreach($request->file('gallery') as $file) {
                $path = $file->store('public/gallery');
                $gallery[] = Storage::url($path);
            }
        }

        // Create new product
        $product = Product::create([
            'userId' => Auth::id(),
            'chapterId' => $request->input('chapterId'),
            'categoryId' => $request->input('categoryId'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'state' => 1,
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'gallery' => json_encode($gallery), // Store as JSON
            'address' => $request->input('address'),
            'connectMethod' => $request->input('connectMethod'),
        ]);

        return redirect()->route('/');
    }


    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);

        return view('product.product', compact('product'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Проверка, является ли текущий пользователь владельцем товара
        if ($product->userId !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this product.');
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $chapters = Chapter::with('categories')->get();

        // Проверка, является ли текущий пользователь владельцем товара
        if ($product->userId !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this product.');
        }

        return view('product.edit', compact('product', 'chapters'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Проверка, является ли текущий пользователь владельцем товара
        if ($product->userId !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this product.');
        }

        // Валидация данных
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'address' => 'required',
            'description' => 'required',
            'gallery' => 'nullable',
            'gallery.*' => '',
            'type' => 'required',
            'connectMethod' => 'required',
            'chapterId' => 'required',
            'categoryId' => 'required'
        ]);

        // Обновление данных товара
        $product->name = $request->name;
        $product->price = $request->price;
        $product->address = $request->address;
        $product->description = $request->description;
        $product->type = $request->type;
        $product->connectMethod = $request->connectMethod;
        $product->chapterId = $request->chapterId;
        $product->categoryId = $request->categoryId;

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('gallery', 'public');
                $gallery[] = "/storage/{$path}";
            }
            $product->gallery = json_encode($gallery);
        }

        $product->save();

        return redirect()->route('user_products');
    }
}
