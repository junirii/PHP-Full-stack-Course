const socket = io();

let name = prompt('당신의 이름은?', '');
socket.on('connect', function() {
  if(name === '') {
    name = '익명';
  }
  socket.emit('newUser', name);
});

socket.on('newUser', function(name2){
  name = name2;
  const divMe = document.querySelector('#me');
  divMe.innerText = `${name} (나)`;
})

socket.on('update', function(data) {
  const chat = document.getElementById('chat');
  const message = chat.appendChild(document.createElement('div'));
  message.innerText = `${data.name}: ${data.message}`;
  
  let className = '';
  switch(data.type) {
    case 'message':
      className = 'other';
      break;
    case 'connect':
      className = 'connect';
      break;
    case 'disconnect':
      className = 'disconnect';
      break;
  }
  message.classList.add(className);
  chat.scrollTop = chat.scrollHeight;
});
      
socket.on('users', function(list){
  const divOthers = document.querySelector('#others');
  divOthers.innerHTML = '';

  list.forEach(function(item){
    if(name !== item){
      const divOther = divOthers.appendChild(document.createElement('div'));
      divOther.innerText = `${item} 님`;
    }
  })
})

function send() {
  const message = document.getElementById('test').value;
  
  document.getElementById('test').value = '';

  const chat = document.getElementById('chat');
  const msg = chat.appendChild(document.createElement('div'));
  msg.innerText = message;
  msg.classList.add('me');

  socket.emit('message', {type: 'message', message: message});
  chat.scrollTop = chat.scrollHeight;
}

function enter(e){
    if(e.keyCode === 13){
      send();
    }
}