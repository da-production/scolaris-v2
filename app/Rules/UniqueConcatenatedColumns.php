<?php

namespace App\Rules;


use Illuminate\Support\Facades\DB;

class UniqueConcatenatedColumns 
{
    protected string $table;
    protected array $columns;
    protected array $values;
    protected ?int $ignoreId;

    public function __construct(string $table, array $columns, array $values, $ignoreId = null)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->values = $values;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value): bool
    {
        $query = DB::table($this->table);

        // Sécurité : éviter NULL dans CONCAT
        $concatExpr = "CONCAT(" . collect($this->columns)->map(fn($col) => "IFNULL($col, '')")->implode(", ") . ")";

        $query->select(DB::raw("COUNT(*) as count"))
            ->whereRaw("$concatExpr = ?", [$this->buildConcatValue()]);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        return $query->value('count') == 0;
    }

    protected function buildConcatValue(): string
    {
        return collect($this->columns)->map(fn($col) => $this->values[$col] ?? '')->implode('');
    }

    public function message(): string
    {
        return 'La combinaison de ces champs est déjà utilisée.';
    }
}
