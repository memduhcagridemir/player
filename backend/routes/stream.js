var fs = require('fs');
var express = require('express');
var router = express.Router();


router.get('/listen', function(req, res, next) {
    var filePath = '/vagrant/dic6.mp3';
    var stat = fs.statSync(filePath);

    res.writeHead(200, {
        'Content-Type': 'audio/mpeg',
        'Content-Length': stat.size
    });

    fs.createReadStream(filePath).pipe(res);
});

module.exports = router;