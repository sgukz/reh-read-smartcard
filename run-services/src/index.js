const path = require('path');
const {
  publicDir
} = require('./helper/path');
const app = require('express')();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const smc = require('./smc');

const PORT = process.env.SMC_AGENT_PORT || 3000;

if (app.env === 'production') {
  io.origins([`localhost:${PORT}`]);
}

if (app.env !== 'production') {
  app.get('/', (req, res) => {
    res.sendFile(path.join(publicDir, 'example.html'));
  });
}

io.on('connection', socket => {
  console.log(`New connection from ${socket.id}`);
  setTimeout(() => {
    smc.init(io);
    socket.on("set-query", (data = {}) => {
      const { query = undefined } = data;
      console.log(`set-query: ${query}`);
      smc.setQuery(query);
    });
  }, 1000);


  socket.on('set-all-query', (data = {}) => {
    const {
      query = undefined
    } = data;
    console.log(`set-query: ${query}`);
    smc.setQuery(query);
  });

  socket.on('disconnect', () => {
    console.log('client disconnected');
  });
});

server.listen(PORT, () => {
  console.log(`listening on *:${PORT}`);
});