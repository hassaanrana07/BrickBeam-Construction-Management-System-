<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = Portfolio::all();

        if ($portfolios->isEmpty()) {
            return;
        }

        $p1 = $portfolios->first();
        $p2 = $portfolios->count() > 1 ? $portfolios->get(1) : $p1;
        $p3 = $portfolios->count() > 2 ? $portfolios->get(2) : $p1;

        $expenses = [
            [
                'portfolio_id' => $p1->id,
                'category' => 'materials',
                'amount' => 485000.00,
                'invoice_number' => 'INV-MAT-2026-089',
                'status' => 'paid',
                'due_date' => now()->subDays(15)->toDateString(),
                'paid_at' => now()->subDays(14),
            ],
            [
                'portfolio_id' => $p1->id,
                'category' => 'labor',
                'amount' => 240000.00,
                'invoice_number' => 'INV-LBR-2026-104',
                'status' => 'paid',
                'due_date' => now()->subDays(7)->toDateString(),
                'paid_at' => now()->subDays(6),
            ],
            [
                'portfolio_id' => $p2->id,
                'category' => 'equipment',
                'amount' => 125000.00,
                'invoice_number' => 'INV-EQP-2026-042',
                'status' => 'paid',
                'due_date' => now()->subDays(20)->toDateString(),
                'paid_at' => now()->subDays(18),
            ],
            [
                'portfolio_id' => $p2->id,
                'category' => 'overhead',
                'amount' => 86000.00,
                'invoice_number' => 'INV-OPS-2026-031',
                'status' => 'paid',
                'due_date' => now()->subDays(5)->toDateString(),
                'paid_at' => now()->subDays(4),
            ],
            [
                'portfolio_id' => $p3->id,
                'category' => 'materials',
                'amount' => 620000.00,
                'invoice_number' => 'INV-MAT-2026-112',
                'status' => 'pending',
                'due_date' => now()->addDays(14)->toDateString(),
                'paid_at' => null,
            ],
            [
                'portfolio_id' => $p3->id,
                'category' => 'labor',
                'amount' => 180000.00,
                'invoice_number' => 'INV-LBR-2026-115',
                'status' => 'paid',
                'due_date' => now()->subDays(2)->toDateString(),
                'paid_at' => now()->subDays(1),
            ],
        ];

        foreach ($expenses as $expenseData) {
            Expense::updateOrCreate(
                ['invoice_number' => $expenseData['invoice_number']],
                $expenseData
            );
        }
    }
}
