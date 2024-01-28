<?php

namespace App\Models;

use App\Helpers\ContrastColor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = [
        "name",
        "date",
        "comment",
        "user_id"
    ];

    protected $casts = [
        "date" => "datetime"
    ];

    /**
     * Get the categories linked to the task
     *
     * @return BelongsToMany
     */

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the categories linked to the task
     *
     * @return HasOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the task categories formatted with tag color
     *
     * @return string
     */
    public function getCategoriesNamesAttribute(): string
    {
        return join("", array_map(function ($val) {
            return "<a href='" . route("category.show", ["category" => $val["id"]]) . "' style='border-radius: 0.25rem; padding:.25rem .5rem; background: " . $val["color"] . "; color: " . ContrastColor::getContrastColor($val["color"]) . "'>" . $val["name"] . "</a>";
        }, $this->categories()->get()->toArray()));

    }

    public function getDeadlineAttribute(): string
    {
        $newDate = Carbon::createFromTimestamp(strtotime($this->date));

        // Formater la date en français
        return $newDate->translatedFormat("l d M Y " . __("\a\\t") . " H:i");

    }

    // DEFAULT ORDER BY DEADLINE
    protected static function boot(): void
    {
        parent::boot();

        // Order by date ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date');
        });
    }
}
