<?php

namespace App;

use Carbon\Carbon;
use Hamcrest\Core\IsNot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManagerStatic as Image;


class Fotocheck extends Model
{
    const SOLICITED = '0';
    const PRUBEA = [18,65];
    const APROBED = '1';
    const CANCELED = '2';

    protected $casts = [
        'courses' => 'array',
    ];
    protected $dates = ['date_emited','user_created','user_updated'];

    protected $fillable = ['user_id', 'courses','date_emited','user_solicited','state'];
    
    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];
    protected $appends = ['courses_attachment_fotocheck'];
    //RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function fotocheck_courses() {
        return $this->hasMany(Fotocheck_course::class);
    }
    //GETTERS
    
    public static function getCoursesAttachmentFotocheckAttribute()
    {
        $courses_attachment=[18,65];
        return $courses_attachment;
    }
    
    //SCOPES
    public function scopeSolicited($q)
    {
        return $q->where('state', self::SOLICITED);
    }
    public function scopeAprobed($q)
    {
        return $q->where('state', self::APROBED);
    }
    public function scopeCanceled($q)
    {
        return $q->where('state', self::CANCELED);
    }
    public function codGenerator()
    {
        return $this->attributes['id'] = str_pad($this->id,8,"0", STR_PAD_LEFT);
    }
    
    //FUNCTIONS
    public function coursesArrayShow($field)
    {
        $fotocheck_course_array = [];
        foreach($this->fotocheck_courses as $fotocheck_course)
        {
            array_push($fotocheck_course_array,$fotocheck_course->$field);
        }
        return $fotocheck_course_array;
    }
    public function fotocheckSuccessfull($request,$user)
    {
        //$fotocheck->update(['date_emited'=> Carbon::now()]);
        if(array_intersect($request->course,$this->courses_attachment_fotocheck))
        {
            if($request->attachment)
            {
                $this->create(['user_id' => $user->id,'user_solicited'=> Auth::user()->id,'state' => Fotocheck::SOLICITED]);
                return true;    
                
            }
            else
            {
                return false;
            }
        }
        $this->create(['user_id' => $user->id,'user_solicited'=> Auth::user()->id,'state' => Fotocheck::SOLICITED]);
        return  true; 

    }
    public function hasAttachment()
    {
        $field='course_id';
        if($this->getAttachment($field))
        {
            return true;
        }
        return false;
    }
    public function getAttachment($field)
    {
        return $Fotocheck_course=Fotocheck_course::where(['fotocheck_id' => $this->id])->whereNotNull('attachment')
                                                ->first(['id','attachment']);
    }
    
    public function fotocheckAprobed()
    {
        $this->update(['date_emited'=> Carbon::now(),'state' => Fotocheck::APROBED]);
    }
    public function fotocheckCancel()
    {
        $this->update(['state' => Fotocheck::CANCELED]);
    }
    
    public function drawingImage($img,$field,$location_x,$location_y)
    {
        $img->text(''.$field.'', $location_x, $location_y, function($font) {
            $font->file(realpath('fonts/foo.ttf'));
            $font->size(30);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');

        
        });
        return $img;
    }
    
    public function writeText()
    {
        return ['324'=>$this->user->name,'389'=>$this->user->firstlastname.' '.$this->user->secondlastname,
        '454'=>$this->user->position,'519'=>$this->user->superintendence,'590' => $this->user->dni,
        '659' => $this->user->company->businessName,'724' =>$this->date_emited->format('Y-m-d'),'795' =>$this->codGenerator()];
    }
    public function generateQrCode()
    {
        $courses_not_fotocheck=[];
        $vigency=[];
        $array= [];
        $details=UserInscription::with(['user','inscription'])
        ->inscriptionHasUser($this->user->id)
        ->notHasFotocheck($this)
        ->active()
        ->get();
        foreach($details as $detail)
        {
            array_push($courses_not_fotocheck,$detail->inscription->course->name,'Fecha de Vencimiento: '.$detail->vigency());
        }
        //convertimos a texto los curso que apareceran en el qr
        $courses=Course::where('id',$this->fotocheck_courses->last()->course_id)->pluck('name')->toArray();
        $course=implode("\n",$courses);
        $other_courses=implode("\n\n",$courses_not_fotocheck);
        
        //aplicamos formatos al codgio qr
        //.PHP_EOL.'OTROS CURSOS'.PHP_EOL.$other_courses,
        $qrcode=QrCode::format('png')->size(300)->generate('CURSOS SOLICITADOS :'.PHP_EOL.'PARTICIPANTE:'.$this->user->name.''.PHP_EOL.PHP_EOL.$course.PHP_EOL.PHP_EOL.'OTROS CURSOS :'.PHP_EOL.$other_courses,'../public/qrcodes/qrcode.png');
    }
    
    
    


}
