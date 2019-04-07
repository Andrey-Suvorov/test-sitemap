<?php


namespace Hantu\Sitemap\Models;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    public $timestamps = false;
    protected $table = 'sitemap';
    protected $fillable = ['alias', 'priority', 'lastmod', 'changefreq', 'is_active'];

    public static $changefreq = [
        'always',
        'hourly',
        'daily',
        'weekly',
        'monthly',
        'yearly',
        'never',
    ];

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
