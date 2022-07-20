<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Card;

//codeplaners 
class ColumnController extends Controller
{
    // all columns
    public function index()
    {
        $posts = Column::with('cards')->orderBy('id')->get()->toArray();
        return array_reverse($posts);
    }
  
    // add column
    public function add(Request $request)
    {
        $post = new Column([
            'title' => $request->input('title'),
        ]);
        $post->save();
  
        return response()->json(['message' => 'Column successfully added', 'id' => $post->id ]);
    }
  
    public function edit(Request $request){
        $newColumn = $request->input('column');
        $cards = $newColumn['cards'];
        $column = Column::find($newColumn['id']);
        $column->cards()->delete();

        foreach ( $cards as $key => $card) {
            $newCard = new Card;
            $newCard->title = $card['title'];
            $newCard->description = $card['description'];
            $newCard->order = $key;
            $newCard->column_id = $newColumn['id'];
            $newCard->save();
        }
    }
  
    // delete Column
    public function delete($id)
    {
        $post = Column::find($id);
        $post->delete();
  
        return response()->json('Column successfully deleted');
    }
}
