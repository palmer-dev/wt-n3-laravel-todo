<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserFilter
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $model, string $column, string $output_name): Response
    {
        $user = Auth::user();

        $modelClass = 'App\\Models\\' . $model;

        if (!class_exists($modelClass)) {
            abort(500, "Model '$model' not found.");
        }

        if (!in_array($column, app($modelClass)->getFillable())) {
            abort(500, "Column '$column' not found in the model.");
        }

        $items = $modelClass::where($column, $user->id)->paginate(5);

        view()->share($output_name, $items);

        return $next($request);
    }
}
