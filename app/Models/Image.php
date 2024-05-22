<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'sub_category_id', 'image'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get Image attribute - from the s3 location.
     *
     * @param $value
     * @return null|string
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            $path = '/' . configS3('document_prefix.image') . '/' . $this->category_id . '/' . $this->sub_category_id . '/';
            return Storage::disk('s3')->url($path . $value);
        }
        return null;
    }


}
