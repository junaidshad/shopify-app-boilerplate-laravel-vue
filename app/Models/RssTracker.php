<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssTracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'configuration',
    ];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
