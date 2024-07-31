<?php

namespace Newnet\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Customer\CustomerAdminMenuKey;
use Newnet\Customer\Http\Requests\BannedRequest;
use Newnet\Customer\Models\Banned;
use Newnet\Customer\Repositories\BannedRepository;

class BannedController extends Controller
{
    protected BannedRepository $bannedRepository;

    public function __construct(BannedRepository $bannedRepository)
    {
        $this->bannedRepository = $bannedRepository;
    }

    public function index(Request $request)
    {
        $items = $this->bannedRepository->paginate($request->input('max', 20));

        return view('customer::admin.banned.index', compact('items'));
    }

    public function create(Request $request)
    {
        AdminMenu::activeMenu(CustomerAdminMenuKey::CUSTOMER_INDEX);

        if (!$request->input('customer_id')) {
            return back();
        }

        $item = new Banned();
        $item->customer_id = $request->input('customer_id');

        return view('customer::admin.banned.create', compact('item'));
    }

    public function store(BannedRequest $request)
    {
        $data = $request->all();
        $data['user_ban_id'] = get_current_admin_id();

        $item = $this->bannedRepository->create($data);

        return redirect()
            ->route('customer.admin.banned.edit', [
                'banned' => $item,
                'edit_locale' => $request->input('edit_locale'),
            ])
            ->with('success', __('customer::banned.notification.created'));
    }

    public function edit($id)
    {
        AdminMenu::activeMenu(CustomerAdminMenuKey::CUSTOMER_INDEX);

        $item = $this->bannedRepository->find($id);

        return view('customer::admin.banned.edit', compact('item'));
    }

    public function update(BannedRequest $request, $id)
    {
        $this->bannedRepository->updateById($request->all(), $id);

        return back()->with('success', __('customer::banned.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->bannedRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('customer::banned.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('customer.admin.banned.index')
            ->with('success', __('customer::banned.notification.deleted'));
    }
}
