<?php

namespace App\Components\Vouchers;

use App\Models\Voucher as VoucherModel;
use Carbon\Carbon;

class Vouchers
{
    /**
     *
     * @var VoucherModel
     */
    protected $voucher;

    /**
     * 
     * @param VoucherModel $vouchers
     * @return void
     */
    public function __construct(VoucherModel $vouchers)
    {
        $this->voucher = $vouchers;
    }
    
    /**
     * Get voucher
     * 
     * @param int $id
     * @return VoucherModel
     */
    public function getVoucher($id)
    {
        return $this->voucher
                ->whereNull('used_date')
                ->findOrFail($id);
    }
    
    /**
     * Set active scope to query
     * 
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function activeScope(\Illuminate\Database\Query\Builder $query)
    {
        return $this->voucher->scopeActive($query);
    }

    /**
     * Create new voucher
     * 
     * @param array $data
     * @return VoucherModel
     */
    public function create(array $data)
    {
        $voucher = $this->voucher->fill($data);
        $voucher->save();
        
        return $voucher;
    }
    
    /**
     * Mark voucher as used
     * 
     * @param VoucherModel $voucher
     * @return void
     */
    public function setUsed(VoucherModel $voucher)
    {
        $voucher->used_date = Carbon::now();
        $voucher->save();
    }
}
