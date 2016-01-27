/* jshint laxcomma:true, laxbreak:true*/
var express      = require('express')
    , bodyParser = require('body-parser')
    , app        = express()
    , routes     = require('./routes.js')
    ;

app.use(bodyParser.json());

// routes
app.post('/check-all', routes.checkAll );
app.post('/check-dimensions', routes.checkDimensions );

// start sever
app.listen(8080);
console.log('Listening on port 8080...');
