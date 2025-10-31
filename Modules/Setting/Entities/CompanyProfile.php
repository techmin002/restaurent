<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'logo',
        'footer_logo',
        'favicon',
        'image',
        'footer_text',
        'introduction',
        'vision',
        'mission',
        'map',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Setting\Database\factories\CompanyProfileFactory::new();
    }
}
