<?php

namespace App\Http\Controllers\HeadMarketing;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Haal de zoekopdracht uit de request
        $search = $request->get('search');

        // Als een zoekopdracht is opgegeven, filter dan de producten op merk of beschrijving
        $products = Product::when($search, function ($query, $search) {
            return $query->where('brand', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->get();

        // Laad de view en geef de gefilterde producten door
        return view('dashboard.head-marketing.products.index', compact('products'));
    }


    public function create()
    {
        return view('dashboard.head-marketing.products.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if an image file is present in the request
        if ($request->hasFile('image')) {
            // Store the image in the 'public' disk in the 'product_images' directory
            $path = $request->file('image')->store('product_images', 'public');
            $validatedData['image'] = $path;
        }

        // Save the validated data into the products table
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
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->update($request->all());

        if ($request->hasFile('image')) {
            // Sla de nieuwe afbeelding op in de 'public' disk in de map 'product_images'
            $path = $request->file('image')->store('product_images', 'public');

            // Werk het pad van de afbeelding bij in de database
            $product->image = $path;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product verwijderd');
    }
}
