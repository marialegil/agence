<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $table = 'cao_fatura';


    public function lucro(){
        return $this->receita_liquida - ($this->custo_fixo + $this->comissao);
    }
}
