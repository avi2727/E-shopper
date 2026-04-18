<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Validation\Rule;
use DB;
class ProductController extends Controller
{
    public function index(){
        echo "index funnction";
    }

    public function addProduct(Request $request)
    {
      //dd($request->all());  
    $json = [];
    $validatedData = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|string|max:10',
        'availability' => 'required',
        'trandy' => 'required',
        'justArrived' => 'required',
        'category_id' => 'required',
        'size' => 'required',
        'color' => 'required',
        'information' => 'required',
        'location' => 'required|string',
        'supcategory_id' => 'required|max:10',
    ]);
    $uploadpath = public_path('images');
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $imagePath = $image->storeAs('productImages', $imageName, 'public');
    if (!$imagePath) {
        return redirect()->back()->with('error', 'Image upload failed.');
    }
    $productData = [
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
        'price' => $validatedData['price'],
        'availability' => $validatedData['availability'],
        'category_id' => $validatedData['category_id'],
        'location' => $validatedData['location'],
        'size' => $validatedData['size'],
        'color' => $validatedData['color'],
        'information' => $validatedData['information'],
        'Supercategory_id' => $validatedData['supcategory_id'],
        'trandy' => $validatedData['trandy'],
        'justArrived' => $validatedData['justArrived'],
        'product_image' => $imagePath, 
    ];
    $productModel = new Product();
    $result = $productModel->addProduct($productData);

    if ($result) {
        $json['code'] = 1;
        $json['message'] = 'Details Saved Successfully!';
    } else {
        $json['code'] = 2;
        $json['message'] = 'Error While Saving Details!';
    }

    return response()->json($json);
}
 public function getdata(Product $users)
    {
       $productModel = new Product();
       $data=$productModel->getProduct();
       return response()->json($data);
    }
    public function deletedata(Request $request){
        $json=array();
        $productModel = new Product();
        $id = $request->id;
        $resultt =  $productModel->deleteData($id);
        if($resultt){
            $json['code']= 1;
            $json['message']= 'Details Deleted Successfully!';
          }else{
            $json['code']= 2;
            $json['message']= 'Error while Deleting Details!';
          }
           return response()->json($json);
    }
   
    public function updatedata(Request $request)
    {
    $json = [];
    $id = $request->id;

    // Define custom error messages for validation
    // $customMessages = [
    //     'name.required' => 'The name field is required.',
    //     'name.max' => 'The name field must not exceed 255 characters.',
    //     'email.required' => 'The email field is required.',
    //     'email.email' => 'Please provide a valid email address.',
    //     'email.unique' => 'The provided email address is already in use.',
    //     'contact.required' => 'The contact field is required.',
    //     'contact.max' => 'The contact field must not exceed 10 characters.',
    //     'image.image' => 'Please upload a valid image (jpeg, png, jpg, gif).',
    //     'image.mimes' => 'Please upload an image in jpeg, png, jpg, or gif format.',
    //     'image.max' => 'The image size should not exceed 2048 kilobytes.',
    // ];

    // Use the Validator class to perform the validation
    $validator = Validator::make($request->all(), [
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|string|max:10',
        'availability' => 'required',
        'trandy' => 'required',
        'justArrived' => 'required',
        'category_id' => 'required',
        'size' => 'required',
        'color' => 'required',
        'information' => 'required',
        'location' => 'required|string',
        'supcategory_id' => 'required|max:10',
    ]);


    // Check if validation fails
    if ($validator->fails()) {
        $json['code'] = 2;
        $json['message'] = $validator->errors()->first();
        return response()->json($json, 400); // Return with 400 Bad Request status code
    }

    // Validation successful, proceed to update data
    $productModel = new Product();
    $productData = [
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
        'availability' => $request->input('availability'),
        'category_id' => $request->input('category_id'),
        'location' => $request->input('location'),
        'size' => $request->input('size'),
        'color' => $request->input('color'),
        'information' => $request->input('information'),
        'Supercategory_id' => $request->input('supcategory_id'),
        'trandy' => $request->input('trandy'),
        'justArrived' => $request->input('justArrived'),
    ];

    // Handle image update if provided in the request
    if ($request->hasFile('image')) {
        $uploadPath = public_path('images');
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $imagePath = $image->storeAs('productImages', $imageName, 'public');
        if (!$imagePath) {
            $json['code'] = 2;
            $json['message'] = 'Image upload failed.';
            return response()->json($json, 500); // Return with 500 Internal Server Error status code
        }
        $productData['product_image'] = $imagePath;
    }

    // Update student data in the database
    $result = $productModel->updateProduct($id, $productData);

    // Check if the image was updated successfully
    if ($request->hasFile('image') && !$result) {
        $json['code'] = 2;
        $json['message'] = 'Error While Updating Image!';
        return response()->json($json, 500); // Return with 500 Internal Server Error status code
    }

    if ($result) {
        $json['code'] = 1;
        $json['message'] = 'Details Updated Successfully!';
    } else {
        $json['code'] = 2;
        $json['message'] = 'Error While Updating Details!';
    }

    return response()->json($json);
}
public function fetchproductdetails($id)
{
   
    // $product = Product::find($id);
    $productModel = new Product();
       $data=$productModel->getProductdetails($id);

    if ($data) {
        return response()->json($data); 
    } else {
        return response()->json(['error' => 'Product not found'], 404);
    }
}

    public function getTrendydata()
    {
       $productModel = new Product();
       $data=$productModel->getTrendyProduct();
       return response()->json($data);
    }
    public function getjustarriveddata()
    {
       $productModel = new Product();
       $data=$productModel->getjustarrivedProduct();
       return response()->json($data);
    }
    public function fetchProductCategoryWise(Request $request)
    {
       $productModel = new Product();
       $data=$productModel->getproductCategoryWise($request->category);
       return response()->json($data);
    }
    public function countProduct()
    {
       $productModel = new Product();
       $data=$productModel->getproductCount();
       return response()->json($data);
    }
    public function fetchProductFilterWise(Request $request)
    {
        $requestData = $request->request->all();
        $productModel = new Product();
        $filteredProducts = $productModel->getProductPriceWise($requestData);
        return response()->json($filteredProducts);
    }
    // public function addToCart(Request $request)
    // {
    //    // dd($request->all());
    //     $productId = $request->input('productId');
    //     $quantity = $request->input('quantity');
    //     $userId =  $request->input('userId');
    //    // dd($user);
    //    if ($userId === "null") {
    //     $userId = null;
    // }else{
    //     $userId =  $userId;
    // }
    
    //     // Check if a cart entry with the same product_id already exists for the user
    //     $existingCart = Cart::where('user_id', $userId)
    //                          ->where('product_id', $productId)
    //                          ->first();
    
    //     if ($existingCart) {
    //         // If the same product is already in the cart, update the quantity
    //         $existingCart->quantity += $quantity;
    //         $existingCart->save();
    
    //         $json['code'] = 1;
    //         $json['message'] = 'Product quantity updated in the cart!';
    //         return response()->json($json, 200); // HTTP 200 OK for success
    //     } else {
    //         // If the product is not in the cart, create a new entry
            
    //         $cart = new Cart([
    //             'user_id' => $userId,        // Set the user ID here
    //             'product_id' => $productId,
    //             'quantity' => $quantity,
    //         ]);
    
    //         if ($cart->save()) {
    //             $json['code'] = 1;
    //             $json['message'] = 'Product added to cart successfully!';
    //             return response()->json($json, 200); // HTTP 200 OK for success
    //         } else {
    //             $json['code'] = 2;
    //             $json['message'] = 'Error while adding the product to the cart!';
    //             return response()->json($json, 422); // HTTP 422 Unprocessable Entity for error
    //         }
    //     }
    // }
  

public function addToCart(Request $request)
{
   //dd($request->all());
    $productId = $request->input('productId');
    $quantity = $request->input('quantity');
    $userId = $request->input('userId');
          

    // Check if the provided userId is not null
    if ($userId !== null && $userId !== 'null') {
        // If userId is provided, use it for the cart entry
        $userId = $userId;
       
    } else {
        // If userId is null (including 'null' string), use null for the cart entry
        $userId = null;
    }

    // Check if the product already exists in the cart for the user
    $existingCart = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

    if ($existingCart) {
        // Update the existing cart's quantity
        $existingCart->quantity += $quantity;
        $existingCart->save();

        return response()->json(['code' => 1, 'message' => 'Product quantity updated in the cart!'], 200);
    } else {
       
        $cart = new Cart([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        try {
            $cart->saveOrFail(); // Use saveOrFail() to throw an exception if save fails
            return response()->json(['code' => 1, 'message' => 'Product added to cart successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return response()->json(['code' => 2, 'message' => 'Error while adding the product to the cart!'], 422);
        }
    }
}

    public function fetchCartDetails(Request $request, $userId) {
    $result = [];
    $cartItemCount = 0; // Initialize the cart item count
    
    if ($userId === "null") {
        $userId = null;
    }
    
    if (!is_null($userId)) {
        // User is logged in, fetch cart details with user ID
        $cartDetails = Cart::where('user_id', $userId)->get();
    } else {
        // User is not logged in, fetch cart details without user ID
        $cartDetails = Cart::whereNull('user_id')->get();
    }
    
    foreach ($cartDetails as $cartItem) {
        $product = DB::table('product')->where('id', $cartItem->product_id)->first();
        
        if ($product) {
            $totalPrice = $product->price * $cartItem->quantity;
            $result[] = [
                'user_id'=> $cartItem->user_id,
                'cart_id'=> $cartItem->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cartItem->quantity,
                'total_price' => $totalPrice,
                'product_image'=>$product->product_image
            ];
            
            $cartItemCount++; // Increment the cart item count
        }
    }
    
    // You can now return both the result and the cart item count
    return [
        'cart_items' => $result,
        'cart_item_count' => $cartItemCount,
    ];
}

    public function updateToCart(Request $request) {
        $cartId = $request->input('cart_id');
        $newQuantity = $request->input('quantity');
    
        // Assuming your Cart model is named "Cart" and the primary key column is "id"
        $cartItem = Cart::find($cartId);
    
        if ($cartItem) {
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
                return response()->json(['message' => 'Cart item updated successfully'], 200);
            
        } else {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
    }
    public function updateToCartforlogin(Request $request) {
        $userId = $request->input('userId', null); // Set to null if not provided
        $cartData = $request->input('cartData', []);
    
        foreach ($cartData as $cartItemData) {
            $productId = $cartItemData['product_id'];
            $newQuantity = $cartItemData['quantity'];
    
            $existingCartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
    
            if ($existingCartItem) {
                // Product already in the cart, update quantity
                $existingCartItem->quantity += $newQuantity;
                $existingCartItem->save();
            } else {
                // Product not in the cart, add it
                $newCartItem = new Cart();
                $newCartItem->user_id = $userId;
                $newCartItem->product_id = $productId;
                $newCartItem->quantity = $newQuantity;
                $newCartItem->save();
            }
        }
    
        return response()->json(['message' => 'Cart items updated successfully'], 200);
    }
    
    
    public function removeCartDetails(Request $request) {
        $cartId = $request->input('cart_id');
        $userId = $request->input('user_id');
    
        // Remove cart items where cart_id matches and user_id is null or user_id is 6
        $cartItem = Cart::where('id', $cartId)
                        ->where(function ($query) use ($userId) {
                            $query->whereNull('user_id')->orWhere('user_id', $userId);
                        })
                        ->first();
    
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Cart item removed successfully'], 200);
        } else {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
    }

    public function checkoutFormdata(Request $request) {
        $formData = $request->input('formDataToSend'); // Get the formDataToSend object
    
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'numeric' => 'The :attribute must be a number.',
            'integer' => 'The :attribute must be an integer.',
        ];
    
        // Validate the fields inside the formDataToSend object
        try {
    $validatedData = $this->validate($request, [
        'formDataToSend.name' => 'required|string',
        'formDataToSend.email' => 'required|email',
        'formDataToSend.contact' => 'required|string',
        'formDataToSend.address1' => 'required|string',
        'formDataToSend.address2' => 'nullable|string',
        'formDataToSend.country' => 'required|string',
        'formDataToSend.city' => 'required|string',
        'formDataToSend.state' => 'required|string',
        'formDataToSend.zip' => 'required|string',
        'formDataToSend.product_id' => 'required|string',
        'formDataToSend.product_name' => 'required|string',
        'formDataToSend.product_price' => 'required|string',
        'formDataToSend.product_quantity' => 'required|string',
        'formDataToSend.product_subtotal' => 'required|numeric',
        'formDataToSend.payment' => 'required|string',
        'formDataToSend.userid' => 'required|integer',
    ], $customMessages);
} catch (ValidationException $e) {
    $errors = $e->validator->getMessageBag();
    return response()->json([
        "code" => 2,
        "message" => "Validation failed."
    ]);
}

        // Parse comma-separated values as before
        $productIds = explode(',', $formData['product_id']);
        $productNames = explode(',', $formData['product_name']);
        $productPrices = explode(',', $formData['product_price']);
        $productQuantities = explode(',', $formData['product_quantity']);
    
        // Generate random order ID
        $randomOrderId = Str::random(10);
        $orderSaved = true; 
        // Create and save orders
        foreach ($productIds as $index => $productId) {
            $order = new Order([
                'orderid' => $randomOrderId,
                'name' => $formData['name'],
                'email' => $formData['email'],
                'contact' => $formData['contact'],
                'address1' => $formData['address1'],
                'address2' => $formData['address2'],
                'country' => $formData['country'],
                'city' => $formData['city'],
                'state' => $formData['state'],
                'zip' => $formData['zip'],
                'product_id' => $productId,
                'product_name' => $productNames[$index],
                'product_price' => $productPrices[$index],
                'product_quantity' => $productQuantities[$index],
                'product_subtotal' => $formData['product_subtotal'],
                'payment' => $formData['payment'],
                'userid' => $formData['userid'],
            ]);
    
            if (!$order->save()) {
                $orderSaved = false;
                break; // Break the loop if an order fails to save
            }
        }
    
        if ($orderSaved) {
            return response()->json([
                "code" => 1,
                "message" => "Order Confirmed!",
            ]);
        } else {
            return response()->json([
                "code" => 2,
                "message" => "Order not Confirmed!",
            ]);
        }

    }

   
    
    
    
    

    
    
}
