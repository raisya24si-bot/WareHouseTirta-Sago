<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterStatusPo;
use App\Models\Po;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    use HasPerPage;

    private function levelConfig(string $level): array
    {
        abort_unless(
            array_key_exists($level, Po::LEVELS),
            404
        );

        return Po::LEVELS[$level];
    }

    private function statusId(string $kode): int
    {
        return MasterStatusPo::where(
            'kd_status_po',
            $kode
        )->value('id_status_po');
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX (ANTREAN PERSETUJUAN)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, string $level)
    {
        $config = $this->levelConfig($level);

        $perPage = $this->perPageOption($request);


        $query = Po::with([
            'supplier',
            'statusPo',
            'details',
            'submittedBy',
        ])
            ->where(function ($q) use ($config, $level) {

                $q->whereHas(
                    'statusPo',
                    fn ($s) =>
                        $s->where(
                            'kd_status_po',
                            $config['status']
                        )
                )
                    ->orWhereNotNull($config['at_field'])
                    ->orWhere(
                        function ($r) use ($level) {

                            $r->whereHas(
                                'statusPo',
                                fn ($s) =>
                                    $s->where(
                                        'kd_status_po',
                                        'REJECTED'
                                    )
                            )
                                ->where(
                                    'reject_level',
                                    strtoupper($level)
                                );
                        }
                    );
            })
            ->orderByDesc('submit_at');


        if ($request->filled('search')) {

            $search = trim(
                $request->string('search')->toString()
            );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'kd_po',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'submittedBy',
                        fn ($u) =>
                            $u->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )
                    );
                }
            );
        }


        $purchaseOrders = $query
            ->paginate(
                $this->resolvePerPage($request, $query)
            )
            ->withQueryString();


        /*
        |----------------------------------------------------------------
        | STATS
        |----------------------------------------------------------------
        */

        $waitingCount = Po::whereHas(
            'statusPo',
            fn ($q) =>
                $q->where('kd_status_po', $config['status'])
        )->count();


        $approvedTodayCount = Po::whereDate(
            $config['at_field'],
            today()
        )->count();


        $rejectedCount = Po::whereHas(
            'statusPo',
            fn ($q) =>
                $q->where('kd_status_po', 'REJECTED')
        )
            ->where('reject_level', strtoupper($level))
            ->count();


        return view(
            'approval.index',
            compact(
                'level',
                'config',
                'purchaseOrders',
                'perPage',
                'waitingCount',
                'approvedTodayCount',
                'rejectedCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REVIEW (DETAIL + KEPUTUSAN)
    |--------------------------------------------------------------------------
    */

    public function review(string $level, Po $po)
    {
        $config = $this->levelConfig($level);

        $po->load([
            'supplier',
            'statusPo',
            'details.barang',
            'submittedBy',
            'kasubagBy',
            'kabagBy',
            'direkturBy',
            'rejectedBy',
        ]);


        return view(
            'approval.review',
            compact('level', 'config', 'po')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(Request $request, string $level, Po $po)
    {
        $config = $this->levelConfig($level);

        abort_unless(
            $po->isPendingAt($level),
            403,
            'Purchase Order ini tidak sedang menunggu persetujuan ' . $config['label'] . '.'
        );


        DB::transaction(
            function () use ($po, $config) {

                $po->update([
                    $config['by_field'] => auth()->id(),
                    $config['at_field'] => now(),
                    'fk_status_po' => $this->statusId($config['next_status']),
                    'updated_by' => auth()->id(),
                ]);
            }
        );


        return redirect()
            ->route('approval.index', $level)
            ->with(
                'success',
                'Purchase Order ' . $po->kd_po . ' disetujui di tingkat ' . $config['label'] . '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT (BALIK KE PETUGAS)
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, string $level, Po $po)
    {
        $config = $this->levelConfig($level);

        abort_unless(
            $po->isPendingAt($level),
            403,
            'Purchase Order ini tidak sedang menunggu persetujuan ' . $config['label'] . '.'
        );


        $validated = $request->validate([
            'reject_note' => [
                'required',
                'string',
                'max:500',
            ],
        ]);


        $po->update([
            'fk_status_po' => $this->statusId('REJECTED'),
            'reject_by' => auth()->id(),
            'reject_at' => now(),
            'reject_level' => strtoupper($level),
            'reject_note' => $validated['reject_note'],
            'updated_by' => auth()->id(),
        ]);


        return redirect()
            ->route('approval.index', $level)
            ->with(
                'success',
                'Purchase Order ' . $po->kd_po . ' dikembalikan ke petugas untuk direvisi.'
            );
    }
}
