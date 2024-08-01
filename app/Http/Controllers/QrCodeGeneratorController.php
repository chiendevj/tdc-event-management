<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeGeneratorController extends Controller
{
    public function create($id)
    {
        $totalCount = EventCode::where('event_id', $id)->count();
        $countCreatedCodes = DB::select('
        SELECT DATE_FORMAT(created_at, \'%Y-%m-%d %H:%i\') as datetime, COUNT(*) as count
        FROM event_codes
        WHERE event_id = :event_id
        GROUP BY datetime
        ORDER BY datetime DESC',
         ['event_id' => $id]);

        return view('dashboards.admin.qr-codes.create', [
            'eventId' => $id,
            'totalCount' => $totalCount,
            'countCreatedCodes' => $countCreatedCodes
        ]);
    }

    public function deleteQRByDate(Request $request, $id){
        $datetime = $request->input('datetime');
        DB::table('event_codes')
            ->where('event_id', $id)
            ->whereRaw('DATE_FORMAT(created_at, \'%Y-%m-%d %H:%i\') = ?', [$datetime])
            ->delete();

        return redirect()->back()->with('status', 'QR Codes deleted successfully.');

    }


    public function store(Request $request, $id) {
        $eventId = $id;
        $quantity = $request->input('quantity', 1);
        $batchSize = 10;
        $generatedCodes = [];

        $existingCodes = EventCode::pluck('code')->toArray();

        for ($batch = 0; $batch < ceil($quantity / $batchSize); $batch++) {
            $currentBatchSize = min($batchSize, $quantity - $batch * $batchSize);

            for ($i = 1; $i <= $currentBatchSize; $i++) {
                $maSuKien = 'msk-' . bin2hex(random_bytes(8));
                while (in_array($maSuKien, $existingCodes) || in_array($maSuKien, $generatedCodes)) {
                    $maSuKien = 'msk-' . bin2hex(random_bytes(8));
                    Log::info('đã có mã trùng');
                }

                $qrCodeUrl = url('diemdanh/' . $maSuKien);
                

                $eventCode = new EventCode();
                $eventCode->link = $qrCodeUrl;
                $eventCode->code = $maSuKien;
                $eventCode->event_id = $eventId;
                $eventCode->save();
            }

            // Giải phóng bộ nhớ sau mỗi lô
            flush();
        }

        return response()->json(['success' => true]);
    }


    public function show(String $id) {
        $qrCodes = [];
        $eventCodes = EventCode::where('event_id', $id)->get();
        $event = Event::find($id);
        foreach ($eventCodes as $eventCode) {
            // Tạo QR code từ đường dẫn link của event code
            $qrCodes[] = (object)[
                'code' => $eventCode->code,
                'link' => $eventCode->link,
                'qrImage' => QrCode::generate($eventCode->link)
            ];
        }

        return view('dashboards.admin.qr-codes.show', ['qrCodes' => $qrCodes, 'event' => $event]);
    }

    public function deleteByEventId($event_id) {
        EventCode::where('event_id', $event_id)->delete();
        return redirect()->back()->with('status', 'QR Codes deleted successfully.');
    }
}
