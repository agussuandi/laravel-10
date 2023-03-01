<?php

namespace App\Http\Controllers\Panel\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MObat;

class NotificationController extends Controller
{
    public function __construct(
        private $viewsPath = 'panel.pages.notification'
    )
    {}

    public function index()
    {
        try
        {
            $obats = MObat::with('dosis')
                ->stockAlert()
            ->get();

            return response()->json([
                'view' => view("{$this->viewsPath}._index", ['obats' => $obats])->render(),
                'status' => count($obats) > 0 ? true : false
            ]);
        }
        catch (\Throwable $th)
        {
            abort(500, $th->getMessage());
        }
    }
}