<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelValidate;
use App\Traits\ModelDateAttribute;
use Carbon\Carbon;

class Product extends Model
{
    use ModelValidate;
    use ModelDateAttribute;
    
    /**
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'sold_date',
    ];
    
    /**
     *
     * @var array
     */
    protected $dates = [
        'sold_date',
    ];
    
    /**
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
    ];
    
    /**
     *
     * @var array
     */
    protected $validationRules = [
        'name' => 'required',
        'price' => 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
        'sold_date' => 'date',
    ];
    
    /**
     *
     * @var int
     */
    protected $maxDiscount = 60;

    /**
     * Set active scope
     * 
     * @param \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder
     */
    public function scopeActive($query)
    {
        $query->whereNull('sold_date');
        
        return $query;
    }
    
    /**
     * Set end date
     * 
     * @param string $date
     * @return void
     */
    public function setSoldDateAttribute($date)
    {
        $this->setDateProperty('sold_date', $date);
    }
    
    /**
     * 
     * @param string $price
     * @return string
     */
    public function getPriceAttribute($price)
    {
        $discount = 0;
        $this->activeVouchers()
                ->with('discount')
                ->get()
                ->each(function ($voucher) use (&$discount) {
            $discount += $voucher->discount->percents;
        });
        if ($discount > $this->maxDiscount) {
            $discount = $this->maxDiscount;
        }
        
        return number_format($price * (100 - $discount) / 100, 2);
    }
    
    /**
     * All vouchers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class);
    }
    
    /**
     * Active vouchers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeVouchers()
    {
        $now = Carbon::now();
        
        return $this->vouchers()
                ->whereNull('used_date')
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now);
    }
}
