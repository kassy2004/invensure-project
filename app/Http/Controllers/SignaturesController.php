<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SignaturesController extends Controller
{
    public function index()
    {
        $pod = DB::table('pod')
            ->leftJoin('truck_loading', DB::raw("CONCAT('ALLOC-', pod.order_id)"), '=', 'truck_loading.allocation_id')
            ->leftjoin('signature', 'pod.pod_number', '=', 'signature.pod_number')
            ->select(
                'pod.id',
                'pod.pod_number',
                'pod.order_id',
                'pod.status',
                'pod.created_at',
                'pod.updated_at',
                'truck_loading.truck_id',
                DB::raw("GROUP_CONCAT(signature.type) as signed_types")
            )

            ->where('pod.status', 'incomplete')
            ->groupBy(
                'pod.id',
                'pod.pod_number',
                'pod.order_id',
                'pod.status',
                'pod.created_at',
                'pod.updated_at',
                'truck_loading.truck_id'
            )
            ->get();
        foreach ($pod as $p) {
            $p->signed_types = $p->signed_types ? explode(',', $p->signed_types) : [];
        }
        // dd($pod);
        return view('logistic.signatures', compact('pod'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'signature_path' => 'required|string',
            'type' => 'required|string',
            'name' => 'required|string',
            'pod_number' => 'required',
        ]);
        $truck_id = $request->input('truck_id');
        // dd($truck_id);
        $usertype = null;
        $status = null;
        $pod_number = $request->input('pod_number');
        // dd($pod_number);

        if ($request->input('type') === 'driver') {
            $usertype = 'DR';
        } elseif ($request->input('type') === 'customer') {
            $usertype = 'CM';
            $status = 'completed';
        } elseif ($request->input('type') === 'planner') {
            $usertype = 'PL';
        }
        $dataUrl = $request->input('signature_path');

        if (preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $type)) {
            $data = substr($dataUrl, strpos($dataUrl, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                return back()->with('error', 'Invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                return back()->with('error', 'Base64 decode failed');
            }
        } else {
            return back()->with('error', 'Invalid image data');
        }

        // Make sure the directory exists
        $directory = public_path('img/sign');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create filename
        $filename = 'signature_' . $usertype . '_' . $pod_number . '.' . $type;
        // dd($filename);
        $filepath = $directory . '/' . $filename;

        // Save the file
        File::put($filepath, $data);


        // dd($pod_number);

        $success = DB::table('signature')
            ->insert([
                'pod_number' => $request->input('pod_number'),
                'name' => $request->input('name'),
                'signature' => 'img/sign/' . $filename,
                'type' => $request->input('type'),
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        // dd($request->input('pod_number'));
        $orderId = DB::table('pod')
            ->where('pod_number', $request->input('pod_number'))
            ->first();
        // dd($orderId);



        if ($status === 'completed') {
            DB::table('pod')
                ->where('pod_number', $request->input('pod_number'))
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                ]);
            // dd($orderId->order_id);

            DB::table('truck_loading')
                ->where('allocation_id', 'ALLOC-' . $orderId->order_id)
                ->update([
                    'status' => 'delivered',
                    'updated_at' => now(),
                ]);
            DB::table('truck')
                ->where('id', $truck_id)
                ->update([
                    'status' => 'available',
                    'updated_at' => now(),
                ]);

            DB::table('orders')
                ->where('order_id', $orderId->order_id)
                ->update([
                    'status' => 'delivered',
                    'updated_at' => now(),
                ]);

            DB::table('notifications')
                ->insert([
                    'user_id' => auth()->id(),
                    'for' => 'logistics_coordinator',
                    'title' => 'Order Delivered',
                    'message' => 'Order # ' . $orderId->order_id . ' has been delivered',
                    'type' => 'info',
                    'created_at' => now(),
                ]);
        }

        if ($success) {

            return back()->with('success', 'Signature successfully submitted!');
        } else {
            return back()->with('error', 'Error submitting signatures');
        }

    }
}
