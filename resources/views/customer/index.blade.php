<x-customer-layout>
    <x-slot name="header"><h2>顧客</h2></x-slot>

    <div class="p-4">
        <div class="p-4"><a href="{{ route('customer.create') }}">顧客を登録する</a></div>
        <div class="p-4">
            <div class="p-4">
                <form action="" method="get" >
                    <table class="customer_search_tbl" >
                        <tr>
                            <th>顧客番号</th>
                            <td>
                                <div class="w-48" >
                                    {{ Form::text('customer_no', request('customer_no'), [
                                            'id' => 'customer_no',
                                        ])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>名前</th>
                            <td>
                                <div class="flex" >
                                    <div class="w-40 pr-1" >
                                        {{ Form::text('f_name', request('f_name'), [
                                                'id' => 'f_name',
                                            ])
                                        }}
                                    </div>
                                    <div class="w-40 pl-1" >
                                        {{ Form::text('l_name', request('l_name'), [
                                                'id' => 'l_name',
                                            ])
                                        }}
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-40 pr-1" >
                                        {{ Form::text('f_read', request('f_read'), [
                                                'id' => 'f_read',
                                            ])
                                        }}
                                    </div>
                                    <div class="w-40 pl-1" >
                                        {{ Form::text('l_read', request('l_read'), [
                                                'id' => 'l_read',
                                            ])
                                        }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>性別</th>
                            <td>
                                <div class="flex">
                                    <label>
                                        <input type="radio" name="sex" value="0" checked >指定なし
                                    </label>
                                    @foreach(Common::SEX_LIST as $sexId => $sexName)
                                        <label>
                                            <input type="radio" name="sex" value="{{ $sexId }}" {{ (request('sex') == $sexId)? 'checked': '' }} >{{ $sexName }}
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <div class="w-64" >
                                    {{ Form::text('email', request('email'), [
                                            'id' => 'email',
                                        ])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <div class="w-40" >
                                    {{ Form::text('tel', request('tel'), [
                                            'id' => 'tel',
                                        ])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="staff_charge">担当スタイリスト</label></th>
                            <td>
                                <div class="w-40" >
                                    {{ Form::select('staff_charge', $userList,
                                        request('staff_charge'),
                                        [
                                            'id' => 'staff_charge',
                                        ])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>多店舗の顧客を含める</th>
                            <td>
                                <div class="w-40" >
                                    <label>
                                        {{ Form::checkbox('other_shop', true,
                                            request('other_shop'),
                                            [
                                                'id' => 'staff_charge',
                                            ])
                                        }}含める
                                    </label>
                                </div>
                            </td>
                        </tr>
                        {{-- <tr>--}}
                        {{--     <th>来店日</th>--}}
                        {{--     <td>--}}
                        {{--         <div class="flex items-center" >--}}
                        {{--             <div class="w-40 pr-1" >--}}
                        {{--                 <input type="date" name="from_date" value="{{ request('from_date') }}" >--}}
                        {{--             </div>--}}
                        {{--             <div class="" >～</div>--}}
                        {{--             <div class="w-40 pl-1" >--}}
                        {{--                 <input type="date" name="for_date" value="{{ request('for_date') }}" >--}}
                        {{--             </div>--}}
                        {{--         </div>--}}
                        {{--     </td>--}}
                        {{-- </tr>--}}
                    </table>
                    <div class="flex mt-4">
                        <input type="submit" value="検索" class="register-btn">
                    </div>
                </form>
            </div>
            <div class="p-4">
                <table class="customer-list-tbl" >
                    <thead>
                        <tr>
                            <th>顧客番号</th>
                            <th>名前</th>
                            <th>担当者</th>
                            <th>最終来店日</th>
                            <th>確認</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers AS $customer)
                            <tr>
                                <td>{{ $customer->customer_no }}</td>
                                <td>
                                    {!! $customer->f_name . '&nbsp;' . $customer->l_name !!}
                                    (<span class="customer_read" >{!! $customer->f_read . '&nbsp;' . $customer->l_read !!}</span>)様
                                </td>
                                <td>{{ $customer->name }}</td>
                                <td></td>
                                <td><a href="{{ route('customer.show', ['customer' => $customer->id]) }}" >確認</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-customer-layout>

