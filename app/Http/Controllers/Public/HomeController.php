<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Services\PackageService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly PackageService $packageService) {}

    public function index(): View
    {
        $packages = $this->packageService->getActivePackages();
        $templates = Template::with('packages')->where('is_active', true)->get();

        return view('welcome', compact('packages', 'templates'));
    }
}
