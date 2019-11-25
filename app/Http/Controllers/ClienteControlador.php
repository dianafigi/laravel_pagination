<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteControlador extends Controller
{
/*
     public function index()
     {
      //METODO 1 :
        // $clientes = Cliente::all(); - Forma normal de chamar todos os dados de 'clientes'
        //$clientes = Cliente::paginate(10); // - Forma de chamar todos os dados de 'clientes' e ainda utilizar a paginaçao do laravel.
        //return view('index', compact('clientes'));
     }
*/

    public function indexjs()
    {
      return view('indexjs');
    }

    public function indexjson()
    {
      return Cliente::paginate(10);
    }




    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
