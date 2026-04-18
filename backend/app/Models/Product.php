<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function addProduct($data)
    {
       $result=  DB::table('product')->insert($data);
       return $result;

    }
    public function getProduct()
    {
       $result=  DB::table('product')->get();
       return $result;

    }
    public function getTrendyProduct()
    {
       $result=  DB::table('product')->where('trandy',1)->get();
       return $result;

    }
    public function getjustarrivedProduct()
    {
       $result=  DB::table('product')->where('justArrived',1)->get();
       return $result;

    }
    
    public function deleteData($id)
    {
       $result=  DB::table('product')->where('id',$id)->delete();
       return $result;

    }
    public function updateProduct($id,$data)
    {
       $result=  DB::table('product')->where('id', $id)->update($data);
       return $result;

    }
    public function getProductdetails($id)
    {
       $result=  DB::table('product')->where('id',$id)->get();
       return $result;

    }
    public function getproductCategoryWise($category)
    {
       $result=  DB::table('product')->where('Supercategory_id',$category)->get();
       return $result;

    }
   //  public function  getproductCount()
   //  {
   //     $result=  DB::table('product')->where('Supercategory_id',1)->where('Supercategory_id',2)->where('Supercategory_id',3)->get();
   //     return $result;

   //  }
    public function getproductCount()
   {
    $supercategories = [1, 2, 3, 4, 5, 6];
    
    $supercategoryCounts = [];

    foreach ($supercategories as $supercategory) {
      $count = DB::table('product')
          ->where('Supercategory_id', $supercategory)
          ->select(DB::raw('COALESCE(COUNT(*), 0) as count'))
          ->first();

      $supercategoryCounts[$supercategory] = $count->count;
  }
  foreach ($supercategories as $supercategory) {
   if (!isset($supercategoryCounts[$supercategory])) {
       $supercategoryCounts[$supercategory] = 0;
   }
}

    return $supercategoryCounts;
}
public function getProductPriceWise($requestData)
{
    $defaultCategories = [1,2,3]; 

    // Check if 'category_id' exists in $requestData and get its value
    $category = null; // Default category if not provided
    foreach ($requestData as $filter) {
        if ($filter['key'] === 'category_id' && isset($filter['category'])) {
            $category = $filter['category'];
            break;
        }
    }

    // If category is still not set or 'category' key is not present, use the first default category from the list
    if ($category === null || !isset($filter['category'])) {
        $category = $defaultCategories;
    } else {
        $category = $filter['category'];
    }

    $query = DB::table('product');

    foreach ($requestData as $filter) {
        switch ($filter['key']) {
            case 'priceFilter':
                // Assuming the value is in the format "min-max", split it into an array
                if ($filter['value'] !== 'all') {
                    list($min, $max) = explode('-', $filter['value']);
                    $query->whereBetween('price', [$min, $max]);
                }
                break;

            case 'colorFilter':
                if ($filter['value'] !== 'all') {
                    $query->where('color', $filter['value']);
                }
                break;

            case 'sizeFilter':
                if ($filter['value'] !== 'all') {
                    $query->where('size', $filter['value']);
                }
                break;

            // case 'category_id':
               
            //     break;

            case 'subcategory':
                if (isset($filter['subcategory'])) {
                    $subcategory = $filter['subcategory'];
                    $query->where('category_id', $subcategory);
                }
                break;
        }
    }

    // Apply the category filter
    // $query->where('Supercategory_id', $category);
    $query->whereIn('Supercategory_id', (array) $category)
    ->get();

    $result = $query->get();

    if ($result->isEmpty()) {
        $result['code'] = 1;
        $result['message'] = 'No data found';
        return response()->json($result);
    } else {
      return response()->json($result);
    }
}
  
}



   
    
