/* jshint laxcomma:true, laxbreak:true*/
var validator = require('./validation/validator.js');

module.exports =
{
    /**
     * Check a STL/OBJ file
     * POST request must contain a JSON object: { 'file' : 'path/to/file/mymodel.stl' }
     * @return a JSON object with the result of the validation
     *  response format: { 'status' : <status>, 'code' : <code> }
     *  status: 'bad request' or 'valid' or 'invalid'
     *  code:
     *      -1 -> bad request / bad parameters
     *      0  -> model is valid
     *      1  -> file not exists
     *      2  -> model is not valid (contains non-manifold elements)
     */
    check : function(req, res)
    {
        if(typeof req.body === 'undefined' || typeof req.body.file === 'undefined')
        {
            res.send( { 'status' : 'bad request', 'code' : -1 });
        }
        else
        {
            // execute validation
            validator.run(req.body.file, function(result)
            {
                // send result
                res.send(result);
            });
        }

    }
};
