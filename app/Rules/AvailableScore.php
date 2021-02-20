<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Question;
use App\Models\Criterio;

class AvailableScore implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Question $pregunta,Criterio $criterio=NULL)
    {
        if ($criterio == NULL){
            $this->crit = NULL;
        }else{
            $this->crit = $criterio;
        }

        $this->preg = $pregunta;
    }

    public $preg;
    public $crit;
    public $available;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $suma = 0;

        foreach ($this->preg->criterios as $c){
            $suma = $suma + $c->pivot->score;
        }
        if($this->crit == NULL){
            $available = $this->preg->total_score - $suma;
            
        }else{
            $score_old = $this->crit->questions->find($this->preg->id)->pivot->score;
            $available = $this->preg->total_score - $suma + $score_old;
        }
        $this->available = $available;
        return $value <= $available;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute debe ser menor o igual a $this->available";
    }
}
