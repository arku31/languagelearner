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
        $words = Word::where('user_id', Auth::id())->get();
        $data['words'] = $words;
        $data['message'] = $request->session()->get('message');
        return view('word.index', $data);
    }

    public function store(Request $request)
    {
        Word::create([
            'word' => $request->input('word'),
            'translation' => strtolower($request->input('translation')),
            'user_id' => Auth::id(),
        ]);
        return redirect()->back();
    }

    public function learn()
    {
        $data['levelData'] = $this->calcLevel();
        return view('word.learn', $data);
    }

    public function getWords()
    {
        return Word::orderBy('practiced')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function destroy($id, Request $request)
    {
        try {
            $word = Word::findOrFail($id);
            if ($word->user_id == Auth::id()) {
                $word->delete();
                $request->session()->flash('message', [
                        'type' => 'success',
                        'msg' => 'Successefully deleted'
                    ]);
            } else {
                $request->session()->flash('message', [
                    'type' => 'danger',
                    'msg' => 'No access'
                ]);
            }
        } catch (ModelNotFoundException $e) {
            $request->session()->flash('message', [
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

    public function calcLevel()
    {
        $current = Word::where('practiced', '>', 5)
            ->where('user_id', Auth::id())
            ->count();
        $levels = $this->getLevels();
        $data['level'] = key($levels);
        $data['next'] = next($levels);
        foreach ($levels as $level => $cnt) {
            if ($current > $cnt) {
                $data['level'] = $level;
                $data['next'] = next($levels);
            }
        }
        $data['current'] = $current;

        return $data;
    }

    public function getLevels()
    {
        return [
            'A0' => 0,
            'A1' => 1000,
            'A2' => 2000,
            'B1' => 3500,
            'B2' => 5000,
            'C1' => 6500
        ];
    }
}
