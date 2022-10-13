<x-user-layout>
    <x-slot name="header"><h2>スタッフ登録</h2></x-slot>
    <div class="p-4">
        <div class="p-4">
            <div class="p-4">
                    {{ Form::open([
                        'route' => ['user.update', 'user' => $user->id],
                        'method'=> 'PUT'])
                    }}
                    <table class="w-1/2 m-auto user_search_tbl" >
                        <tr>
                            <th>名前</th>
                            <td>
                                <div class="w-full pr-1" >
                                    {{ Form::text(
                                        'name',
                                        old('name')? old('name'): $user->name,
                                        ['class' => 'form-control'])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <div class="w-full pr-1" >
                                    {{ Form::text(
                                        'email',
                                        old('email')? old('email'): $user->email,
                                        ['class' => 'form-control'])
                                    }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>在籍ステータス</th>
                            <td>
                                <div class="w-64" >
                                    {{ Form::select(
                                        'authority',
                                        Common::AUTHORITY_LIST,
                                        old('authority')? old('authority'): $user->authority_level,
                                    )}}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ session()->get(SessionConst::SELECTED_SHOP)->shop_name }}&nbsp;権限</th>
                            <td>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $userReadSelected = old('user_read')? old('user_read'): $user->userShop->userShopAuthorization->user_read
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'user_read',
                                                        $value,
                                                        ($value == $userReadSelected)? true: false,
                                                        ['id' => 'user_read_' . $value])
                                                    }}
                                                    {{ Form::label('user_read_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $userCreateSelected = old('user_create')? old('user_create'): $user->userShop->userShopAuthorization->user_create
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'user_create',
                                                        $value,
                                                        ($value == $userCreateSelected)? true: false,
                                                        ['id' => 'user_create_' . $value])
                                                    }}
                                                    {{ Form::label('user_create_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $userEditSelected = old('user_edit')? old('user_edit'): $user->userShop->userShopAuthorization->user_edit
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'user_edit',
                                                        $value,
                                                        ($value == $userEditSelected)? true: false,
                                                        ['id' => 'user_edit_' . $value])
                                                    }}
                                                    {{ Form::label('user_edit_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $userDeleteSelected = old('user_delete')? old('user_delete'): $user->userShop->userShopAuthorization->user_delete
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'user_delete',
                                                        $value,
                                                        ($value == $userDeleteSelected)? true: false,
                                                        ['id' => 'user_delete_' . $value])
                                                    }}
                                                    {{ Form::label('user_delete_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $customerReadSelected = old('customer_read')? old('customer_read'): $user->userShop->userShopAuthorization->customer_read
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'customer_read',
                                                        $value,
                                                        ($value == $customerReadSelected)? true: false,
                                                        ['id' => 'customer_read_' . $value])
                                                    }}
                                                    {{ Form::label('customer_read_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $customerCreateSelected = old('customer_create')? old('customer_create'): $user->userShop->userShopAuthorization->customer_create
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'customer_create',
                                                        $value,
                                                        ($value == $customerCreateSelected)? true: false,
                                                        ['id' => 'customer_create_' . $value])
                                                    }}
                                                    {{ Form::label('customer_create_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $customerEditSelected = old('customer_edit')? old('customer_edit'): $user->userShop->userShopAuthorization->customer_edit
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'customer_edit',
                                                        $value,
                                                        ($value == $customerEditSelected)? true: false,
                                                        ['id' => 'customer_edit_' . $value])
                                                    }}
                                                    {{ Form::label('customer_edit_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $customerDeleteSelected = old('customer_delete')? old('customer_delete'): $user->userShop->userShopAuthorization->customer_delete
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'customer_delete',
                                                        $value,
                                                        ($value == $customerDeleteSelected)? true: false,
                                                        ['id' => 'customer_delete_' . $value])
                                                    }}
                                                    {{ Form::label('customer_delete_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $reserveReadSelected = old('reserve_read')? old('reserve_read'): $user->userShop->userShopAuthorization->reserve_read
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'reserve_read',
                                                        $value,
                                                        ($value == $reserveReadSelected)? true: false,
                                                        ['id' => 'reserve_read_' . $value])
                                                    }}
                                                    {{ Form::label('reserve_read_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $reserveCreateSelected = old('reserve_create')? old('reserve_create'): $user->userShop->userShopAuthorization->reserve_create
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'reserve_create',
                                                        $value,
                                                        ($value == $reserveCreateSelected)? true: false,
                                                        ['id' => 'reserve_create_' . $value])
                                                    }}
                                                    {{ Form::label('reserve_create_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $reserveEditSelected = old('reserve_edit')? old('reserve_edit'): $user->userShop->userShopAuthorization->reserve_edit
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'reserve_edit',
                                                        $value,
                                                        ($value == $reserveEditSelected)? true: false,
                                                        ['id' => 'reserve_edit_' . $value])
                                                    }}
                                                    {{ Form::label('reserve_edit_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            @php
                                                $reserveDeleteSelected = old('reserve_delete')? old('reserve_delete'): $user->userShop->userShopAuthorization->reserve_delete
                                            @endphp
                                            @foreach(Common::AUTHORIZATION_LIST AS $value => $name)
                                                <div class="" >
                                                    {{ Form::radio(
                                                        'reserve_delete',
                                                        $value,
                                                        ($value == $reserveDeleteSelected)? true: false,
                                                        ['id' => 'reserve_delete_' . $value])
                                                    }}
                                                    {{ Form::label('reserve_delete_' . $value, $name) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="flex mt-4">
                        <input type="submit" value="更新" class="edit-btn">
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</x-user-layout>

