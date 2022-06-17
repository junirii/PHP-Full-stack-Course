const socket = io();

socket.on('connect', function() {
  const name = prompt('반갑습니다!', '');
  if(!name) {
    name = '익명';
  }
  socket.emit('newUser', name);
});

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
});

function send() {
  const message = document.getElementById('test').value;
  
  document.getElementById('test').value = '';

  const chat = document.getElementById('chat');
  const msg = chat.appendChild(document.createElement('div'));
  msg.innerText = message;
  msg.classList.add('me');

  socket.emit('message', {type: 'message', message: message});
}
