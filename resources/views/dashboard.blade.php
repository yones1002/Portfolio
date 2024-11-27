<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('پنل مدیریت') }}
            </h2>
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('cryptocurrency.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    لیست ارزها
                </a>
                <a href="{{ route('cryptocurrency.create') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-500 border border-transparent rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    اضافه کردن / ویرایش ارز
                </a>
            </div>
        </div>
    </x-slot>
    
</x-app-layout>


