<?php


namespace Talvbansal\TwillSite;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait IsSearchable
 * @package Talvbansal\TwillSite
 *
 * Add a new scope to a trait to help search for content in
 * blocks and defined fields in a searchableFields array...
 */
trait IsSearchable
{
    public function scopeSearch(Builder $query, string $search) : Builder
    {
        $fields = $this->getSearchableFields();

        foreach ($fields as $field) {
            $query->orWhereRaw("LOWER({$field}) LIKE LOWER(?)", ["%{$search}%"]);
        }

        $query->orWhereHas('blocks', function ($q) use ($search) {
            $q->whereRaw('LOWER(content) LIKE LOWER(?)', ["%{$search}%"]);
        });

        return $query;
    }

    private function getSearchableFields(): array
    {
        return $this->searchableFields ?? [];
    }
}
