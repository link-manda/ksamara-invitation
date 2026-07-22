<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Repositories\PackageRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly PackageRepository $packageRepository) {}

    public function index(): View
    {
        $packages = $this->packageRepository->getAll();

        return view('welcome', compact('packages'));
    }
}
