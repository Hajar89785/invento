<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->memberDashboard();
    }

    /**
     * Admin dashboard with summary stats.
     */
    private function adminDashboard()
    {
        $totalItems = Item::count();
        $totalStock = Item::sum('stock');
        $totalCategories = Category::count();
        $lowStockItems = Item::where('stock', '<=', 5)->with('category')->get();
        $recentItems = Item::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalStock',
            'totalCategories',
            'lowStockItems',
            'recentItems'
        ));
    }

    /**
     * Member dashboard with catalog overview.
     */
    private function memberDashboard()
    {
        $categories = Category::withCount('items')->get();
        $items = Item::with('category')->where('stock', '>', 0)->latest()->paginate(12);

        return view('member.dashboard', compact('categories', 'items'));
    }
}

