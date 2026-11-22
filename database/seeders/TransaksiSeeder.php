<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;

/**
 * Bergantung pada MemberSeeder dan ProductSeeder.
 * Mencakup semua status: diproses, disetujui, selesai, plus transaksi kosong (edge case).
 */
class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $member = fn (string $nik) => Member::where('identity_number', $nik)->firstOrFail();
        $product = fn (string $code) => Product::where('code', $code)->firstOrFail();

        $scenarios = [
            // member NIK, tanggal, status, jaminan, [kode produk => status item]
            ['3273014502000002', now()->subDays(3)->toDateString(), 'disetujui', 'KTP', ['BRG-0006' => 'diproses', 'BRG-0007' => 'diproses']],
            ['3578011203980003', now()->toDateString(), 'diproses', 'belum ada', []], // edge: transaksi tanpa item, total 0
            ['3273012001990001', now()->subDays(30)->toDateString(), 'selesai', 'KTM', ['BRG-0001' => 'selesai', 'BRG-0003' => 'selesai']],
            ['3471010909970005', now()->subDays(10)->toDateString(), 'selesai', 'SIM', ['BRG-0002' => 'selesai']],
        ];

        foreach ($scenarios as [$nik, $date, $status, $collateral, $items]) {
            $transaction = Transaction::firstOrNew([
                'member_id' => $member($nik)->id,
                'transaction_date' => $date,
            ]);
            $transaction->forceFill([
                'status' => $status,
                'collateral' => $collateral,
                'total' => count($items),
            ])->save();

            foreach ($items as $code => $itemStatus) {
                $item = TransactionItem::firstOrNew([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product($code)->id,
                ]);
                $item->forceFill(['status' => $itemStatus, 'quantity' => 1])->save();
            }
        }
    }
}
