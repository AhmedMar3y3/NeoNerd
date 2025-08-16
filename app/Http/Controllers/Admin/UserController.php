<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['university', 'college', 'grade', 'subscriptions'])
            ->withCount(['subscriptions', 'activeSubscriptions']);

        $filter = new UserFilter();
        $filter->apply($request, $query);
        $users = $query->paginate(15);
        $filterOptions = $filter->getFilterOptions();

        return view('Admin.users.index', compact('users', 'filterOptions'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'مفعل' : 'معطل';
        return redirect()->route('admin.users.index')->with('success', "تم {$status} المستخدم بنجاح");
    }

    public function show($id)
    {
        $user = User::with(['university', 'college', 'grade', 'subscriptions.course', 'subscriptions.book'])
            ->withCount(['subscriptions', 'activeSubscriptions'])
            ->findOrFail($id);

        return view('Admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->activeSubscriptions()->count() > 0) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف المستخدم لوجود اشتراكات نشطة');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
