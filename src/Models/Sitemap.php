<?php


namespace Hantu\Sitemap\Models;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    public $timestamps = false;
    protected $table = 'sitemap';
    protected $fillable = ['model_id', 'alias', 'model', 'priority', 'lastmod', 'changefreq', 'is_active'];

    public static $changefreq = [
        'always',
        'hourly',
        'daily',
        'weekly',
        'monthly',
        'yearly',
        'never',
    ];

    public function entity(){
        return $this->morphTo($this->model, 'model', 'model_id', 'id');
    }

    public function scopeOnlyActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function getChangefreqAttribute($value)
    {
        if (is_null($value)) {
            return reset(self::$changefreq);
        }
        return in_array($value, self::$changefreq) ? $value : reset(self::$changefreq);
    }

    public function getAliasAttribute($value)
    {
        return str_replace(env('APP_URL') . '/', '', $value);
    }

}
