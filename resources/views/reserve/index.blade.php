<x-reserve-layout>
    <x-slot name="header" >
        <h2>予約確認</h2>
        <span class="reportDay">{{ $timeArray[0]->format("Y年m月d") }}</span>
    </x-slot>

    <div class="p-4">
        <div class="reserveContentsArea flex">

            <div class="reserveContents" >
                <div class="reserveContentsHeader" >
                    <div class="reserveUserName" >スタッフ名</div>
                    @foreach( $timeArray AS $time)
                        <div class="reserveHeaderContents" >{{ $time->format("H:i") }}</div>
                    @endforeach
                </div>
                <div class="reserveContentsBody" >
                    @foreach( $reserveUsers AS $username => $userReserves)
                        <div class="reserveUsers">
                            <div class="reserveUserName {{ count($userReserves) }}">{{ $username }}</div>
                            <div class="" >
                                @foreach( $userReserves AS $count => $reserves)
                                    <div class="userReserves flex" >
                                        @foreach( $timeArray AS $timeKey => $time)
                                            <div class="usersTime" >
                                                @foreach($reserves as $key => $reserve)
                                                    @if($reserve['visit_time'] <= $time->format('H:i:s'))
                                                        @php
                                                            $class = "reserveBox ";
                                                        @endphp
                                                        @if( \Carbon\Carbon::createFromTimeString($reserve['finish_time'])->format('H:i')  > $endTime->format('H:i'))
                                                            @php
                                                                    $class .= " section_" . (count($timeArray) - $timeKey) . " section_over";
                                                            @endphp
                                                        @else
                                                            @php
                                                                $class .= " section_" . $reserve['time_section'];
                                                            @endphp
                                                        @endif
                                                        <div class="{{ $class }}" id="{{ $reserve['id'] }}" >
{{--                                                            {{ \Carbon\Carbon::createFromTimeString($reserve['visit_time'])->format('H:i') }} ~ --}}
{{--                                                            ~ {{ \Carbon\Carbon::createFromTimeString($reserve['finish_time'])->format('H:i') }}　--}}
                                                            {{ $reserve['customer_name'] }}
                                                        </div>
                                                        @php
                                                            unset($reserves[$key]);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-reserve-layout>
