<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get all products.
     */
    public function getdata()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Add a new product.
     */
    public function addProduct(StoreProductRequest $request)
    {
        $data = $request->validated();
        // Map the IDs correctly for the internal model
        $data['Supercategory_id'] = $data['supcategory_id'];
        
        $product = $this->productService->createProduct($data, $request->file('image'));

        return response()->json([
            'code' => 1,
            'message' => 'Details Saved Successfully!',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Fetch standard trendy products.
     */
    public function getTrendydata()
    {
        return ProductResource::collection(Product::trendy()->latest()->take(8)->get());
    }

    /**
     * Fetch new arrivals.
     */
    public function getjustarriveddata()
    {
        return ProductResource::collection(Product::justArrived()->latest()->take(8)->get());
    }

    /**
     * Delete a product.
     */
    public function deletedata(Request $request)
    {
        $product = Product::find($request->id);
        if ($product && $product->delete()) {
            return response()->json(['code' => 1, 'message' => 'Details Deleted Successfully!']);
        }
        return response()->json(['code' => 2, 'message' => 'Error while Deleting Details!']);
    }

    /**
     * Fetch specific details.
     */
    public function fetchproductdetails($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([new ProductResource($product)]); // Kept array format for frontend compatibility
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    /**
     * Category wise fetching.
     */
    public function fetchProductCategoryWise(Request $request)
    {
        $products = Product::where('Supercategory_id', $request->category)->get();
        return ProductResource::collection($products);
    }

    /**
     * Get product counts for categories.
     */
    public function countProduct()
    {
        return response()->json($this->productService->getCategoryCounts());
    }

    // --- CART LOGIC (Kept largely as is for now, but used Eloquent) ---

    public function addToCart(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');
        $userId = $request->input('userId');

        $userId = ($userId !== null && $userId !== 'null') ? $userId : null;

        $cart = Cart::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            ['quantity' => DB::raw("quantity + $quantity")]
        );

        return response()->json(['code' => 1, 'message' => 'Product added to cart successfully!']);
    }

    public function fetchCartDetails(Request $request, $userId)
    {
        $userId = ($userId === "null") ? null : $userId;

        $cartDetails = Cart::where('user_id', $userId)->get();
        $result = [];

        foreach ($cartDetails as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $result[] = [
                    'user_id' => $cartItem->user_id,
                    'cart_id' => $cartItem->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $product->price * $cartItem->quantity,
                    'product_image' => $product->product_image
                ];
            }
        }

        return [
            'cart_items' => $result,
            'cart_item_count' => count($result),
        ];
    }

    // --- RE-IMPLEMENTING FILTER LOGIC ---
    public function fetchProductFilterWise(Request $request)
    {
        $query = Product::query();
        $requestData = $request->all();

        foreach ($requestData as $filter) {
            if (!isset($filter['key'])) continue;

            switch ($filter['key']) {
                case 'priceFilter':
                    if ($filter['value'] !== 'all') {
                        list($min, $max) = explode('-', $filter['value']);
                        $query->whereBetween('price', [$min, $max]);
                    }
                    break;
                case 'colorFilter':
                    if ($filter['value'] !== 'all') $query->where('color', $filter['value']);
                    break;
                case 'sizeFilter':
                    if ($filter['value'] !== 'all') $query->where('size', $filter['value']);
                    break;
                case 'subcategory':
                    if (isset($filter['subcategory'])) $query->where('category_id', $filter['subcategory']);
                    break;
            }
        }

        // Apply category filter if present
        foreach ($requestData as $filter) {
            if ($filter['key'] === 'category_id' && isset($filter['category'])) {
                $query->whereIn('Supercategory_id', (array)$filter['category']);
            }
        }

        return ProductResource::collection($query->get());
    }

    /**
     * Handle order placement.
     */
    public function checkoutFormdata(Request $request)
    {
        $data = $request->input('formDataToSend');

        if (!$data) {
            return response()->json(['code' => 2, 'message' => 'Missing order data'], 400);
        }

        // Validate checkout data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'payment' => 'required|string',
            'userid' => 'required',
            'product_id' => 'required|string',
            'product_name' => 'required|string',
            'product_price' => 'required|string',
            'product_quantity' => 'required|string',
            'product_subtotal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 2,
                'message' => 'Please fill all required fields: ' . $validator->errors()->first()
            ], 400);
        }

        // Generate a unique Order ID
        $data['orderid'] = 'ORD-' . strtoupper(Str::random(10));

        try {
            DB::beginTransaction();
            
            // Create the order
            $order = Order::create($data);

            // Clear the cart for this user
            if (isset($data['userid']) && $data['userid']) {
                Cart::where('user_id', $data['userid'])->delete();
            }

            DB::commit();

            return response()->json([
                'code' => 1,
                'message' => 'Order Placed Successfully!',
                'orderid' => $data['orderid']
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json([
                'code' => 2, 
                'message' => 'Error while placing order: ' . $e->getMessage()
            ], 500);
        }
    }
}
