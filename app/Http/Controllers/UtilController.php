<?php

namespace App\Http\Controllers;

use App\Helpers\FormatResponse;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UtilController extends Controller
{
    public function upload_image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs(
            'uploads',
            $request->user()->id . '_' . $name
        );
        $request->user()->images()->create([
            'name' => $name,
            'path' => $path
        ]);
        return response()->json(FormatResponse::success([
            'name' => $name,
            'path' => $path
        ]));
    }

    public function QRCode(Request $request){
        $response = Response::make(QrCode::format('png')->size(100)->generate($request->input('url')), 200);
        $response->header('Content-Type', 'image/png');
        return $response;
    }
}
