<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeGeneratorController extends Controller
{
    public function create($id)
    {
        $codeCount = EventCode::where('event_id', $id)->count();
        return view('dashboards.admin.qr-codes.create', [
            'eventId' => $id,
            'codeCount' => $codeCount
        ]);
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

        return redirect()->route('qr-codes.show', ['id' => $eventId]);
    }

    public function generateEventCodeRegister() {
        
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

        $eventName =  $event->name;

        return view('dashboards.admin.qr-codes.show', ['qrCodes' => $qrCodes, 'event_name' => $eventName]);
    }
}
