<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $fillable = ['origin', 'orno', 'oset', 'pono', 'seqn', 'bpid', 'rcno', 'dnno', 'psno', 'ardt', 'item', 'dqua', 'pric', 'price', 'baststatus', 'bastdt', 'bastusr', 'rrstatus', 'rrdt', 'rrusr'];
}
