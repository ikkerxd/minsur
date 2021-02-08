<?php

namespace App\Observers;
use Illuminate\Support\Arr;
use App\Fotocheck;
use App\Fotocheck_course;
use Carbon\Carbon;

/**
 * Observes the Users model
 */
class FotocheckObserver 
{
    
    public function created(Fotocheck $fotocheck)
    {
        $details=[];
        $details['courses'] = request()->course;
        //valida stados
        foreach($details['courses'] as $key)
        {
            $fotocheck_course=Fotocheck_course::create(['course_id'=>$key,'fotocheck_id'=>$fotocheck->id]);
        }
        if (request()->attachment != null) {

            $name = request()->attachment;
            $attachment= request()->file('attachment')->getClientOriginalName();
            $name_hash = $name->hashName();
            $name->move('files/', $name_hash);
            $fotocheck_course->update(['attachment'=> $attachment,'attachment_hash'=> $name_hash,'required'=> Fotocheck_course::REQUIRED]);
        }
        
    }

}