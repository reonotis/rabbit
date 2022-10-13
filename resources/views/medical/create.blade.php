<x-medical-layout>

    <div class="p-4">
        <div class="medical-recode-create">

            {{ Form::open(['route' => ['medical.store', 'shop' => $shop->id]]) }}

                <div class="mt-2 mb-8 text-center font-bold text-lg	" >
                    {{ $shop->shop_name }}へのご来店ありがとうございます。<br>
                    カルテを作成しますので、下記フォームから登録後スタッフにお声かけ下さい
                </div>
                <div class="input-row" >
                    <div class="input-title" >お名前</div>
                    <div class="input-contents" >
                        <div class="flex" >
                            <div class="w-1/2" >
                                {{ Form::text('f_name', old('f_name'), [
                                        'class' => 'form-control',
                                        'placeholder'=>'田中',
                                   ])
                                }}
                            </div>
                            <div class="w-1/2" >
                                {{ Form::text('l_name', old('l_name'), [
                                        'class' => 'form-control',
                                        'placeholder'=>'太郎',
                                   ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-row" >
                    <div class="input-title" >オナマエ</div>
                    <div class="input-contents" >
                        <div class="flex" >
                            <div class="w-1/2" >
                                {{ Form::text('f_read', old('f_read'), [
                                        'class' => 'form-control',
                                        'placeholder'=>'タナカ',
                                   ])
                                }}
                            </div>
                            <div class="w-1/2" >
                                {{ Form::text('l_read', old('l_read'), [
                                        'class' => 'form-control',
                                        'placeholder'=>'タロウ',
                                   ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-row" >
                    <div class="input-title" >性別</div>
                    <div class="input-contents" >
                        <div class="flex" >
                            <label><input type="radio" name="sex" >男性</label>
                            <label><input type="radio" name="sex" >女性</label>
                            <label><input type="radio" name="sex" >その他</label>
                            <label><input type="radio" name="sex" >未回答</label>
                        </div>
                    </div>
                </div>
                <div class="input-row" >
                    <div class="input-title" >メールアドレス</div>
                    <div class="input-contents" >
                        <input type="email" name="email" placeholder="tanaka@example.com" >
                    </div>
                </div>
                <div class="input-row" >
                    <div class="input-title" >電話番号</div>
                    <div class="input-contents" >
                        <input type="text" name="tel" placeholder="090-1234-5678" >
                    </div>
                </div>
                <div class="input-row" >
                    <div class="input-title" >住所</div>
                    <div class="input-contents" >
                        <div class="flex pb-1 items-center" >
                            <div class="w-20" >
                                <input type="text" name="tel" placeholder="100" >
                            </div>
                            &nbsp; - &nbsp;
                            <div class="w-24" >
                                <input type="text" name="tel" placeholder="0001" >
                            </div>
                        </div>
                        <div class="flex pb-1" >
                            <div class="w-32 mr-2" >
                                <input type="text" name="tel" placeholder="東京都" >
                            </div>
                            <div class="w-40" >
                                <input type="text" name="tel" placeholder="" >
                            </div>
                        </div>
                        <div class="w-full" >
                            <input type="text" name="tel" placeholder="" >
                        </div>
                    </div>
                </div>
                <div class="flex" >
                    <input type="submit" value="登録" class="register-btn">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</x-medical-layout>

