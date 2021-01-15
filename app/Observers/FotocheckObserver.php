<?php

namespace App\Observers;
use Illuminate\Support\Arr;
use App\Fotocheck;
use Carbon\Carbon;

/**
 * Observes the Users model
 */
class FotocheckObserver 
{
    
    public function created(Fotocheck $fotocheck)
    {
        $courses = [];
        $details=[];
        $details['courses'] = request()->course;
        //valida stados
        
        foreach($details['courses'] as $key)
        {
            array_push($courses, $key);
        }
        $fotocheck->update(['courses' => $courses]);
    }

}