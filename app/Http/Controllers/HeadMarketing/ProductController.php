<?php

namespace App\Http\Controllers\HeadMarketing;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('brand', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->get();

        $error = null;

        if ($search && $products->isEmpty()) {
            $error = "Er is niets gevonden met de zoekopdracht: '{$search}'";
        }

        return view('dashboard.head-marketing.products.index', compact('products', 'error'));
    }


    public function create()
    {
        return view('dashboard.head-marketing.products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product aangemaakt');
    }


    public function show(Product $product)
    {
        return view('dashboard.head-marketing.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('dashboard.head-marketing.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product verwijderd');
    }
}
