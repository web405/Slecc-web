<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model {protected $fillable=['title','slug','summary','description','image_url','event_date','end_date','status','sort_order','is_published'];protected function casts():array{return ['is_published'=>'boolean','event_date'=>'date','end_date'=>'date','sort_order'=>'integer'];} }
