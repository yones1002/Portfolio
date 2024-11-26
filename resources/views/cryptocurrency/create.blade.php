<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ایجاد/ویرایش صرافی ارز دیجیتال') }}
            </h2>
            <a href="{{ route('cryptocurrency.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600">
                بازگشت به لیست
            </a>
        </div>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="py-12" style="text-align: right">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($cryptocurrency) ? route('cryptocurrency.update', $cryptocurrency->id) : route('cryptocurrency.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($cryptocurrency))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 rtl text-right">
                        <div>
                            <label for="fa_name" class="block text-sm font-medium text-gray-200">نام ارز فارسی</label>
                            <input type="text" id="fa_name" name="fa_name"
                                   value="{{ isset($cryptocurrency) ? $cryptocurrency->fa_name : old('fa_name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-200">نام ارز انگلیسی</label>
                            <input type="text" id="name" name="name"
                                   value="{{ isset($cryptocurrency) ? $cryptocurrency->name : old('name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="rank" class="block text-sm font-medium text-gray-200">رنک ارز</label>
                            <input type="number" id="rank" name="rank"
                                   value="{{ isset($cryptocurrency) ? $cryptocurrency->rank : old('rank') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="symbol" class="block text-sm font-medium text-gray-200">سیمبل ارز</label>
                            <input type="text" id="symbol" name="symbol"
                                   value="{{ isset($cryptocurrency) ? $cryptocurrency->symbol : old('symbol') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-200">وضعیت ارز</label>
                            <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option
                                    {{ isset($cryptocurrency) && $cryptocurrency->status == 1 ? 'selected' : '' }} value="1">
                                    فعال
                                </option>
                                <option
                                    {{ isset($cryptocurrency) && $cryptocurrency->status == -1 ? 'selected' : '' }} value="-1">
                                    پیش نویس
                                </option>
                                <option
                                    {{ isset($cryptocurrency) && $cryptocurrency->status == 0 ? 'selected' : '' }} value="0">
                                    غیر فعال
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-200">توضیحات کوتاه ارز</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ isset($cryptocurrency) ? $cryptocurrency->description : old('description') }}</textarea>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            {{ isset($cryptocurrency) ? 'ویرایش' : 'ذخیره' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'block';
                setTimeout(() => {
                    flashMessage.style.opacity = '0';
                    setTimeout(() => {
                        flashMessage.remove();
                    }, 1000);
                }, 3000);
            }
        });
    </script>
</x-app-layout>
