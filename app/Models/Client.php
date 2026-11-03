<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Client extends Model {protected $fillable=['name','industry','logo_url','sort_order','is_published'];protected function casts():array{return ['is_published'=>'boolean','sort_order'=>'integer'];} }
