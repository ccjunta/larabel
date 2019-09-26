<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    // 一覧表示の画面を返す
    public function index()
    {
        // diariesテーブルのデータを全件取得
        // allメソッド：全件データを取得するメソッド
        $diaries = Diary::all();

        // dd($diaries);   // var_dump + 処理をここで中断
        // view('フォルダ名.ファイル名(blade.phpは除く)')
        return view('diaries.index', [
            'diaries' => $diaries
        ]);
    }

    // 新規追加の画面を表示するメソッド
    public function create()
    {
        return view('diaries.create');
    }

    // 新規追加の画面で投稿ボタンが押された時、
    // 投稿処理をするメソッド
// app/Http/Controllers/DiaryController


    public function store(CreateDiary $request)
    {
        $diary = new Diary(); //Diaryモデルをインスタンス化

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id; //追加 ログインしてるユーザーのidを保存
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    //削除を実行する idを取得する必要がある int型 //Modelの削除
    public function destroy(Diary $diary)
    {
        //dd($id);

        //Diaryモデルを使って、削除したい要素の取得 firstでもできたよ
        //$diary = \App\Diary::find($id);
        //取得した要素の削除
        $diary->delete();
        //一覧の画面に戻る
        return redirect()->route('diary.index');
    }

    //編集画面を表示するメソッド 選択したIDを取得 =//$diary = \App\Diary::find($id);
    public function edit(Diary $diary)
    {
        //$diary = \App\Diary::find($id);
        //dd($id);
        //IDをもとに１件を投稿を取得
        //$diary = \App\Diary::find($id);
        //編集画面氷刃するとき取得結果を返す
        //dd($diary);
        if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }
        
        return view('diaries.edit', ['diary' => $diary]); 
        //return view('diaries.edit');
    }

    //編集処理をするメソッド
    public function update(CreateDiary $request,Diary $diary)
    {
            //$diary = Diary::find($id); 
            //IDをもとに投稿のタイトル、本文を更新,タイトルや本文リクエストが持っている
            $diary->title = $request->title;
            $diary->body = $request->body;
            $diary->save();
            // 一覧ページにリダイレクト
            // 戻った時のフォームを再送信しますか？戻るを押した時にもう一回をの対策のため
            return redirect()->route('diary.index');
    }

}
