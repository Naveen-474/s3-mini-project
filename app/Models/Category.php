<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Field name for the bulk assignment
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'image'
    ];

    /**
     * Get Image attribute - from the s3 location.
     *
     * @param $value
     * @return null|string
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            $path = '/' . configS3('document_prefix.category') . '/';
            return Storage::disk('s3')->url($path . $value);
        }
        return null;
    }


    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
