<x-user-layout>
    <x-slot name="header"><h2>スタッフ登録</h2></x-slot>
    <div class="p-4">
        <div class="p-4">
            <div class="p-4">
                <table class="w-1/2 m-auto user_search_tbl" >
                    <tr>
                        <th>名前</th>
                        <td>
                            <div class="w-full pr-1" >{{ $user->name }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            <div class="w-full pr-1" >{{ $user->email }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>在籍ステータス</th>
                        <td>
                            <div class="w-full pr-1" >{{ Common::AUTHORITY_LIST[$user->authority_level] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ session()->get(SessionConst::SELECTED_SHOP)->shop_name }}&nbsp;権限</th>
                        <td>
                            <div class="flex" >
                                <div class="w-32" >スタイリスト閲覧</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->user_read] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >スタイリスト作成</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->user_create] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >スタイリスト編集</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->user_edit] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >スタイリスト削除</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->user_delete] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >顧客閲覧</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->customer_read] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >顧客作成</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->customer_create] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >顧客編集</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->customer_edit] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >顧客削除</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->customer_delete] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >予約閲覧</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->reserve_read] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >予約作成</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->reserve_create] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >予約編集</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->reserve_edit] }}</div>
                                </div>
                            </div>
                            <div class="flex" >
                                <div class="w-32" >予約削除</div>
                                <div class="" >
                                    <div class="w-full pr-1" >{{ Common::AUTHORIZATION_LIST[$user->userShop->userShopAuthorization->reserve_delete] }}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>他所属店舗</th>
                        <td>
                            <div class="w-full pr-1" >
                                @foreach($user->userShops AS $userShop )
                                    <div class="" >
                                        @if($userShop->shop_id == session()->get(SessionConst::SELECTED_SHOP)->id)
                                            @if(Auth::user()->userShop->userShopAuthorization->user_edit)
                                                <a href="{{ route('user.deleteBelongShop', ['user'=>$user->id]) }}" >{{ $userShop->shop->shop_name }} から権限を削除する</a>
                                            @else
                                                <span >{{ $userShop->shop->shop_name }}</span>
                                            @endif
                                        @else
                                            <span >{{ $userShop->shop->shop_name }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </table>
                @if(Auth::user()->userShop->userShopAuthorization->user_edit)
                    <div class="flex mt-4">
                        <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="normal-btn edit-btn" >編集</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-layout>

