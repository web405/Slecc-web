<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Service extends Model {protected $fillable=['title','slug','summary','description','image_url','icon','sort_order','is_published'];protected function casts():array{return ['is_published'=>'boolean','sort_order'=>'integer'];} }
