<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function create()
    {
        return view('word.create');
    }
    public function index()
    {
        $words = Word::all();
        $data['words'] = $words;
        return view('word.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'word' => 'unique:words'
        ]);
        Word::create([
            'word' => $request->input('word'),
            'translation' => strtolower($request->input('translation')),
            'user_id' => Auth::id(),
        ]);
        return redirect()->back();
    }

    public function learn()
    {
        return view('word.learn');
    }

    public function getWords()
    {
        return Word::orderBy('practiced')
            ->get();
    }

    public function post(Request $request)
    {
        $word_id = $request->input('word_id');
        $word = Word::find($word_id);
        $word->practiced++;
        $word->save();
        return [];
    }
}
