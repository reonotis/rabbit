<x-user-layout>
    <x-slot name="header"><h2>スタッフ登録</h2></x-slot>
    <div class="p-4">
        <div class="p-4">
            <div class="p-4">
                <form action="{{ route('user.store') }}" method="post" >
                    @csrf
                    <table class="w-1/2 m-auto user_search_tbl" >
                        <tr>
                            <th>名前</th>
                            <td>
                                <div class="w-full pr-1" >
                                    <input type="text" name="name" value="{{ old('name') }}" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <div class="w-full pr-1" >
                                    <input type="email" name="email" value="{{ old('email') }}" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>在籍ステータス</th>
                            <td>
                                <div class="w-64" >
                                    <select name="authority" >
                                        <option value="" >選択してください</option>
                                        @foreach(Common::AUTHORITY_LIST AS $authorityId => $authority )
                                            <option value="{{$authorityId}}" >{{$authority}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="5">権限</th>
                            <td>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="user_read" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="user_read" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="user_create" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="user_create" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="user_edit" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="user_edit" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >スタイリスト削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="user_delete" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="user_delete" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="customer_read" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="customer_read" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="customer_create" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="customer_create" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="customer_edit" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="customer_edit" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >顧客削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="customer_delete" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="customer_delete" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約閲覧</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="reserve_read" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="reserve_read" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約作成</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="reserve_create" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="reserve_create" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約編集</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="reserve_edit" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="reserve_edit" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" >
                                    <div class="w-32" >予約削除</div>
                                    <div class="" >
                                        <div class="flex" >
                                            <div class="" ><label><input type="radio" name="reserve_delete" value="0" class="" >権限なし</label></div>
                                            <div class="" ><label><input type="radio" name="reserve_delete" value="1" class="" >権限あり</label></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="flex mt-4">
                        <input type="submit" value="登録" class="register-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>

