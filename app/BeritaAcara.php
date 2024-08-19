<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = "bast";
    public $timestamps = true;
    protected $fillable = ["pono","offerno","bastno","bastdt","workstart","workend","workdesc","workqty","copypofile","reportfile","offerfile","status","createdby","supplier_id","inputdt","to_user"];
}
