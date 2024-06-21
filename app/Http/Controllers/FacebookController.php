<?php

// app/Http/Controllers/FacebookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FacebookService;

class FacebookController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function postToFacebook(Request $request)
    {
        $pageId = 'your-page-id'; // Replace with your actual Page ID
        $message = $request->input('message');
        $link = $request->input('link');
        $imagePath = $request->file('image')->path(); // Assuming you have an input file for image

        $postId = $this->facebookService->publishToPage($pageId, $message, $link, $imagePath);

        return response()->json(['post_id' => $postId]);
    }
}
