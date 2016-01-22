/* jshint laxcomma:true, laxbreak:true*/
var PythonShell   = require('python-shell')
    , fs          = require('fs')
    , SCRIPT_PATH = __dirname + '/stl_normalize'
    ;

module.exports =
{
    /**
     * Execute validation
     */
    run : function(file, cb)
    {
        // check if the file exists
        fs.stat(file, function(err, stats)
        {
            if(err || !stats.isFile())
            {
                cb({ "status" : "file not exist", "code" : 1 });
            }
            else
            {
                stl_normalize(file, function(result)
                {
                    cb(result);
                });
            }
        });
    }
};

/* private functions */

/**
 * Run "stl_normalize" script
 */
var stl_normalize = function(file, cb)
{
    var options =
    {
        scriptPath : SCRIPT_PATH
        , args: ['-c', file]
    };

    // call python scripts
    PythonShell.run('stl_normalize.py', options, function (err, results)
    {
        console.log(err);
        // TODO séparer et identifier les différents types d'erreurs
        if (err) // invalid model
        {
            console.log('INVALID - File "' + file + '" contains a non-manifold model');
            cb({"status" : "invalid model", "code" : 2 });
        }
        else // valid model
        {
            console.log('VALID - File "' + file + '"');
            cb({"status" : "valid model", "code" : 0 });
        }
    });
};
