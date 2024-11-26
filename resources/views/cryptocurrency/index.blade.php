<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" style="font-family: Vazir;">
                {{ __('پنل مدیریت') }}
            </h2>
            <div class="flex space-x-2 rtl:space-x-reverse" style="font-family: Vazir;">
                <a href="{{ route('cryptocurrency.create') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-500 border border-transparent rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    اضافه کردن
                </a>
                <a href="{{ route('cryptocurrency.updateAll') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-500 border border-transparent rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    آپدیت قیمت ها
                </a>
            </div>
        </div>
    </x-slot>
    <div class="py-12 flex justify-center items-center" style="font-family: Vazir;text-align: right">
        <div class="max-w-7xl w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('message'))
                    <div id="flash-message" class="fixed top-5 right-5 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50" style="display: none;">
                        {{ session('message') }}
                    </div>
                @endif
                <table class="table table-report -mt-2 w-full text-center" style="border: solid 1px darkblue;color: white" dir="rtl">
                    <thead class="bg-gray-900 text-white">
                    <tr>
                        <th class="whitespace-no-wrap py-3 px-10">ردیف</th>
                        <th class="text-center py-3 px-10">نام</th>
                        <th class="text-center py-3 px-10">رنک ارز</th>
                        <th class="text-center py-3 px-10">سیمبل</th>
                        <th class="text-center py-3 px-10">قیمت(دلار)</th>
                        <th class="text-center py-3 px-10">تاریخ ایجاد</th>
                        <th class="text-center py-3 px-10">فعالیت</th>
                    </tr>
                    </thead>
                    <tbody class="space-y-10">
                    @if(count($list) != 0)
                        @foreach($list as $key => $value)
                            <tr class="intro-x" id="row-{{$value->id}}">
                                <td class="w-40 py-3 px-10">{{$value->id}}</td>
                                <td class="py-3 px-10">{{$value->fa_name}}</td>
                                <td class="py-3 px-10">{{$value->rank}}</td>
                                <td class="py-3 px-10">{{$value->symbol}}</td>
                                <td class="py-3 px-10">{{$value->current_price}}</td>
                                <td class="py-3 px-10">
                                    <?php $jdf = new \App\lib\Jdf(); ?>
                                    {{$jdf->jdate('Y/m/d', strtotime($value->created_at))}}
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3" target="_blank" href="{{ route('cryptocurrency.edit', $value->id) }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i> ویرایش
                                        </a>
                                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" onclick="destroy({{ $value->id }})" data-target="#delete-confirmation-modal">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> حذف
                                        </a>
                                    </div>
                                    <form id="delete-form-{{ $value->id }}" action="{{ route('cryptocurrency.destroy', $value->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="intro-x">
                            <td colspan="7" class="text-center py-3 px-4">
                                آیتمی ثبت نشده است.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function destroy(id) {
        if (confirm('Are you sure you want to delete this cryptocurrency?')) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>
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
