<?php


namespace App\Models;

use App\Traits\TranslationFallBackApi;


trait CommonFunctions{
    public static $ACCOUNT_TYPE_CLIENT = 'client';
    public static $ACCOUNT_TYPE_COMPANY = 'company';
    public static $ORDER_TYPE_PENDING = 'pending';
    public static $ORDER_TYPE_SHIPPED = 'shipped';
    public static $ORDER_TYPE_DELIVERD= 'deliverd';
    public static $ORDER_TYPE_CONFIRMED = 'confirmed';

    public function getDateFormat()
    {
        return 'U';
    }

    protected function getImageAttribute() {
        if (!empty($this->attributes['image'])){
            return url($this->attributes['image']);
        }
        return url('images/no-image.png');
    }

    protected function getInvoiceAttribute(){
        if (!empty($this->attributes['invoice'])){
            return url($this->attributes['invoice']);
        }
        return '';
    }

}