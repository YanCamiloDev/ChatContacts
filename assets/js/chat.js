var conn;
var itemClicado = '';
var conn_status = false;

// ESCONDENDO ABA DE MENSAGEM
document.getElementById('formConversa').classList.add('remove');

// ENVIANDO UMA MENSAGEM
document.getElementById('formConversa').addEventListener('submit', (e) => {
  e.preventDefault();
  const msg = document.getElementById('mensagemInput').value;
  console.log(msg);
  console.log('ITEM: ', itemClicado);
  var data = { name: 'YAN', message: msg };

  conn.publish(itemClicado, data);
});

function conectar(id) {
  if (conn_status) {
    conn.close();
    conn_status = false;
  }
  itemClicado = id;
  document.getElementById('formConversa').classList.remove('remove');
  console.log('ITEM CLICADO: ', String(id));
  conn = new ab.Session(
    'ws://localhost:8082',
    function () {
      conn_status = true;
      // SE CONECTANDO A UM CHAT
      conn.subscribe(String(id), function (topic, data) {
        console.log(data);
        if (typeof data === 'string') {
          data = JSON.parse(data);

          // LISTANDO AS MENSAGENS DO CHAT
          for (var i = 0; i < data.length; i++) {
            console.log(data[i]);
          }
        } else {
          console.log(data);
        }
      });
    },
    function () {
      console.warn('WebSocket connection closed');
    },
    { skipSubprotocolCheck: true }
  );
}

//const array = document.querySelectorAll('button.contato');
//array.forEach((item) => {
//  console.log(item.value);
//});
