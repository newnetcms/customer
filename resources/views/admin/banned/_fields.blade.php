<input type="hidden" name="customer_id" value="{{ $item->customer_id }}">

<div class="form-horizontal">
    <div class="alert alert-info">
        <div>Tài khoản: <strong>{{ object_get($item, 'customer.name') }}</strong></div>
        @if ($email = object_get($item, 'customer.email'))
            <div>Email: <strong>{{ $email }}</strong></div>
        @endif
        @if ($phone = object_get($item, 'customer.phone'))
            <div>SĐT: <strong>{{ $phone }}</strong></div>
        @endif
    </div>

    @textarea(['name' => 'reason', 'label' => __('customer::banned.reason')])
    @checkbox(['name' => 'is_forever', 'label' => __('customer::banned.is_forever')])
    @datetimeinput(['name' => 'expired_at', 'label' => __('customer::banned.expired_at')])
</div>
