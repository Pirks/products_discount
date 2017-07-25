<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Products\Products;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    /**
     *
     * @var Products
     */
    protected $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->products->getActive($request->all());
        return view('products.index', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $product = $this->products->create($request->all());
            return $this->jsonResponce($product->toArray());
        } catch (ValidationException $exc) {
            return $this->jsonErrorResponce($exc->validator);
        }
    }
    
    /**
     * Add voucher to product
     * 
     * @param int $productId
     * @param int $voucherId
     * @return \Illuminate\Http\Response
     */
    public function addVoucher($productId, $voucherId)
    {
        try {
            $this->products->addVoucher($productId, $voucherId);
            return $this->jsonResponce();
        } catch (ValidationException $exc) {
            return $this->jsonErrorResponce($exc->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exc) {
            return $this->jsonNotFoundResponce('Product not found');
        }
    }
    
    /**
     * Remove voucher from product
     * 
     * @param int $productId
     * @param int $voucherId
     * @return \Illuminate\Http\Response
     */
    public function removeVoucher($productId, $voucherId)
    {
        try {
            $this->products->removeVoucher($productId, $voucherId);
            return $this->jsonResponce();
        } catch (ValidationException $exc) {
            return $this->jsonErrorResponce($exc->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exc) {
            return $this->jsonNotFoundResponce('Product not found');
        }
    }
    
    /**
     * Buy product
     * 
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function buyProduct($productId)
    {
        try {
            $this->products->buy($productId);
            return $this->jsonResponce();
        } catch (ValidationException $exc) {
            return $this->jsonErrorResponce($exc->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exc) {
            return $this->jsonNotFoundResponce('Product not found');
        }
    }
}
