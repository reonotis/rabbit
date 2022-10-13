<x-customer-layout>
    <x-slot name="header">
        <h2>顧客情報</h2>
    </x-slot>

    <div class="p-4">
        <div class="customer-menu-tab-area" >
            <div class="customer-menu-tab active" >基本情報</div>
            <div class="customer-menu-tab" >来店履歴</div>
        </div>
        <div class="customer-contents-area">
            <div class="customer-content">
                <div class="customerContentsArea" >
                    <div class="customer_row">
                        <div class="customer_title">顧客番号</div>
                        <div class="customer_contents">{{ $customer->customer_no }}</div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">顧客名</div>
                        <div class="customer_contents">
                            <div class="">{!! $customer->f_name . '&nbsp;' . $customer->l_name !!}&nbsp;<span class="">({!! $customer->f_read . '&nbsp;' . $customer->l_read !!})</span></div>
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">性別</div>
                        <div class="customer_contents">
                            @if($customer->sex == 0)
                                不明
                            @elseif(!empty($customer->sex))
                                {{ Common::SEX_LIST[$customer->sex] }}
                            @endif
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">担当スタイリスト</div>
                        <div class="customer_contents">{{ $customer->staff_charge }}</div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">電話番号</div>
                        <div class="customer_contents">{{ $customer->tel }}</div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">住所</div>
                        <div class="customer_contents">
                            {!! $customer->zip21 . '-' . $customer->zip22 !!}<br>
                            {!! $customer->pref21 . '&nbsp;' . $customer->address21 . '&nbsp;' . $customer->street21 !!}
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">備考</div>
                        <div class="customer_contents">
                            {!! $customer->memo !!}
                        </div>
                    </div>
                    <div class="flex">
                        <input type="submit" value="編集" class="edit-btn" >
                    </div>
                </div>
            </div>
            <div class="customer-content" style="display: none;">
                <div class="customerContentsArea" >
                    <div class="customer-visit-history-title" >予約</div>
                    <div class="" >予約がある場合の表を作成中</div>
                    <table class="visit-list-tbl" ></table>
                    <div class="customer-visit-history-title" >来店履歴</div>
                    <table class="visit-list-tbl" >
                        <thead>
                            <tr>
                                <th>来店日</th>
                                <th>来店時間</th>
                                <th>店舗</th>
                                <th>メニュー</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitHistories AS $visitHistory)
                                <tr>
                                    <td>{{ $visitHistory->visit_date->format('Y/m/d') }}</td>
                                    <td>{{ $visitHistory->visit_time->format('H:i') }}</td>
                                    <td>{{ $visitHistory->shop_name}}</td>
                                    <td>{{ $visitHistory->menu_name}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="w-1/2">
        </div>
    </div>

</x-customer-layout>





