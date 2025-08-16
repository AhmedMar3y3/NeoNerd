<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('Admin.banners.index', compact('banners'));
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return response()->json($banner);
    }

    public function store(StoreBannerRequest $request)
    {
        Banner::create($request->validated());
        return redirect()->route('admin.banners.index')->with('success', 'تم إضافة البانر بنجاح');
    }

    public function update(UpdateBannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update($request->validated());
        return redirect()->route('admin.banners.index')->with('success', 'تم تحديث البانر بنجاح');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'تم حذف البانر بنجاح');
    }
}
