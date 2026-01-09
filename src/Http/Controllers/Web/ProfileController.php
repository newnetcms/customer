<?php

namespace Newnet\Customer\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Newnet\Customer\Http\Requests\CustomerChangePasswordRequest;
use Newnet\Customer\Http\Requests\CustomerProfileRequest;
use Newnet\Customer\Http\Requests\CustomerRequest;
use Newnet\Customer\Repositories\CustomerRepositoryInterface;
use Newnet\Media\MediaUploader;

class ProfileController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    private $mediaUploader;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        MediaUploader $mediaUploader
    ) {
        $this->middleware(['auth:customer', 'verified']);
        $this->mediaUploader = $mediaUploader;
        $this->customerRepository = $customerRepository;
    }

    public function profile()
    {
        return view('customer::web.customer.profile');
    }

    public function update(CustomerProfileRequest $request)
    {
        $this->customerRepository->updateById($request->except(['email', 'avatar']), auth()->user()->id);
        if ($request->hasFile('avatar')) {
            if (explode('/', $request->file('avatar')->getClientMimeType())[0] == 'image') {
                $avatar = $this->mediaUploader->setFile($request->file('avatar'))->upload();
                $this->customerRepository->updateById(['avatar' => [$avatar->id]], auth("customer")->user()->id);
            }
        }
        return redirect()
            ->back()->with('success', __('customer::customer.notification.updated'));
    }

    public function changePassword()
    {
        return view('customer::web.customer.change-password');
    }

    public function updatePassword(CustomerChangePasswordRequest $request)
    {
        $this->customerRepository->updateById(['password' => ($request->password)], auth()->user()->id);
        return redirect()
            ->back()->with('success', __('customer::customer.notification.updated'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $this->mediaUploader->setFile($request->file('avatar'))->upload();
            $this->customerRepository->updateById(['avatar' => [$avatar->id]], auth("customer")->user()->id);

            return redirect()
                ->back()->with('success', __('customer::customer.notification.updated'));
        }

        return redirect()->back()->withErrors(['avatar' => __('customer::customer.notification.invalid_image')]);
    }
}
