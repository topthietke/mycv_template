<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseModelInterface
{
    public static function getAll(array $columns = ['*']): Collection;    
    public static function getPaginated(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    public static function findById(int|string $id, array $columns = ['*']): ?static;
    public static function findByIdOrFail(int|string $id, array $columns = ['*']): static;
    public static function findByConditions(array $conditions, array $columns = ['*']): Collection;
    public static function findFirstByConditions(array $conditions, array $columns = ['*']): ?static;
    public static function findByColumn(string $column, mixed $value, array $columns = ['*']): Collection;
    public static function findFirstByColumn(string $column, mixed $value, array $columns = ['*']): ?static;
    public static function findByIds(array $ids, array $columns = ['*']): Collection;
    public static function createRecord(array $data): static;
    public static function createMany(array $records): bool;
    public static function updateById(int|string $id, array $data): bool;
    public static function updateByColumn(string $column, mixed $value, array $data): bool;
    public static function updateOrCreateRecord(array $conditions, array $data): static;
    public static function deleteById(int|string $id): bool;
    public static function deleteByCollumn(string $column, mixed $value ): bool ;
    public static function deleteByIds(array $ids): int;
    public static function forceDeleteById(int|string $id): bool;
    public static function restoreById(int|string $id): bool;
    public static function countAll(): int;
    public static function countByConditions(array $conditions): int;
    public static function existsById(int|string $id): bool;
    public static function existsByConditions(array $conditions): bool;
    public static function search(string $keyword, array $searchableColumns): Collection;
    public static function getFiltered(array  $filters = [],string $sortBy = 'created_at',string $sortDir = 'desc',int $perPage = 15): LengthAwarePaginator;
    public static function getWithRelations(array $relations, array $columns = ['*']): Collection;
    public static function findByIdWithRelations(int|string $id, array $relations): ?static;
    public static function getSelectOptions(string $valueColumn = 'id', string $labelColumn = 'name'): array;
    public function toSafeArray(): array;
    public static function getFillableColumns(): array;
    public static function hasSoftDelete(): bool;
}