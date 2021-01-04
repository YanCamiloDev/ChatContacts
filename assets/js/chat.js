getLogin();
var dadosDoUsuario = 1;
var itemClicado = '';

// ESCONDENDO ABA DE MENSAGEM
document.getElementById('formConversa').classList.add('remove');

//WebSocket
var conn = new WebSocket('ws://localhost:8082');

conn.onopen = function (e) {
  var data = {
    resource: true,
    id: dadosDoUsuario.id_user,
  };
  const ms = JSON.stringify(data);
  conn.send(ms);
  console.log('Connection estabelecida!');
};

conn.onmessage = function (e) {
  const { name, msg, sair } = JSON.parse(e.data);
  if (sair) {
    window.location = 'http://localhost/projetos/Agenda';
  }
  addMensagem(name, msg);
};

// ENVIANDO UMA MENSAGEM
document.getElementById('formConversa').addEventListener('submit', (e) => {
  e.preventDefault();
  const mensagem = document.getElementById('mensagemInput').value;
  document.getElementById('mensagemInput').value = '';
  addMensagem(dadosDoUsuario.nome, mensagem, true);
  var data = {
    name: dadosDoUsuario.nome,
    id_user: dadosDoUsuario.id_user,
    id_destino: itemClicado,
    msg: mensagem,
  };
  const ms = JSON.stringify(data);
  conn.send(ms);
});

function getMessagesToUser(idUser, idDestino) {
  clearMsg();
  $.ajax({
    url: `http://localhost/projetos/Agenda/api/mensagens/${idUser}/${idDestino}`,
    type: 'GET',
    success: function (result) {
      const js = JSON.parse(result);
      console.log(js);
      js.map((element) => {
        const { nome_remetente, mensagem } = element;
        if (nome_remetente === dadosDoUsuario.nome) {
          addMensagem(nome_remetente, mensagem, true);
        } else {
          addMensagem(nome_remetente, mensagem);
        }
      });
      //console.log(result);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function getLogin() {
  $.ajax({
    url: 'http://localhost/projetos/Agenda/session',
    type: 'GET',
    success: function (result) {
      const dados = JSON.parse(result);
      const { login } = dados;
      const dadosUser = JSON.parse(login);
      if (login) {
        dadosDoUsuario = dadosUser;
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}

// LIMPANDO AS MENSAGENS
function clearMsg() {
  var elemento = document.getElementById('chatConversa');
  while (elemento.firstChild) {
    elemento.removeChild(elemento.firstChild);
  }
}

function addMensagem(name, msg, me = false) {
  const chat = document.getElementById('chatConversa');
  const msgg = document.createElement('div');
  msgg.classList.add('msg');
  msgg.id = 'msg';
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

function conectar(id) {
  const idUsuario = dadosDoUsuario.id_user;
  const idDestino = id;
  getMessagesToUser(idUsuario, idDestino);
  //WebSocket
  itemClicado = id;
  document.getElementById('formConversa').classList.remove('remove');
}
