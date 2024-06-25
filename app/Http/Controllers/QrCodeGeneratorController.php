<?php

namespace App\Http\Controllers;

use App\Models\EventCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeGeneratorController extends Controller
{
    public function create($id)
    {
        return view('dashboards.admin.qr-codes.create', ['eventId' => $id]);
    }
    public function store(Request $request, $id) {
        $qrCodes = [];
        $eventId = $id;
        $quantity = $request->input('quantity', 1);
        $batchSize = 10;

        for ($batch = 0; $batch < ceil($quantity / $batchSize); $batch++) {
            $currentBatchSize = min($batchSize, $quantity - $batch * $batchSize);

            for ($i = 1; $i <= $currentBatchSize; $i++) {
                $maSuKien = 'SK-' . uniqid();
                Log::info('Mã sự kiện: ' . $maSuKien);

                $qrCodeUrl = url('diemdanh/' . $maSuKien);
                Log::info('Đường dẫn: ' . $qrCodeUrl);

                $eventCode = new EventCode();
                $eventCode->link = $qrCodeUrl;
                $eventCode->code = $maSuKien;
                $eventCode->event_id = $eventId;
                $eventCode->save();

                // $qrCodes['qrcode_' . ($batch * $batchSize + $i)] = QrCode::size(120)->generate($qrCodeUrl);
            }

            // Giải phóng bộ nhớ sau mỗi lô
            flush();
        }

        return redirect()->route('qr-codes.show', ['id' => $eventId]);
    }

    public function show(String $id) {
        $qrCodes = [];
        $eventCodes = EventCode::where('event_id', $id)->get();
        foreach ($eventCodes as $eventCode) {
            // Tạo QR code từ đường dẫn link của event code
            $qrCodes[] = QrCode::size(120)->generate($eventCode->link);
        }
        return view('dashboards.admin.qr-codes.show', ['qrCodes' => $qrCodes]);
    }
}
