<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelValidate;
use App\Traits\ModelDateAttribute;

class Voucher extends Model
{
    use ModelValidate;
    use ModelDateAttribute;
    
    /**
     *
     * @var array
     */
    protected $fillable = [
        'discount_id',
        'start_date',
        'end_date',
    ];

    /**
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
        'used_date',
    ];
    
    /**
     *
     * @var array
     */
    protected $validationRules = [
        'discount_id' => 'required|exists:discounts,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'used_date' => 'date',
    ];
    
    /**
     * Set active scope
     * 
     * @param \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder
     */
    public function scopeActive($query)
    {
        $query->whereNull('used_date');
        
        return $query;
    }
    
    /**
     * Set start date
     * 
     * @param string $date
     * @return void
     */
    public function setStartDateAttribute($date)
    {
        $this->setDateProperty('start_date', $date);
    }
    
    /**
     * Set end date
     * 
     * @param string $date
     * @return void
     */
    public function setEndDateAttribute($date)
    {
        $this->setDateProperty('end_date', $date);
    }
    
    /**
     * Set used date
     * 
     * @param string $date
     * @return void
     */
    public function setUsedDateAttribute($date)
    {
        $this->setDateProperty('used_date', $date);
    }
    
    /**
     * Voucher discount
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    
    /**
     * Voucher products
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
