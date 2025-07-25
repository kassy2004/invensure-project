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
        ->where('status', 'incomplete')
        ->get();
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

        $usertype = null;
        $status = null;
        $pod_number = $request->input('pod_number');

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


        $success = DB::table('signature')
            ->insert([
                'pod_number' => '000' . $request->input('pod_number'),
                'name' => $request->input('name'),
                'signature' => 'img/sign/' . $filename,
                'type' => $request->input('type'),
                'created_at' => now(),
                'updated_at' => now(),

            ]);
// dd($request->input('pod_number'));
        $orderId = DB::table('pod')
        ->where('pod_number', '000' .$request->input('pod_number'))
        ->first();
        // dd($orderId);



        if ($status === 'completed') {
            DB::table('pod')
                ->where('pod_number', '000' . $request->input('pod_number'))
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

            DB::table('orders')
                ->where('order_id', $orderId->order_id)
                ->update([
                    'status' => 'delivered',
                    'updated_at' => now(),
                ]);

                DB::table('notifications')
                ->insert([
                    'user_id' => auth()->id(),
                    'for' =>'logistics_coordinator',
                    'title' => 'Order Delivered',
                    'message' => 'Order # '. $orderId->order_id . ' has been delivered',
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
