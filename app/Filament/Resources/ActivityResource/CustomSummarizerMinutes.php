<?php

namespace App\Filament\Resources\ActivityResource;

use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Query\Builder;

class CustomSummarizerMinutes extends Summarizer
{
    public function summarize(Builder $query, string $attribute): string
    {

        $totalMinutes = $query->sum($attribute);
        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%d h %02d min', $hours, $minutes);
    }
}
