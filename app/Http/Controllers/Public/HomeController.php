<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\PackageService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly PackageService $packageService) {}

    public function index(): View
    {
        $packages = $this->packageService->getActivePackages();

        return view('welcome', compact('packages'));
    }
}
