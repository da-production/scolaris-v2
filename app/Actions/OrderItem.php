<?php
namespace App\Actions;
use Illuminate\Support\Facades\DB;

class OrderItem
{
    /**
     * Handle the order item.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $item
     * @param  int  $order
     * @return void
     */
    public static function handle($items, $className)
    {
        $caseStatement = "CASE";
        $itemIds = [];

        foreach ($items as $item) {
            $caseStatement .= " WHEN id = {$item['value']} THEN {$item['order']}";
            $itemIds[] = $item['value'];
        }

        $caseStatement .= " END";
        
        // Update using Eloquent
        $className::whereIn('id', $itemIds)
            ->update(['order' => DB::raw($caseStatement)]);
    }
}