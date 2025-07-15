<div class="h-screen bg-gray-900 text-white w-64 flex flex-col fixed">
    <div class="text-center py-4 font-bold text-xl border-b border-gray-700">
        Supermarket Admin
    </div>

    <nav class="flex-1 px-4 py-6 space-y-4">
        <a href="/admin/dashboard" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('admin/dashboard') ? 'bg-gray-700' : '' }}">
            Home
        </a>
        <a href="/budget" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('budget') ? 'bg-gray-700' : '' }}">
            Budget
        </a>
        <a href="/sales" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('sales') ? 'bg-gray-700' : '' }}">
            Sales
        </a>
        <a href="/expenses" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('expenses') ? 'bg-gray-700' : '' }}">
            Expenses
        </a>
        <a href="/stocks" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('stocks') ? 'bg-gray-700' : '' }}">
            Stocks
        </a>
        <a href="/products" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('products') ? 'bg-gray-700' : '' }}">
            Products
        </a>
        <a href="/orders" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('Orders') ? 'bg-gray-700' : '' }}"">
            Orders
        </a>
        <a href="/customers" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('Customers') ? 'bg-gray-700' : '' }}"">
            Customers
        </a>
        <a href="/reports" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('Reports') ? 'bg-gray-700' : '' }}"">
            Reports
        </a>
        <a href="/team" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('Team') ? 'bg-gray-700' : '' }}"">
            Team
        </a>
    </nav>
</div>
