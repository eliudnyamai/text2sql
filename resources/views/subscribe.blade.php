<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
     

<div class="max-w-sm p-6 bg-white border  border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
<a href={{$checkout}} target="_blank">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Convenient Text To SQL Conversion</h5>
    </a>
    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">This Subscription Only Costs $10 per year</p>
    <a href={{$checkout}} target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        SUBSCRIBE
    </a>
</div>



</x-guest-layout>

