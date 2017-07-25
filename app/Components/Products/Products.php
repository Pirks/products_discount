<?php

namespace App\Components\Products;

use App\Models\Product as ProductModel;
use Carbon\Carbon;
use App\Components\Vouchers\Vouchers;
use Illuminate\Validation\Rule;

class Products
{
    /**
     *
     * @var ProductModel
     */
    protected $products;
    
    /**
     * 
     * @param ProductModel $products
     * @return void
     */
    public function __construct(ProductModel $products)
    {
        $this->products = $products;
    }
    
    /**
     * Get product
     * 
     * @param int $id
     * @return ProductModel
     */
    public function getProduct($id)
    {
        return $this->products
                ->whereNull('sold_date')
                ->findOrFail($id);
    }
    
    /**
     * Get active products
     * 
     * @param array $filter
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive(array $filter = [])
    {
        $list = $this->products->active()->get();
        if (array_get($filter, 'sort_field')) {
            $list = $list->sortBy(array_get($filter, 'sort_field'));
        }
        
        return $list;
    }
    
    /**
     * Create new product
     * 
     * @param array $data
     * @return ProductModel
     */
    public function create(array $data)
    {
        $voucher = $this->products->fill($data);
        $voucher->save();
        
        return $voucher;
    }
    
    /**
     * Add voucher to product
     * 
     * @param int $productId
     * @param int $voucherId
     * @return void
     */
    public function addVoucher($productId, $voucherId)
    {
        $product = $this->getProduct($productId);
        $this->validateVaucher($product, $voucherId);
        $product->vouchers()->sync([$voucherId], false);
    }
    
    /**
     * Remove voucher from product
     * 
     * @param int $productId
     * @param int $voucherId
     * @return void
     */
    public function removeVoucher($productId, $voucherId)
    {
        $product = $this->getProduct($productId);
        $this->validateVaucher($product, $voucherId);
        $product->vouchers()->detach($voucherId);
    }
    
    /**
     * Buy product
     * 
     * @param type $productId
     * @return void
     */
    public function buy($productId)
    {
        $product = $this->getProduct($productId);
        \DB::transaction(function () use ($product) {
            $product->sold_date = Carbon::now();
            $product->activeVouchers->each(function ($voucher) {
                app(Vouchers::class)->setUsed($voucher);
            });
            $product->save();
        });
    }
    
    /**
     * Validate if vaucher is active
     * 
     * @param ProductModel $product
     * @param int $voucherId
     * @return void
     */
    protected function validateVaucher(ProductModel $product, $voucherId)
    {
        $product->validate(['voucher' => [$voucherId]], ['voucher' => [Rule::exists('vouchers', 'id')->where(function ($query) {
            $query = app(Vouchers::class)->activeScope($query);
        }),]]);
    }
}
