<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Support\Responsable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Responsable
    {
        $products = Product::paginate(10);
        return new MessageResponse(
            body: [
                'products' => ProductResource::collection($products),
                'links' => [
                    'first' =>  $products->url(1),
                    'last' =>  $products->url($products->lastPage()),
                    'prev' =>  $products->previousPageUrl(),
                    'next' =>  $products->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ]
            ],
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product): Responsable
    {
        return new MessageResponse(
            body: [
                'product' =>  ProductResource::make($product),
            ],
        );
    }
}
