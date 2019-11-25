<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <title>Paginação</title>
        <style>
          body {
            padding: 20px;
          }
        </style>
    </head>
    <body>
      <div class="container">
        <div class="card tex-center">
          <div class="card-header">
            Tabela de Clientes
          </div>
          <div class="card-body">
            <h5 class="card-title" id="cardTitle"></h5>
            <table class="table table-hover" id="tabelaClientes">
              <thead>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Sobrenome</th>
                <th scope="col">E-mail</th>
              </thead>
              <tbody>
                  <tr>
                    <td>1</td>
                    <td>Di</td>
                    <td>Silva</td>
                    <td>di@gmail.com</td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <nav id="paginator">
              <ul class="pagination">
                <!-- <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <script src="{{asset('js/app.js')}}" type="text/javascript"></script>

      <script type="text/javascript">

          function getItemProximo(pagina) {
            i = pagina.current_page + 1;
            if (pagina.current_page == pagina.last_page) { //current_page vem do json, pode ser visto no inspect, corresponde à pagina q está a ser vista. Se os dados sao apresentados de 10 em 10, se a pagina q está a ser vista é a 2, vai mostrar os dados com id de 11 a 20.
              s = '<li class="page-item disabled"> ';
            } else {
              s = '<li class="page-item"> ';
            }
            s += '<a class="page-link"' + 'pagina ="' + i + '" href="#">Próximo</a></li>'; //criámos o atributo pagina
            return s;
          };

          function getItemAnterior(pagina) {
            i = pagina.current_page - 1;
            if (pagina.current_page == 1) { //current_page vem do json, pode ser visto no inspect, corresponde à pagina q está a ser vista. Se os dados sao apresentados de 10 em 10, se a pagina q está a ser vista é a 2, vai mostrar os dados com id de 11 a 20.
              s = '<li class="page-item disabled"> ';
            } else {
              s = '<li class="page-item"> ';
            }
            s += '<a class="page-link"' + 'pagina ="' + i + '" href="#">Anterior</a></li>';  //criámos o atributo pagina
            return s;
          };

          function getItem(pagina, i) {
            if (i == pagina.current_page) { //current_page vem do json, pode ser visto no inspect, corresponde à pagina q está a ser vista. Se os dados sao apresentados de 10 em 10, se a pagina q está a ser vista é a 2, vai mostrar os dados com id de 11 a 20.
              s = '<li class="page-item active"> ';
            } else {
              s = '<li class="page-item"> ';
            }
            s += '<a class="page-link"' + 'pagina ="' + i + '" href="#">' + i + '</a></li>';  //criámos o atributo pagina
            return s;
          };

          function montarPaginator(data) {
            $('#paginator>ul>li').remove(); //como se esta a usar ajax e se está a fazer append que acrescenta À tabela, tem de se limpar sempre primeiro antes de carregar o q se pretende senao vai mostrar aqueles appends todos.
            $('#paginator>ul').append(getItemAnterior(data));

            n = 10;
            if (data.current_page - n/2 <= 1) {
              inicio = 1;
            } else if (data.last_page - data.current_page < n) {
              inicio = data.last_page - (n-1); //ou data.last_page - n + 1
            } else {
              inicio = data.current_page - n/2;
            }

            fim = inicio + n - 1;
            for(i=inicio; i<=fim; i++) { //(i=1; i<data.total; i++) tb pode ser assim -> total vem do json, pode ser visto no inspect, é 1000 correspondendo com o numero clientes registados na db.
              s = getItem(data, i);
              $('#paginator>ul').append(s);
            }

            $('#paginator>ul').append(getItemProximo(data));
          };

          function montarLinha(cliente) {
            return '<tr>' +
              '<td>' + cliente.id + '</td>' +
              '<td>' + cliente.nome + '</td>' +
              '<td>' + cliente.sobrenome + '</td>' +
              '<td>' + cliente.email + '</td>' +
            '</tr>';
          };

          function montarTabela(info) {
            $("#tabelaClientes>tbody>tr").remove(); //como se esta a usar ajax e se está a fazer append que acrescenta À tabela, tem de se limpar sempre primeiro antes de carregar o q se pretende senao vai mostrar aqueles appends todos.
            for(i=0; i<info.data.length; i++) { //data é um array com a info de cada cliente, dá para ver no inspect
              linha = montarLinha(info.data[i]);
              $("#tabelaClientes>tbody").append(linha);
            }
          };

          function carregarClientes(pagina) {
            $.get('/json', {page: pagina}, function(resp) { //page é um parametro proprio da paginaçao (paginate()) do laravel, surge no url.
              console.log(resp);
              montarTabela(resp);
              montarPaginator(resp);
              $('#paginator>ul>li>a').click(function(event) {
                event.preventDefault();
                carregarClientes($(this).attr('pagina'));
              });
              $('#cardTitle').html('Exibindo ' + resp.per_page + 'clientes de ' + resp.total + " ( " + resp.from + ' a ' + resp.to + ' ) ');
            });
          };

          $(function() {
            carregarClientes(2);
          });

      </script>
    </body>
</html>
