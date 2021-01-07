getLogin();
var dadosDoUsuario = 1;
var itemClicado = '';

// ESCONDENDO ABA DE MENSAGEM
document.getElementById('formConversa').classList.add('remove');

//WebSocket
var conn = new WebSocket('ws://localhost:8082');

// CONEXÃO REALIZADA
conn.onopen = function (e) {
  var data = {
    resource: true,
    id: dadosDoUsuario.id_user,
  };
  const ms = JSON.stringify(data);
  conn.send(ms);
  console.log('Connection estabelecida!');
};

//Nova menssagem RECEBIDA
conn.onmessage = function (e) {
  const { name, msg, sair } = JSON.parse(e.data);
  if (sair) {
    window.location = 'http://localhost/projetos/Agenda';
  }
  addMensagem(name, msg);
  addUltimaMsgAndHorario(msg);
};

// ENVIANDO UMA NOVA MENSAGEM
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
  addUltimaMsgAndHorario(mensagem);
});

// PEGANDO MENSAGENS TROCADAS COM UM CONTATO
function getMessagesToUser(idUser, idDestino) {
  clearMsg();
  $.ajax({
    url: `http://localhost/projetos/Agenda/api/mensagens/${idUser}/${idDestino}`,
    type: 'GET',
    success: function (result) {
      const js = JSON.parse(result);
      js.map((element) => {
        const { id_mensagem, nome_remetente, mensagem } = element;
        if (nome_remetente === dadosDoUsuario.nome) {
          addMensagem(nome_remetente, mensagem, true, id_mensagem);
        } else {
          addMensagem(nome_remetente, mensagem, false, id_mensagem);
        }
      });
    },
    error: (err) => {
      console.log(err);
    },
  });
}

// DADOS DO USUÁRIO LOGADO
function getLogin() {
  $.ajax({
    url: 'http://localhost/projetos/Agenda/session',
    type: 'GET',
    success: function (result) {
      const dados = JSON.parse(result);
      const { login } = dados;
      const dadosUser = JSON.parse(login);
      var elemento = document.getElementById('info');
      var e = document.createElement('img');
      e.src = `http://localhost/projetos/Agenda/storage/perfil/ ${dadosUser.foto_perfil}`;
      elemento.appendChild(e);
      console.log(dadosUser);
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
  try {
    var elemento = document.getElementById('chatConversa');
    elemento.scrollHeight = elemento.scrollTop;
    while (elemento.firstChild) {
      elemento.removeChild(elemento.firstChild);
    }
  } catch (error) {
    console.log('erro: ', error);
  }
}

// LEVANDO SCROLL ATÉ A MENSSAGEM MAIS RECENTE
function scroll() {
  var element = document.getElementById('chatConversa');
  element.scrollIntoView();
  element.scrollIntoView(false);
  element.scrollIntoView({ block: 'end' });
  element.scrollIntoView({ block: 'end', behavior: 'smooth' });
}

// ATUALIZANDO ÚLTIMA MENSAGEM ENVIADA
function addUltimaMsgAndHorario(msg) {
  const element = document.getElementById(itemClicado);
  const v = element.getElementsByClassName('u_m')[0];
  v.innerHTML = msg;
  const element2 = document.getElementById(itemClicado);
  const v2 = element2.getElementsByClassName('u_h')[0];
  const data = `${new Date().getHours()}:${new Date().getMinutes()}`;
  v2.innerHTML = data;
  v.classList.add('color');
  v2.classList.add('color');
  setTimeout(() => {
    v2.classList.remove('color');
    v.classList.remove('color');
  }, 5000);
}

// ADICIONANDO NOVA MENSAGEM NA TELA
function addMensagem(name, msg, me = false, id = Math.random()) {
  const chat = document.getElementById('chatConversa');
  const msgg = document.createElement('div');
  msgg.classList.add('msg');
  msgg.id = id;
  if (me == true) {
    msgg.classList.add('me');
  }
  const texto = document.createElement('h5');
  texto.innerHTML = msg;
  texto.classList.add('texto');
  msgg.appendChild(texto);
  chat.appendChild(msgg);
  scroll();
}

// CONECTANDO CONTATO
function conectar(id) {
  const idUsuario = dadosDoUsuario.id_user;
  const idDestino = id;
  getMessagesToUser(idUsuario, idDestino);
  //WebSocket
  itemClicado = id;
  document.getElementById('formConversa').classList.remove('remove');
}
