<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // GET /products
    public function index(Request $request)
    {
        $query = Product::with('user:id,name,email');

        // pencarian berdasarkan nama: GET /api/products?name=phone
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // filter harga minimum: GET /api/products?max_price=500
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // filter harga maksimum: GET /api/products?max_price=500
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // sorting harga asc/desc: GET /api/products?sort=asc
        if ($request->has('sort') && in_array(strtolower($request->sort), ['asc', 'desc'])) {
            $query->orderBy('price', $request->sort);
        }

        // kombinasi GET /api/products?min_price=100&max_price=500
        // kombinasi GET /api/products?name=laptop&min_price=2000&sort=desc

        // Ambil hasil
        $products = $query->get();

        return response()->json($products);
    }


    // GET /products/{id}
    public function show(Product $product)
    {
        return $product->load('user:id,name,email');
    }

    // POST /products
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'product' => $product
        ], 201);
    }

    // PUT /products/{id}
    public function update(Request $request, Product $product)
    {
        // cek kepemilikan product
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Tidak punya akses'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'product' => $product
        ]);
    }

    // DELETE /products/{id}
    public function destroy(Product $product)
    {
        // cek kepemilikan product
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Tidak punya akses'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}

