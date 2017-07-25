<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Vouchers\Vouchers;
use Illuminate\Validation\ValidationException;

class VouchersController extends Controller
{
    /**
     *
     * @var Vouchers 
     */
    protected $vouchers;

    public function __construct(Vouchers $vouchers)
    {
        $this->vouchers = $vouchers;
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
            $vouchers = $this->vouchers->create($request->all());
            return $this->jsonResponce($vouchers->toArray());
        } catch (ValidationException $exc) {
            return $this->jsonErrorResponce($exc->validator);
        }
    }
}
