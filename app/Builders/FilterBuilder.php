<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

use App\Models\Product;

class FilterBuilder extends Builder
{
    /**
     * @param array $pagination
     *
     * @return Builder
     */
    public function withPagination(array $pagination = []): Builder
    {
        $offset = (($pagination['page'] ?? 1) - 1) * ($pagination['limit'] ?? Product::PAGINATION_LIMIT);

        $this->offset($offset)->limit($pagination['limit'] ?? Product::PAGINATION_LIMIT);

        return $this;
    }

    /**
     * @param array $sort
     *
     * @return Builder
     */
    public function sort(array $sort = []): Builder
    {
        $direction = filter_var($sort['order'], FILTER_VALIDATE_BOOLEAN) ? 'asc' : 'desc';
        $this->orderBy($this->resolveSortField($sort['field'] ?? 'id'), $direction);

        return $this;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function resolveSortField(string $field): string
    {
        return match ($field) {
            'id' => 'id',
            default => $field,
        };
    }

    /**
     * @param array $filters
     *
     * @return Builder
     */
    public function withFilters(array $filters = []): Builder
    {
        $this
            ->when(
                $filters['color'] ?? false,
                fn() => $this->whereHas(
                    'options',
                    fn($q) => $q->whereIn('value', $filters['color'])
                )
            )
            ->when(
                $filters['weight'] ?? false,
                fn() => $this->orWhereHas(
                    'options',
                    fn($q) => $q->whereIn('value', $filters['weight'])
                )
            );

        return $this;
    }
}
