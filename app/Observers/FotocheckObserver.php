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

    }

    public function updated(Fotocheck $fotocheck)
    {
        if(!$fotocheck->state == 0)
        {
            return redirect()->back();
            
        }
        $courses = [];
        $details=[];
        $details['courses'] = request()->course;
        //valida stados
        
        foreach($details['courses'] as $key)
        {
            array_push($courses, $key);
        }
        $fotocheck->update(['courses' => json_encode($courses) , 'state' => Fotocheck::APROBED]);

    }

}