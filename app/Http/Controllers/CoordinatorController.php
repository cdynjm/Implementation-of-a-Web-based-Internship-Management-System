<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CoordinatorService;

class CoordinatorController extends Controller
{
    protected $CoordinatorService;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(CoordinatorService $CoordinatorService) {
        $this->CoordinatorService = $CoordinatorService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getCoordinator() {
        return $this->CoordinatorService->getCoordinatorService();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCoordinator(Request $request) {
        return $this->CoordinatorService->createCoordinatorService($request);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCoordinator(Request $request) {
        return $this->CoordinatorService->updateCoordinatorService($request);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteCoordinator(Request $request) {
        return $this->CoordinatorService->deleteCoordinatorService($request);
    }
}
