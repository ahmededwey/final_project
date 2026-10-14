<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HandlesSoftDeletes
{
    protected function filterTrashedRecords(
        Builder $query,
        Request $request,
        bool $includeWithTrashed = true,
    ): Builder {
        return match ($request->query('trashed')) {
            'only' => $query->onlyTrashed(),
            'with' => $includeWithTrashed ? $query->withTrashed() : $query,
            default => $query,
        };
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    protected function restoreTrashedRecord(string $modelClass, string $id): void
    {
        $record = $modelClass::withTrashed()->findOrFail($id);
        $record->restore();
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    protected function permanentlyDeleteTrashedRecord(string $modelClass, string $id): void
    {
        $record = $modelClass::withTrashed()->findOrFail($id);
        $record->forceDelete();
    }
}
