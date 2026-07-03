<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseModel extends Model implements BaseModelInterface {
    public static function getAll(array $columns = ['*']): Collection
    {
        return static::select($columns)->get();
    }

    public static function getPaginated(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return static::select($columns)->paginate($perPage);
    }

    public static function findById(int|string $id, array $columns = ['*']): ?static
    {
        return static::select($columns)->find($id);
    }

    public static function findByIdOrFail(int|string $id, array $columns = ['*']): static
    {
        return static::select($columns)->findOrFail($id);
    }

    public static function findByConditions(array $conditions, array $columns = ['*']): Collection
    {
        return static::select($columns)->where($conditions)->get();
    }

    public static function findFirstByConditions(array $conditions, array $columns = ['*']): ?static
    {
        return static::select($columns)->where($conditions)->first();
    }
    
    public static function findByColumn(string $column, mixed $value, array $columns = ['*']): Collection
    {
        return static::select($columns)->where($column, $value)->get();
    }

    public static function findFirstByColumn(string $column, mixed $value, array $columns = ['*']): ?static
    {
        return static::select($columns)->where($column, $value)->first();
    }

    public static function findByIds(array $ids, array $columns = ['*']): Collection
    {
        return static::select($columns)->whereIn((new static)->getKeyName(), $ids)->get();
    }
   
    public static function createRecord(array $data): static
    {
        return static::create($data);
    }

    public static function createMany(array $records): bool {
        if (empty($records)) {
            return false;
        }

        // Tự động thêm timestamps nếu model có dùng
        $instance = new static;
        if ($instance->usesTimestamps()) {
            $now = now();
            $records = array_map(function ($record) use ($now) {
                return array_merge($record, [
                    'created_at' => $record['created_at'] ?? $now,
                    'updated_at' => $record['updated_at'] ?? $now,
                ]);
            }, $records);
        }

        return static::insert($records);
    }

    public static function updateByColumn(string $column, mixed $value, array $data): bool {        
        return static::where($column, $value)->update($data);
    }

    public static function updateById(int|string $id, array $data): bool {
        $record = static::find($id);
        if (!$record) {
            return false;
        }
        return $record->update($data);
    }
   
    public static function updateOrCreateRecord(array $conditions, array $data): static
    {
        return static::updateOrCreate($conditions, $data);
    }
    
    public static function deleteById(int|string $id): bool
    {
        $record = static::find($id);

        if (!$record) {
            return false;
        }

        return (bool) $record->delete();
    }

    public static function deleteByCollumn(string $column, mixed $value ): bool {
        $record = static::where($column, $value);
        if (!$record) {
            return false;
        }
        return (bool) $record->delete();
    }

    public static function deleteByIds(array $ids): int
    {
        if (empty($ids)) {
            return 0;
        }

        return static::whereIn((new static)->getKeyName(), $ids)->delete();
    }

    
    public static function forceDeleteById(int|string $id): bool
    {
        $query = static::hasSoftDelete()
            ? static::withTrashed()->find($id)
            : static::find($id);

        if (!$query) {
            return false;
        }

        return static::hasSoftDelete()
            ? (bool) $query->forceDelete()
            : (bool) $query->delete();
    }

    
    public static function restoreById(int|string $id): bool
    {
        if (!static::hasSoftDelete()) {
            return false;
        }

        $record = static::withTrashed()->find($id);

        if (!$record) {
            return false;
        }

        return (bool) $record->restore();
    }
    
    public static function countAll(): int
    {
        return static::count();
    }

    public static function countByConditions(array $conditions): int {
        return static::where($conditions)->count();
    }

    /**
     * Kiểm tra tồn tại theo ID
     *
     * @example User::existsById(1)
     */
    public static function existsById(int|string $id): bool
    {
        return static::where((new static)->getKeyName(), $id)->exists();
    }

    /**
     * Kiểm tra tồn tại theo điều kiện
     *
     * @example User::existsByConditions(['email' => 'foo@bar.com'])
     */
    public static function existsByConditions(array $conditions): bool
    {
        return static::where($conditions)->exists();
    }

    // ============================================================
    //  SEARCH / FILTER
    // ============================================================

    /**
     * Tìm kiếm full-text LIKE theo nhiều cột
     *
     * @example User::search('john', ['name', 'email', 'phone'])
     */
    public static function search(string $keyword, array $searchableColumns): Collection
    {
        if (empty($searchableColumns) || blank($keyword)) {
            return static::all();
        }

        return static::where(function ($query) use ($keyword, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $query->orWhere($column, 'LIKE', "%{$keyword}%");
            }
        })->get();
    }

    /**
     * Lấy dữ liệu với filter động, sort, và phân trang
     *
     * Hỗ trợ filter dạng:
     *   - ['column' => 'value']                   => WHERE column = value
     *   - ['column' => ['op' => '>=', 'val' => 5]] => WHERE column >= 5
     *   - ['search' => ['keyword' => 'abc', 'columns' => ['name', 'email']]]
     *
     * @example User::getFiltered(['status' => 'active'], 'name', 'asc', 10)
     */
    public static function getFiltered(array  $filters = [], string $sortBy = 'created_at', string $sortDir = 'desc', int    $perPage = 15): LengthAwarePaginator {
        $query = static::query();

        foreach ($filters as $column => $value) {
            // Hỗ trợ tìm kiếm full-text
            if ($column === 'search' && is_array($value)) {
                $keyword = $value['keyword'] ?? '';
                $cols    = $value['columns'] ?? [];

                if (!blank($keyword) && !empty($cols)) {
                    $query->where(function ($q) use ($keyword, $cols) {
                        foreach ($cols as $col) {
                            $q->orWhere($col, 'LIKE', "%{$keyword}%");
                        }
                    });
                }
                continue;
            }

            // Hỗ trợ toán tử tùy chỉnh: ['age' => ['op' => '>=', 'val' => 18]]
            if (is_array($value) && isset($value['op'], $value['val'])) {
                $query->where($column, $value['op'], $value['val']);
                continue;
            }

            // Hỗ trợ whereIn: ['status' => ['active', 'pending']]
            if (is_array($value)) {
                $query->whereIn($column, $value);
                continue;
            }

            // Simple WHERE
            $query->where($column, $value);
        }

        // Sort direction an toàn
        $sortDir = in_array(strtolower($sortDir), ['asc', 'desc']) ? $sortDir : 'desc';

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    // ============================================================
    //  RELATIONSHIP
    // ============================================================

    /**
     * Lấy tất cả kèm eager loading
     *
     * @example User::getWithRelations(['roles', 'profile'])
     */
    public static function getWithRelations(array $relations, array $columns = ['*']): Collection
    {
        return static::select($columns)->with($relations)->whereNull('deleted_at')->get();
    }

    /**
     * Tìm theo ID kèm eager loading
     *
     * @example User::findByIdWithRelations(1, ['roles', 'profile'])
     */
    public static function findByIdWithRelations(int|string $id, array $relations): ?static
    {
        return static::with($relations)->find($id);
    }

    // ============================================================
    //  TRANSACTION
    // ============================================================

    /**
     * Thực thi một callback trong DB Transaction
     *
     * @example User::transaction(function() { ... })
     * @throws \Throwable
     */
    public static function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }

    // ============================================================
    //  UTILITY
    // ============================================================

    /**
     * Lấy danh sách key => value cho dropdown/select box
     *
     * @example User::getSelectOptions('id', 'name')
     * // => [1 => 'Alice', 2 => 'Bob']
     */
    public static function getSelectOptions(string $valueColumn = 'id', string $labelColumn = 'name'): array
    {
        return static::query()
            ->pluck($labelColumn, $valueColumn)
            ->toArray();
    }

    /**
     * Chuyển model sang array, chỉ lấy các fillable fields
     *
     * @example $user->toSafeArray()
     */
    public function toSafeArray(): array
    {
        return $this->only($this->getFillable());
    }

    /**
     * Lấy danh sách cột fillable của model (static)
     *
     * @example User::getFillableColumns()
     */
    public static function getFillableColumns(): array
    {
        return (new static)->getFillable();
    }

    /**
     * Kiểm tra model có sử dụng SoftDeletes trait không
     *
     * @example User::hasSoftDelete()
     */
    public static function hasSoftDelete(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive(static::class));
    }

    /**
     * Lấy bản ghi cùng các bản ghi đã soft-deleted (nếu có)
     *
     * @example User::getAllWithTrashed()
     */
    public static function getAllWithTrashed(array $columns = ['*']): Collection
    {
        if (!static::hasSoftDelete()) {
            return static::getAll($columns);
        }

        return static::withTrashed()->select($columns)->get();
    }

    /**
     * Lấy chỉ các bản ghi đã soft-deleted
     *
     * @example User::getOnlyTrashed()
     */
    public static function getOnlyTrashed(array $columns = ['*']): Collection
    {
        if (!static::hasSoftDelete()) {
            return collect();
        }

        return static::onlyTrashed()->select($columns)->get();
    }

    /**
     * Log lỗi và trả về giá trị mặc định (helper dùng nội bộ)
     */
    protected static function logAndReturn(string $message, \Throwable $e, mixed $default = null): mixed
    {
        Log::error("[" . static::class . "] {$message}: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return $default;
    }
}
