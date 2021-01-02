getLogin();
var id_user = 1;
var itemClicado = '';

// ESCONDENDO ABA DE MENSAGEM
document.getElementById('formConversa').classList.add('remove');

//WebSocket
var conn = new WebSocket('ws://localhost:8082');
conn.onopen = function (e) {
  console.log('Connection established!');
};

conn.onmessage = function (e) {
  console.log(e.data);
  const { name, msg } = JSON.parse(e.data);
  addMensagem(name, msg);
};

// ENVIANDO UMA MENSAGEM
document.getElementById('formConversa').addEventListener('submit', (e) => {
  e.preventDefault();
  const mensagem = document.getElementById('mensagemInput').value;
  document.getElementById('mensagemInput').value = '';
  console.log(id_user);
  addMensagem('Yan', mensagem, true);
  var data = { name: 'Yan', id_user, id_destino: itemClicado, msg: mensagem };
  const ms = JSON.stringify(data);
  conn.send(ms);
});

function conectar(id) {
  //WebSocket
  itemClicado = id;
  document.getElementById('formConversa').classList.remove('remove');
}

function getLogin() {
  $.ajax({
    url: 'http://localhost/projetos/Agenda/session',
    type: 'GET',
    success: function (result) {
      const dados = JSON.parse(result);
      const { login } = dados;
      if (login) {
        id_user = login;
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function addMensagem(name, msg, me = false) {
  const chat = document.getElementById('chatConversa');
  const msgg = document.createElement('div');
  msgg.classList.add('msg');
  if (me == true) {
    msgg.classList.add('me');
  }
  const email = document.createElement('h3');
  email.innerHTML = name;
  const texto = document.createElement('h5');
  texto.innerHTML = msg;
  msgg.appendChild(email);
  msgg.appendChild(texto);
  chat.appendChild(msgg);
}
