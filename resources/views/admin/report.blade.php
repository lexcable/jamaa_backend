@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="flex">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Reports</p></div>
            <div class="pb-3">
              <div class="flex border-b border-[#dde0e3] px-4 gap-8">
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-[#121416] text-[#121416] pb-[13px] pt-4" href="{{ route('admin.sales') }}">
                  <p class="text-[#121416] text-sm font-bold leading-normal tracking-[0.015em]">Sales Reports</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#6a7581] pb-[13px] pt-4" href="{{ route('reports.stock') }}">
                  <p class="text-[#6a7581] text-sm font-bold leading-normal tracking-[0.015em]">Stock Reports</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#6a7581] pb-[13px] pt-4" href="{{ route('customers.index') }}">
                  <p class="text-[#6a7581] text-sm font-bold leading-normal tracking-[0.015em]">Customer Reports</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#6a7581] pb-[13px] pt-4" href="{{ route('reports.revenue') }}">
                  <p class="text-[#6a7581] text-sm font-bold leading-normal tracking-[0.015em]">Revenue Reports</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#6a7581] pb-[13px] pt-4" href="{{ route('reports.expenses') }}">
                  <p class="text-[#6a7581] text-sm font-bold leading-normal tracking-[0.015em]">Expense Reports</p>
                </a>
              </div>
            </div>

        <form id="reportForm" method="GET" action="{{ route('reports.index') }}" class="mb-6 flex space-x-4">
            <div>
                <label for="start_date" class="block font-semibold mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="border rounded p-2" value="{{ request('start_date') }}">
            </div>
            <div>
                <label for="end_date" class="block font-semibold mb-1">End Date</label>
                <input type="date" id="end_date" name="end_date" class="border rounded p-2" value="{{ request('end_date') }}">
            </div>
            <div class="self-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate Report</button>
            </div>
        </form>

        @if(isset($orders) && $orders->count() > 0)
        <div>
            <h2 class="text-xl font-semibold mb-4">Report Preview</h2>
            <table class="w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border border-gray-200 text-left">Order ID</th>
                        <th class="p-3 border border-gray-200 text-left">Customer</th>
                        <th class="p-3 border border-gray-200 text-left">Date</th>
                        <th class="p-3 border border-gray-200 text-left">Total</th>
                        <th class="p-3 border border-gray-200 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr class="border border-gray-200 hover:bg-gray-50">
                        <td class="p-3 border border-gray-200">
                            <a href="{{ route('reports.show', $order->id) }}" class="text-indigo-600 hover:underline">#{{ $order->order_number }}</a>
                        </td>
                        <td class="p-3 border border-gray-200">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="p-3 border border-gray-200">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="p-3 border border-gray-200">${{ number_format($order->total, 2) }}</td>
                        <td class="p-3 border border-gray-200">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($order->status == 'Completed') bg-green-200 text-green-800
                                @elseif($order->status == 'Shipped') bg-blue-200 text-blue-800
                                @elseif($order->status == 'Pending') bg-yellow-200 text-yellow-800
                                @else bg-gray-200 text-gray-800 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>

            <div class="mt-6 space-x-4">
                <button class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Export as PDF</button>
                <button class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Export as CSV</button>
            </div>
        </div>
        @else
        <p>No reports found for the selected date range.</p>
        @endif

</div>
@endsection
