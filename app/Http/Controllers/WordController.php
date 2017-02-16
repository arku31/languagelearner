<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;

class WordController extends Controller
{
    public function create()
    {
        return view('word.create');
    }
    public function index(Request $request)
    {
        $words = Word::all();
        $data['words'] = $words;
        $data['message'] = $request->session()->get('message');
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

    public function destroy($id, Request $request)
    {
        try {
            $word = Word::findOrFail($id);
            if ($word->user_id == Auth::id()) {
                $word->delete();
                $request->session()->flash('message',
                    [
                        'type' => 'success',
                        'msg' => 'Successefully deleted'
                    ]);
            } else {
                $request->session()->flash('message',  [
                    'type' => 'danger',
                    'msg' => 'No access'
                ]);
            }
        } catch (ModelNotFoundException $e) {
            $request->session()->flash('message',  [
                'type' => 'danger',
                'msg' => 'Word Not found'
            ]);
        }


        return redirect()->back();


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
