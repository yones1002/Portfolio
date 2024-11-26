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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex space-x-4" style="float: right">
                    <!-- دکمه لیست ارزها -->
                    <a href="{{ route('cryptocurrency.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        لیست ارزها
                    </a>

                    <!-- دکمه اضافه کردن و ویرایش ارز -->
                    <a href="{{ route('cryptocurrency.create') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-500 border border-transparent rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        اضافه کردن / ویرایش ارز
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


