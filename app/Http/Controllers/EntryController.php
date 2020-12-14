<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //el miw auth protege a todos los métodos de este controlador
    }

    public function create() //muestra el formulario, es una petición de tipo get
    {
        return view('entries.create');
    }

    public function store(Request $request)
    {
        //De momento solo vamos a imprimir toda la información que nos llega
        //dd($request->all());
        //return response()->json($request);
        //validate espera un arreglo con las reglas de validación
        
        $validatedData = $request->validate([
            'title' => 'required|min:7|max:255|unique:entries',
            'content' =>'required|min:25|max:3000'
        ]);
        //si pasamos la validación, vamos a proceder a crear una nueva entrada
        $entry = new Entry();
        $entry->title = $validatedData['title'];
        $entry->content = $validatedData['content'];
        $entry->user_id = auth()->id();
        $entry->save(); //INSERT

        $status = 'Your entry has been published succesfully.';
        return back()->with(compact('status'));
    }

    public function edit(Entry $entry) //muestra el formulario, es una petición de tipo get
    {
        return view('entries.edit', compact('entry'));
    }

    public function update(Request $request, Entry $entry)
    {      
        $validatedData = $request->validate([
            'title' => 'required|min:7|max:255|unique:entries,id,'.$entry->id, //Excep´to el id actual
            'content' =>'required|min:25|max:3000'
        ]);
        
        //TODO: allow edit action only for the author
        //auth()->id() === $entry->user_id;
        $entry->title = $validatedData['title'];
        $entry->content = $validatedData['content'];
        //$entry->user_id = auth()->id();
        $entry->save(); //INSERT

        $status = 'Your entry has been published succesfully.';
        return back()->with(compact('status'));
    }



}
