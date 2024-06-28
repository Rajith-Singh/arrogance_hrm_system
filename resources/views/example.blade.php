<!-- jQuery UI CSS -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- jQuery and jQuery UI JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<x-app-layout>
    <x-hr-sidebar />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-semibold mb-6">Example Form</h1>
                    
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('example.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="holiday_date" class="block text-sm font-medium text-gray-700">Holiday Date</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var holidays = @json(\App\Models\Holiday::pluck('holiday_date')->toArray());
    </script>
    <script src="{{ asset('js/date-picker.js') }}"></script>

    <script>
    // Initialize date picker
        $(function() {
            function isHolidayOrWeekend(date) {
                var day = date.getDay();
                var dateString = $.datepicker.formatDate('yy-mm-dd', date);
                return (day === 0 || day === 6 || holidays.includes(dateString));
            }

            var holidays = @json(\App\Models\Holiday::pluck('holiday_date')->toArray());

            $('#start_date, #end_date').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0, // Ensures today and future dates are selectable
                beforeShowDay: function(date) {
                    return [!isHolidayOrWeekend(date), ''];
                }
            });
        });
    </script>

</x-app-layout>

