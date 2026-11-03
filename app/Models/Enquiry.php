<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enquiry extends Model {protected $fillable=['name','email','phone','organization','interest','venue_id','event_date','attendees','message','status','admin_notes'];protected function casts():array{return ['event_date'=>'date','attendees'=>'integer'];} public function venue(){return $this->belongsTo(Venue::class);}}
