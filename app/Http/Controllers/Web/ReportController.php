<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends BaseController
{
  
    public function index(Request $request)
    {
        if ($redirect = $this->authorizeStaff()) {
            return $redirect;
        }

        $filters = [
            'from' => $request->query('from'),
            'to' => $request->query('to'),
            'room' => $request->query('room'),
            'status' => $request->query('status'),
        ];

        $query = Booking::with(['room', 'user', 'petugas']);

        // Filter tanggal (overlap range)
        if ($filters['from'] && $filters['to']) {
            $from = $filters['from'];
            $to = $filters['to'];
            $query->where(function ($q) use ($from, $to) {
                $q->where('tanggal_mulai', '<=', $to)
                  ->where('tanggal_selesai', '>=', $from);
            });
        } elseif ($filters['from']) {
            $query->where('tanggal_selesai', '>=', $filters['from']);
        } elseif ($filters['to']) {
            $query->where('tanggal_mulai', '<=', $filters['to']);
        }

      
        if ($filters['room']) {
            $query->where('id_room', $filters['room']);
        }

       
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        $bookings = $query->orderBy('tanggal_mulai', 'desc')->paginate(15)->withQueryString();
        $rooms = Room::orderBy('nama_room')->get();

        return view('reports.index', compact('bookings', 'rooms', 'filters'));
    }

    
    public function export(Request $request)
    {
        if ($redirect = $this->authorizeStaff()) {
            return redirect()->route('dashboard')->with('error', 'Tidak diizinkan.');
        }

        $filters = [
            'from' => $request->query('from'),
            'to' => $request->query('to'),
            'room' => $request->query('room'),
            'status' => $request->query('status'),
        ];

        $query = Booking::with(['room', 'user', 'petugas']);

        if ($filters['from'] && $filters['to']) {
            $from = $filters['from'];
            $to = $filters['to'];
            $query->where(function ($q) use ($from, $to) {
                $q->where('tanggal_mulai', '<=', $to)
                  ->where('tanggal_selesai', '>=', $from);
            });
        } elseif ($filters['from']) {
            $query->where('tanggal_selesai', '>=', $filters['from']);
        } elseif ($filters['to']) {
            $query->where('tanggal_mulai', '<=', $filters['to']);
        }

        if ($filters['room']) {
            $query->where('id_room', $filters['room']);
        }

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        $rows = $query->orderBy('tanggal_mulai', 'desc')->get();

        $filename = 'laporan_peminjaman_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
           
            fputcsv($handle, [
                'ID', 'Tanggal Mulai', 'Tanggal Selesai', 'Ruangan', 'Peminjam', 'Petugas', 'Status', 'Keterangan'
            ]);

            foreach ($rows as $b) {
                fputcsv($handle, [
                    $b->id_booking,
                    optional($b->tanggal_mulai)->format('Y-m-d'),
                    optional($b->tanggal_selesai)->format('Y-m-d'),
                    $b->room->nama_room ?? '-',
                    $b->user->username ?? ($b->user->nama ?? '-'),
                    $b->petugas->nama_petugas ?? '-',
                    $b->status,
                    trim(preg_replace('/\s+/', ' ', (string) $b->keterangan))
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
