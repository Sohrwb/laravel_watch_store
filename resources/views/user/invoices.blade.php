@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>فاکتورهای من</h2>

        <div class="accordion" id="invoiceAccordion">
            @foreach ($invoices as $invoice)
                @php
                    $statusClass = $invoice->status === 'paid' ? 'bg-success text-white' : 'bg-secondary text-dark';
                    $invoiceId = 'invoice' . $invoice->id;
                @endphp

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading{{ $invoice->id }}">
                        <button class="accordion-button collapsed {{ $statusClass }}" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $invoice->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $invoice->id }}">
                            فاکتور شماره: {{ $invoice->invoice_number }}
                            - تاریخ: {{ $invoice->created_at->format('Y-m-d') }}
                            - وضعیت: {{ $invoice->status === 'paid' ? 'پرداخت شده' : ' ناموفق بوده' }}


                        <span class="mx-auto text-black">
                            جمع کل: {{ number_format($invoice->total_price) }} تومان
                        </span>
                        </button>

                    </h2>

                    <div id="collapse{{ $invoice->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $invoice->id }}" data-bs-parent="#invoiceAccordion">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>نام محصول</th>
                                        <th>تعداد</th>

                                        <th>قیمت کل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->cartItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->count }}</td>
                                            <td>{{ number_format($item->total_price) }} تومان</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
