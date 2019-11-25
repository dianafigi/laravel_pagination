<?php

use App\Categoria;

Route::get('/', function () {
    $categorias = Categoria::all();
    foreach($categorias as $c) {
      echo "id: " . $c->id . ", ";
      echo "nome: " . $c->nome . "<br>";
    }
});

Route::get('/inserir/{nome}', function($nome) {
  $cat = new Categoria();
  $cat->nome = $nome;
  $cat->save();
  return redirect('/');
});

Route::get('/categoria/{id}', function($id) {
  $cat = Categoria::find($id);
  if (isset($cat)) {
    echo "id: " . $cat->id . ", ";
    echo "nome: " . $cat->nome . "<br>";
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});

Route::get('/actualizar/{id}/{nome}', function($id,$nome) {
  $cat = Categoria::find($id);
  if (isset($cat)) {
    $cat->nome = $nome;
    $cat->save();
    return redirect('/');
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});

Route::get('/remover/{id}', function($id) {
  $cat = Categoria::find($id);
  if (isset($cat)) {
    $cat->delete();
    return redirect('/');
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});

Route::get('/catpornome/{nome}', function($nome) {
  $cat = Categoria::where('nome',$nome)->get();
  foreach($cat as $c) {
    echo "id: " . $c->id . ", ";
    echo "nome: " . $c->nome . "<br>";
  }
});

Route::get('/catporid/{id}', function($id) {
  $cat = Categoria::where('id', '>=', $id)->get();
  foreach($cat as $c) {
    echo "id: " . $c->id . ", ";
    echo "nome: " . $c->nome . "<br>";
  }

  $count = Categoria::where('id', '>=', $id)->count();
  echo "<h1>Count: $count</h1>";
  $max = Categoria::where('id', '>=', $id)->max('id');
  echo "<h1>Max: $max</h1>";
});

Route::get('/ids124', function() {
  $cat = Categoria::find([1,2,4]);
  foreach($cat as $c) {
    echo "id: " . $c->id . ", ";
    echo "nome: " . $c->nome . "<br>";
  }
});

Route::get('/todas', function () {
  $categorias = Categoria::withTrashed()->get(); //mostra todos os ids ja registados mesmo os que ja foram apagados
  foreach($categorias as $c) {
    echo "id: " . $c->id . ", ";
    echo "nome: " . $c->nome;
    if($c->trashed()) {
      echo ' - apagado <br>';
    } else {
      echo '<br>';
    }
  }
});

Route::get('/ver/{id}', function($id) {
  // $cat = Categoria::withTrashed()->find($id);   OU
  $cat = Categoria::withTrashed()->where('id',$id)->get()->first();
  if (isset($cat)) {
    echo "id: " . $cat->id . ", ";
    echo "nome: " . $cat->nome . "<br>";
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});

Route::get('/soasapagadas', function () {
  $categorias = Categoria::onlyTrashed()->get(); //mostra apenas os ids ja apagados
  foreach($categorias as $c) {
    echo "id: " . $c->id . ", ";
    echo "nome: " . $c->nome;
    if($c->trashed()) {
      echo ' - apagado <br>';
    } else {
      echo '<br>';
    }
  }
});

Route::get('/restaurar/{id}', function($id) {
  $cat = Categoria::withTrashed()->find($id);

  if (isset($cat)) {
    $cat->restore();
    echo "Categoria restaurada: " . $cat->id . "<br>";
    echo "<a href=\"/\">Listar todas</a>";
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});

Route::get('/apagarpermanente/{id}', function($id) {
  $cat = Categoria::withTrashed()->find($id);

  if (isset($cat)) {
    $cat->forceDelete(); //apagar permanentemente apesar te se ter o softDelete
    return redirect('/todas');
  }
  else {
    echo "<h1>Categoria nao encontrada</h1>";
  }
});
