<div class="bg-blue-200 shadow-md rounded-lg p-6">
    <h2 class="text-xl lg:text-2xl font-semibold text-blue-800 mb-4">Remaining Leaves</h2>
    @if ((auth()->user()->category == 'internship') || (auth()->user()->category == 'probation'))
        <table class="table table-responsive-sm table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Leave Type</th>
                    <th>Leaves Taken</th>
                    <th>Remaining Leaves</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $remainingLeaves['Leave Type'] }}</td>
                    <td>{{ $remainingLeaves['Leaves Taken'] }}</td>
                    <td class="{{ $remainingLeaves['Remaining Leaves'] == 0 ? 'text-danger' : '' }}">
                        {{ $remainingLeaves['Remaining Leaves'] }}
                    </td>
                    <td class="{{ $remainingLeaves['Status'] == 'No Pay' ? 'text-danger' : '' }}">
                        {{ $remainingLeaves['Status'] }}
                    </td>
                </tr>
            </tbody>
        </table>
    @elseif (auth()->user()->category == 'permanent')
        <table class="table table-responsive-sm table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Leave Type</th>
                    <th>Total Allocated</th>
                    <th>Allocated per month</th>
                    <th>Leaves Taken</th>
                    <th>Remaining Leaves</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($remainingLeaves as $type => $data)
                    @php
                        $allocated = $data['Total Allocated'];
                        $taken = $data['Leaves Taken'];
                        $rowClass = $allocated <= $taken ? 'text-danger' : '';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>{{ $type }}</td>
                        <td>{{ $allocated }}</td>
                        <td>{{ $data['Allocated per month'] }}</td>
                        <td>{{ $taken }}</td>
                        <td>{{ $data['Remaining Leaves'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
