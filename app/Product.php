<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
   * The database table used by the model.
   *
   * @var string
   */

  protected $table = 'products';

  /**
   * The attributes to be fillable from the model.
   *
   * A dirty hack to allow fields to be fillable by calling empty fillable array
   *
   * @var array
   */

  protected $fillable = [];
  protected $guarded = ['id'];

   /**
   * many to many relationship with user
   * so we can esily grab all the user who has purchased this product
   */
  public function user()
  {
      return $this->belongsToMany('App\User', 'orders');
  }

  /**
   * Admin can add product via admin panel.
   */
  public function addProduct($request)
  {
      $product = Product::create([
          'product_name' => $request->productName,
          'product_quantity' => $request->quantity,
          'product_price' => $request->price,
          'product_status' => $request->status
      ]);

      return $product;
  }

  /**
   * get all the prduct which has status active
   */
  public function getAllActiveProduct()
  {
      return Product::where('product_status', true)->paginate(15);
  }

  /**
   * update product quantity
   */
  public function updateQuantity($request)
  {
      $product = new Product();
      $updateCount = 0;
      foreach ($request as $key => $item) {
        $updateCount += $product->where('id', $item['product_id'])->decrement('product_quantity', $item['purchased_quantity']);
      }
      return $updateCount;
  }


}
