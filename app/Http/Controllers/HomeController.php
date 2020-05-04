<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()->take(9)->get();

        return view('index', compact('products'));
    }

    public function category(ProductCategory $category, ProductCategory $childCategory = null, $childCategory2 = null)
    {
        $products = null;
        $ids = collect();
        $selectedCategories = [];

        if ($childCategory2) {
            $subCategory = $childCategory->childCategories()->where('slug', $childCategory2)->firstOrFail();
            $ids = collect($subCategory->id);
            $selectedCategories = [$category->id, $childCategory->id, $subCategory->id];
        } elseif ($childCategory) {
            $ids = $childCategory->childCategories->pluck('id');
            $selectedCategories = [$category->id, $childCategory->id];
        } elseif ($category) {
            $category->load('childCategories.childCategories');
            $ids = collect();
            $selectedCategories[] = $category->id;

            foreach ($category->childCategories as $subCategory) {
                $ids = $ids->merge($subCategory->childCategories->pluck('id'));
            }
        }

        $products = Product::whereHas('categories', function ($query) use ($ids) {
                $query->whereIn('id', $ids);
            })
            ->paginate(9);

        return view('index', compact('products', 'selectedCategories'));
    }
}
