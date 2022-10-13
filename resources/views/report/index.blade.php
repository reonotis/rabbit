<x-report-layout>
    <x-slot name="header" >
        <h2>日報</h2>
        <span class="reportDay">{{ \Carbon\Carbon::now()->format("Y年m月d") }}</span>
    </x-slot>

    <div class="p-4">
        <div class="flex" >
            <div class="reportContents reportContentsReport">
                <div class="reportContentCard">日報</div>
                <div class="reportContentBody">
                    <table class="reportTable">
                        <tr>
                            <th>残予約人数</th>
                            <td>{{ count($visitReserves) }}人</td>
                        </tr>
                        <tr>
                            <th>来店人数</th>
                            <td>{{ count($visitHistories) }}人</td>
                        </tr>
                        <tr>
                            <th>稼働スタイリスト人数</th>
                            <td>人</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="reportContents reportContentsReserve">
                <div class="reportContentCard">予約</div>
                <div class="reportContentBody">
                    @if(count($visitReserves))
                        <table class="reservesTable">
                            <tr>
                                <th>来店時間</th>
                                <th>お客様名</th>
                                <th>担当スタイリスト</th>
                                <th>対応メニュー</th>
                                <th>調整</th>
                            </tr>
                            @foreach($visitReserves as $reserves)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromTimeString($reserves->visit_time)->format("H:i") }}</td>
                                    <td>{{ $reserves->customer_name }}</td>
                                    <td>{{ $reserves->user_name }}</td>
                                    <td></td>
                                    <td>
                                        <div class="flex" >
                                            <a href="{{ route('reserve.visited', ['visitReserve'=>$reserves->id]) }}" class="min-btn edit-btn">詳細</a>　
                                            <a href="{{ route('reserve.visited', ['visitReserve'=>$reserves->id]) }}" class="min-btn register-btn">来店済み</a>　
                                            <a href="{{ route('reserve.destroy', ['visitReserve'=>$reserves->id]) }}" class="min-btn delete-btn">削除</a>　
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        本日の予約はありません
                    @endif
                </div>
            </div>
        </div>
        <div class="reportContents">
            <div class="reportContentCard">来店情報</div>
            <div class="reportContentBody">
                @if(count($visitHistories))
                    <table class="reservesTable">
                        <tr>
                            <th>来店時間</th>
                            <th>お客様名</th>
                            <th>担当スタイリスト</th>
                            <th>対応メニュー</th>
                            <th>調整</th>
                        </tr>
                        @foreach($visitHistories as $history)
                            <tr>
                                <td>{{ \Carbon\Carbon::createFromTimeString($history->visit_time)->format("H:i") }}</td>
                                <td>{{ $history->customer_name }}</td>
                                <td>{{ $history->user_name }}</td>
                                <td></td>
                                <td>
                                    <div class="flex" >
                                        <a href="" class="min-btn edit-btn">次の予約を取得</a>　
                                        <a href="" class="min-btn edit-btn">次の予約を確認</a>　
                                        <a href="" class="min-btn edit-btn">詳細</a>　
                                        <a href="" class="min-btn delete-btn">削除</a>　
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    本日の予約はありません
                @endif
            </div>
        </div>
    </div>

</x-report-layout>

