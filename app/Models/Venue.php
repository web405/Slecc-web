<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Venue extends Model {protected $fillable=['title','slug','type','summary','description','image_url','features','capacity_note','sort_order','is_published'];protected function casts():array{return ['is_published'=>'boolean','features'=>'array','sort_order'=>'integer'];} }
